<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImagesRequests\UploadImagesRequest;
use App\Http\Requests\ProductsRequests\CreateProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    //Create Product Function
    public function store(CreateProductRequest $createProductRequest, UploadImagesRequest $uploadImagesRequest)
    {
        return $this->productService->createProduct($createProductRequest->all(), $uploadImagesRequest);
    }

    //Update Product Function
    public function update(Product $product, CreateProductRequest $createProductRequest, UploadImagesRequest $uploadImagesRequest)
    {
        return $this->productService->updateProduct($product, $createProductRequest->all(), $uploadImagesRequest);
    }

    //Delete Product Image Function
    public function deleteImage(ProductImage $productImage)
    {
        return $this->productService->deleteImage($productImage);
    }

    //Delete Product Function
    public function delete(Product $product)
    {
        return $this->productService->deleteProduct($product);
    }

    //Get Products Function
    public function read(Request $request) {
        return $this->productService->getProducts($request->per_page);
    }

    //Get Product Function
    public function show(Product $product) {
        return $this->productService->getProduct($product);
    }
}
