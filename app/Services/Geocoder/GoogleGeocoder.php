<?php

namespace App\Services\Geocoder;

use GuzzleHttp\Client;
use App\Services\Geocoder\Exceptions\NoResult;
use App\Services\Geocoder\Exceptions\InvalidKey;
use App\Services\Geocoder\Exceptions\AccessDenied;
use App\Services\Geocoder\Exceptions\QuotaExceeded;

class GoogleGeocoder
{
    protected $endpoint = 'https://maps.googleapis.com/maps/api/geocode/json?';
    protected $client;

    public function __construct(Client $client, $language = null, $region = null)
    {
        $this->client = $client;
        $this->endpoint = $this->buildQuery('key', config('geocoder.key'));
        $this->addOptionalQueryParameters($language, $region);
    }

    public function geocode($address)
    {
        $query = $this->buildQuery('address', $address);
        $response = $this->validateResponse(
            $this->getResponse($query)
        );

        return $this->buildResults($response['results']);
    }

    public function reverseByPlaceId($placeId)
    {
        $query = $this->buildQuery('place_id', $placeId);
        $response = $this->validateResponse(
            $this->getResponse($query)
        );

        return $this->buildResults($response['results']);
    }

    public function reverseByCoordinates($latitude, $longitude)
    {
        $query = $this->buildQuery('address', "{$latitude},{$longitude}");
        $response = $this->validateResponse(
            $this->getResponse($query)
        );

        return $this->buildResults($response['results']);
    }

    private function addOptionalQueryParameters($language, $region)
    {
        if ($language) {
            $this->endpoint = $this->buildQuery('language', $language);
        }

        if ($region) {
            $this->endpoint = $this->buildQuery('region', $region);
        }
    }

    private function buildQuery($key, $value)
    {
        return sprintf('%s&%s=%s', $this->endpoint, $key, rawurlencode($value));
    }

    private function getResponse($endpoint)
    {
        return json_decode($this->client->get($endpoint)->getBody(), true);
    }

    private function validateResponse($response)
    {
        if (!isset($response)) {
            throw new NoResult(sprintf('Could not execute query'));
        }

        if ('REQUEST_DENIED' === $response['status'] && 'The provided API key is invalid.' === $response['error_message']) {
            throw new InvalidKey(sprintf('API key is invalid'));
        }

        if ('REQUEST_DENIED' === $response['status']) {
            throw new AccessDenied(sprintf('API access denied. Message: %s', $response['error_message']));
        }

        // you are over your quota
        if ('OVER_QUERY_LIMIT' === $response['status']) {
            throw new QuotaExceeded('Daily quota exceeded');
        }

        // no result
        if (!isset($response['results']) || !count($response['results']) || 'OK' !== $response['status']) {
            throw new NoResult('No results for query');
        }

        return $response;
    }

    private function buildResults($results)
    {
        return array_map(function ($result) {
            $coordinates = $result['geometry']['location'];
            $data = [
                'address' => $result['formatted_address'],
                'latitude' => $coordinates['lat'],
                'longitude' => $coordinates['lng'],
                'place_id' => $result['place_id'],
                'types' => $result['types'],
                'address_components' => $this->buildAddressComponents($result)
            ];

            if (isset($result['geometry']['bounds'])) {
                $bounds = $result['geometry']['bounds'];
                $data['bounds'] = [
                    'northeast' => [
                        'latitude' => $bounds['northeast']['lat'],
                        'longitude' => $bounds['northeast']['lng'],
                    ],
                    'southwest' => [
                        'latitude' => $bounds['southwest']['lat'],
                        'longitude' => $bounds['southwest']['lng'],
                    ]
                ];
            }

            return $data;
        }, $results);
    }
    private function buildAddressComponents($result)
    {
        $test = [];

        foreach ($result['address_components'] as $component) {
            $test[$component['types'][0]] = $component['long_name'];
        }

        return $test;
    }
}
