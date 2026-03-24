<?php

namespace App\Services;

use App\Models\Category;
use App\Transformers\Categories\CategoriesResponse;
use App\Transformers\Categories\CategoryResponse;

class CategoryService
{
    public function createCategory($data)
    {
        $category = Category::create($data);

        return success(CategoryResponse::format($category), 'Category created successfully', 201);
    }

    public function updateCategory(Category $category, $data)
    {
        $category->update($data);

        return success(CategoryResponse::format($category), 'Category updated successfully');
    }

    public function deleteCategory (Category $category) {
        $category->delete();

        return success(null, 'Category deleted successfully');
    }

    public function getCategories ($perPage) {
        $categories = Category::paginate($perPage ?? 10);

        return success(CategoriesResponse::format($categories), 'Categories information');
    }

    public function getCategory (Category $category){
        return success(CategoryResponse::format($category), 'Category information');
    }
}
