<?php

namespace App\Services;

use App\Models\ClientNotification;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Transformers\Products\ProductResponse;
use App\Transformers\Products\ProductsResponse;
use Illuminate\Support\Facades\File;

class ProductService
{
    public function createProduct($data, $request)
    {
        $users = User::where('role', 'user')->get();
        $host = request()->getHost();
        $port = request()->getPort();
        $url = $host + ':' + $port + '/';

        $product = Product::create($data);

        if ($request->images)
            foreach ($request->images as $image) {
                $path = uploadImage($image, 'ProductsImages');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
            }

        foreach($users as $user){
            ClientNotification::create([
                'user_id' => $user->id,
                'name_en' => $product->name_en,
                'name_ar' => $product->name_ar,
                'description_en' => $product->description_en,
                'description_ar' => $product->description_ar,
                'type' => 'Product',
                'link' => $url . '/api/products/' . $product->id,
            ]);
        }

        return success(ProductResponse::format($product), 'Product created successfully', 201);
    }

    public function updateProduct(Product $product, $data, $request)
    {
        $product->update($data);

        if ($request->images)
            foreach ($request->images as $image) {
                $path = uploadImage($image, 'ProductsImages');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
            }

        return success(ProductResponse::format($product), 'Product updated successfully');
    }

    public function deleteImage(ProductImage $productImage)
    {
        if (File::exists($productImage->image)) {
            File::delete($productImage->image);
        }

        $productImage->delete();

        return success(null, 'Image deleted successfully');
    }

    public function deleteProduct(Product $product)
    {
        foreach ($product->images as $image) {
            if (File::exists($image->image)) {
                File::delete($image->image);
            }
        }

        $product->delete();

        return success(null, 'Product deleted successfully');
    }

    public function getProducts($perPage)
    {
        $products = Product::paginate($perPage ?? 10);

        return success(ProductsResponse::format($products), 'Products information');
    }

    public function getProduct(Product $product)
    {
        return success(ProductResponse::format($product), 'Product information');
    }
}
