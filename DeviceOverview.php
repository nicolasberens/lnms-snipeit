<?php

namespace App\Plugins\snipeit;

use App\Plugins\Hooks\DeviceOverviewHook;

use LibreNMS\Config;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class DeviceOverview extends DeviceOverviewHook
{
    public function authorize(\App\Models\User $user, \App\Models\Device $device): bool
    {
        if (isset($device->serial) and Config::get('snipeit.api_host') and Config::get('snipeit.api_token')) {
            return true;
        }
        else {
            return false;
        }
    }

    public function data(\App\Models\Device $device): array
    {

        $api_host = Config::get('snipeit.api_host');
        $api_url = "https://$api_host/api/v1/";
        $api_token = Config::get('snipeit.api_token');

        # Strip whitespace from serial, some devices report it in a weird way (looking at you, Supermicro)
        $serial = preg_replace('/\s+/', '', $device->serial);


        $httpClient = new Client();
        $response = $httpClient->get(
            $api_url . 'hardware/byserial/' . $serial,
            [
                RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $api_token,
                ]
            ]
        );

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents(), true);
            if (!isset($data['status']) && $data['status'] != 'error') {
                return [
                    'title' => 'Snipe-IT',
                    'device' => $device,
                    'found' => true,
                    'data' => $data['rows'],
                    'api_host' => $api_host,
                ];
            }
        }

        return [
            'found' => false,
        ];

    }
}
