<?php

namespace App\Services;

use App\Models\Location;
use App\Transformers\Locations\LocationResponse;
use App\Transformers\Locations\LocationsResponse;
use Illuminate\Support\Facades\Auth;

class LocationService {
    public function createLocation ($data) {
        $user = Auth::guard('user')->user();
        $data['user_id'] = $user->id;

        $location = Location::create($data);

        return success(LocationResponse::format($location), 'Location created successfully', 201);
    }

    public function updateLocation (Location $location, $data){
        $location->update($data);

        return success(LocationResponse::format($location), 'Location updated successfully');
    }

    public function deleteLocation (Location $location){
        $location->delete();

        return success(null, 'Location deleted successfully');
    }

    public function getLocations (){
        $user = Auth::guard('user')->user();
        $locations = $user->locations()->orderBy('created_at', 'desc')->get();

        return success(LocationsResponse::format($locations), 'Locations information');
    }

    public function getLocation (Location $location){
        return success(LocationResponse::format($location), 'Location information');
    }
}