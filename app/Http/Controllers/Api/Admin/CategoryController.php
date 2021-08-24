<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->success('Categories retrieved successfully', Category::all()->map->format());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $category = Category::create($request->validated());
            return response()->success("Category successfully created", $category->format());
        } catch(QueryException $e) {
            report($e);
            return response()->errorResponse("Error creating category");
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->success("Category retrieved successfully", $category->format());
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findByName($name)
    {
        $category = Category::firstWhere('name', $name);
        return response()->success("Category retrieved successfully", $category->format());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->validated());
            return response()->success("Category updated successfully", $category->format());
        } catch(QueryException $e) {
            report($e);
            return response()->errorResponse('Error updating category');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->success("Category successfully deleted");
        } catch(QueryException $e) {
            report($e);
            return response()->errorReponse("Error deleting category");
        }
    }
}
