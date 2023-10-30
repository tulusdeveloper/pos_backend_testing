<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    
    public function index()
    {
        $categories = Category::with('products')->get();
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'category_name' => 'required|string',
                'doc' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the mime types and maximum file size as needed
            ]);

            // Check if an icon file is provided
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons'); // Store the icon file
                $data['icon'] = asset($iconPath); // Store the URL to the icon
            } else {
                $data['icon'] = null; // Set icon to null if no file is provided
            }

            $category = Category::create($data);
            $category->num_products = 0; // Initialize with zero products

            return response()->json($category, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error occurred
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Other unexpected error
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $data = $request->validate([
                'category_name' => 'string',
                'doc' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the mime types and maximum file size as needed
            ]);
    
            // Check if an icon file is provided
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons'); // Store the icon file
                $data['icon'] = asset($iconPath); // Store the URL to the updated icon
            }
    
            // Update the category with the new data
            $category->update($data);
    
            // Save the category to the database
            $category->save();
    
            return response()->json(['message' => 'Category updated successfully'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error occurred
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Other unexpected error
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
    
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(null, 204);
    }

    public function getProducts($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $products = $category->products;
        $category->num_products = $products->count(); // Update num_products based on actual product count

        return response()->json($category, 200);
    }

    // Function to upload icon URL to the database
    public function uploadIcon(Request $request, $categoryId)
    {
        // Validate and store the uploaded file
        $request->validate([
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust as needed
        ]);

        if ($request->file('icon')->isValid()) {
            $path = $request->file('icon')->store('icons'); // Store the file in the "icons" directory

            // Update the category record with the icon URL
            $category = Category::findOrFail($categoryId);
            $category->icon = asset($path);
            $category->save();

            return response()->json(['message' => 'Icon uploaded successfully'], 200);
        }

        return response()->json(['message' => 'Icon upload failed'], 400);
    }
}