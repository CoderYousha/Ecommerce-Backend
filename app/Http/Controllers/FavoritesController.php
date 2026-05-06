<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    //Add To / Remove From Favorite Function
    public function favorite(Product $product){
        return $this->favoriteService->favorite($product);
    }

    //Get Favorite Function
    public function read (Request $request) {
        return $this->favoriteService->getFavorite($request->per_page);
    }
}
