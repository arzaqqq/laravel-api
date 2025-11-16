<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::all();

        return response()->json([
            'products'=>$products
        ],200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
       try {
        // Generate random image name
        $imageName = Str::random(32) . '.' . $request->image->getClientOriginalExtension();

        // Create Product
        Product::create([
            'name'        => $request->name,
            'image'       => $imageName,
            'description' => $request->description,
        ]);

        // Save image to storage folder
        Storage::disk('public')->put($imageName, file_get_contents($request->image));

        // Return JSON Response
        return response()->json([
            'message' => 'Product successfully created.',
        ], 200);

    } catch (\Exception $e) {

        // Return JSON Response when something failed
        return response()->json([
            'message' => 'Something went really wrong!',
        ], 500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**quest
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
