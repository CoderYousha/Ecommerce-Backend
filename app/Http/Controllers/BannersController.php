<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannersRequests\CreateBannerRequest;
use App\Http\Requests\ImagesRequests\UploadImagesRequest;
use App\Models\Banner;
use App\Models\BannerImage;
use App\Services\BannerService;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    //Create Banner Function
    public function store (CreateBannerRequest $createBannerRequest, UploadImagesRequest $uploadImagesRequest) {
        return $this->bannerService->createBanner($createBannerRequest->all(), $uploadImagesRequest);
    }

    //Update Banner Function
    public function update (Banner $banner, CreateBannerRequest $createBannerRequest, UploadImagesRequest $uploadImagesRequest) {
        return $this->bannerService->updateBanner($banner, $createBannerRequest->all(), $uploadImagesRequest);
    }

    //Delete Banner Imagee Function
    public function deleteImage (BannerImage $bannerImage) {
        return $this->bannerService->deleteBannerImage($bannerImage);
    }

    //Delete Banner Function
    public function delete (Banner $banner) {
        return $this->bannerService->deleteBanner($banner);
    }

    //Get Banners Function
    public function read (Request $request) {
        return $this->bannerService->getBanners($request->per_page);
    }

    //Get Banner Function
    public function show (Banner $banner) {
        return $this->bannerService->getBanner($banner);
    }
}
