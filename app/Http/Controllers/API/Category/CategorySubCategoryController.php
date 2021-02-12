<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;

class CategorySubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $subCategory=$category->subcategories;
        return $this->showAll($subCategory);
    }

}
