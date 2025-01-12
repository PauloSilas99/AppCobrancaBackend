<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|decimal:0,2',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $client = Client::findOrFail($validated['client_id']);
        return $client->products()->create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validator = Validator::make(['product_id' => $id], [
            'product_id' => 'exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        return Product::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|decimal:0,2',
            'product_id' => 'exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        Product::findOrFail($id)->update($validated);
        return Product::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['product_id' => $id], [
            'product_id' => 'exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(['Produto excluído com êxito.'], 200);
    }

    /**
     * Display a listing of the resource by the specified user.
     */
    public function indexClient(string $id)
    {
        $validator = Validator::make(['client_id' => $id], [
            'client_id' => 'exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        return Client::findOrFail($id)->products;
    }
}
