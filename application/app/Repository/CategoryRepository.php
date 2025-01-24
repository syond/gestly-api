<?php

namespace App\Repository;

use App\Models\Category;
use App\Exceptions\NotFoundException;

class CategoryRepository
{
    public function listCategories()
    {
        return Category::all();
    }

    public function showCategory($id)
    {
        $category = Category::find($id);
        if (!$category) throw new NotFoundException('Category not found.');
        return $category;
    }

    public function createCategory($data)
    {
        $category = Category::create($data);
        return $category;
    }

    public function updateCategory($id, $data)
    {
        $category = Category::find($id);
        if (!$category) throw new NotFoundException('Category not found.');
        $category->update($data);
        return $category;
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if (!$category) throw new NotFoundException('Category not found.');
        $category->delete();
        return $category;
    }
}
