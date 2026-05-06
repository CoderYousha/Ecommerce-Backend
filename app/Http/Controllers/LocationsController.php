<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationsRequests\CreateLocationRequest;
use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    //Create Location Function
    public function store (CreateLocationRequest $createLocationRequest){
        return $this->locationService->createLocation($createLocationRequest->all());
    }

    //Update Location Function
    public function update (Location $location, CreateLocationRequest $createLocationRequest){
        return $this->locationService->updateLocation($location, $createLocationRequest->all());
    }

    //Delete Location Function
    public function delete (Location $location){
        return $this->locationService->deleteLocation($location);
    }

    //Get Locations Function
    public function read (){
        return $this->locationService->getLocations();
    }

    //Get Location Function
    public function show(Location $location){
        return $this->locationService->getLocation($location);
    }
}
