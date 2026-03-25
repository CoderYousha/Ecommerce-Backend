<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Transformers\Products\ProductResponse;
use App\Transformers\Products\ProductsResponse;
use Illuminate\Support\Facades\File;

class ProductService
{
    public function createProduct($data, $request)
    {
        $product = Product::create($data);

        if ($request->images)
            foreach ($request->images as $image) {
                $path = uploadImage($image, 'ProductsImages');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
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

    public function getProducts($perPage){
        $products = Product::paginate($perPage ?? 10);

        return success(ProductsResponse::format($products), 'Products information');
    }

    public function getProduct(Product $product){
        return success(ProductResponse::format($product), 'Product information');
    }
}
