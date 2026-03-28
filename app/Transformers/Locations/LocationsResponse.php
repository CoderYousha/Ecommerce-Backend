<?php

namespace App\Transformers\Locations;

class LocationsResponse {
    public static function format ($locations) {
        $data = ['locations' => []];

        foreach ($locations as $location){
            $data['locations'][] = [
                'id' => $location->id,
                'city' => $location->city,
                'street' => $location->street,
                'building' => $location->building,
                'floor' => $location->floor,
            ];
        }

        return $data;
    }
}