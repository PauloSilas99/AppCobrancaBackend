<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|string',
            'address' => 'required|string',
            'whatsapp' => 'required|string|max:11',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $user = User::findOrFail($validated['user_id']);
        return $user->clients()->create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validator = Validator::make(['client_id' => $id], [
            'client_id' => 'exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        return Client::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|string',
            'address' => 'required|string',
            'whatsapp' => 'required|string|max:11',
            'client_id' => 'exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        Client::findOrFail($id)->update($validated);
        return Client::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['client_id' => $id], [
            'client_id' => 'exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $client = Client::findOrFail($id);

        $client->products()->delete();
        $client->delete();

        return response()->json(['Cliente excluído com êxito.'], 200);
    }

    /**
     * Display a listing of the resource by the specified user.
     */
    public function indexUser(string $id)
    {
        $validator = Validator::make(['user_id' => $id], [
            'user_id' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        return User::findOrFail($id)->clients;
    }
}
