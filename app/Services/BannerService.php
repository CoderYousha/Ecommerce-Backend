<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\BannerImage;
use App\Models\ClientNotification;
use App\Models\User;
use App\Transformers\Banners\BannerResponse;
use App\Transformers\Banners\BannersResponse;
use Illuminate\Support\Facades\File;

class BannerService
{
    public function createBanner($data, $request)
    {
        $users = User::where('role', 'user')->get();
        $host = request()->getHost();
        $port = request()->getPort();
        $url = $host . ':' . $port;

        $banner = Banner::create($data);
        if ($request->images) {
            foreach ($request->images as $image) {
                $path = uploadImage($image, 'BannersImages');
                BannerImage::create([
                    'banner_id' => $banner->id,
                    'image' => $path,
                ]);
            }
        }

        foreach($users as $user){
            ClientNotification::create([
                'user_id' => $user->id,
                'name_en' => 'New Banner',
                'name_ar' => 'إعلان جديد',
                'description_en' => $data['name_en'],
                'description_ar' => $data['name_ar'],
                'type' => 'Banner',
                'link' => $url . '/api/banners/' . $banner->id,
            ]);
        }

        return success(BannerResponse::format($banner), 'Banner created successfully', 201);
    }

    public function updateBanner(Banner $banner, $data, $request)
    {
        $banner->update($data);

        if ($request->images) {
            foreach ($request->images as $image) {
                $path = uploadImage($image, 'BannersImages');
                BannerImage::create([
                    'banner_id' => $banner->id,
                    'image' => $path,
                ]);
            }
        }

        return success(BannerResponse::format($banner), 'Banner updated successfully');
    }

    public function deleteBannerImage(BannerImage $bannerImage) {
        if(File::exists($bannerImage->image)){
            File::delete($bannerImage->image);
        }

        $bannerImage->delete();

        return success(null, 'Image deleted successfully');
    }

    public function deleteBanner(Banner $banner) {
        foreach($banner->images as $image){
            if(File::exists($image->image)){
                File::delete($image->image);
            }
        }

        $banner->delete();

        return success(null, 'Banner deleted successfully');
    }

    public function getBanners($perPage, $search) {
        $banners = Banner::where(function ($query) use ($search) {
            $query->where('name_en', 'LIKE', "%{$search}%")->orWhere('name_ar', 'LIKE', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate($perPage ?? 10);

        return success(BannersResponse::format($banners), 'Banners information');
    }

    public function getBanner(Banner $banner) {
        return success(BannerResponse::format($banner), 'Banner information');
    }
}
