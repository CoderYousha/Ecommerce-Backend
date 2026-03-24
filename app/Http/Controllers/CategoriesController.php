<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequests\CreateCategoryRequest;
use App\Http\Requests\CategoriesRequests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Transformers\Categories\CategoryResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $categoryService;
    
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    //Create Category Function
    public function store (CreateCategoryRequest $createCategoryRequest) {
        return $this->categoryService->createCategory($createCategoryRequest->all());
    }

    //Update Category Function
    public function update (Category $category, UpdateCategoryRequest $updateCategoryRequest){
        return $this->categoryService->updateCategory($category, $updateCategoryRequest->all());
    }

    //Delete Category Function
    public function delete (Category $category) {
        return $this->categoryService->deleteCategory($category);
    }

    //Get Categories Function
    public function read (Request $request) {
        return $this->categoryService->getCategories($request->per_page);
    }

    //Get Category Function
    public function show (Category $category) {
        return $this->categoryService->getCategory($category);
    }
}
