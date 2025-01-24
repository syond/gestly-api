<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Repository\CategoryRepository;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function list()
    {
        return $this->categoryRepository->listCategories();
    }

    public function show($id)
    {
        $category = $this->categoryRepository->showCategory($id);
        return $category;
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150'
        ]);

        $category = $this->categoryRepository->createCategory($validatedData);

        if (!$category) return ApiResponse::error();

        return ApiResponse::success($category, 'Category created succesfully!', 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150'
        ]);

        $category = $this->categoryRepository->updateCategory($id, $validatedData);

        return ApiResponse::success($category, 'Category updated succesfully!');
    }
    
    public function delete($id) {
        $category = $this->categoryRepository->deleteCategory($id);
        return ApiResponse::success($category, 'Deleted succesfully.', 200);
    }
}
