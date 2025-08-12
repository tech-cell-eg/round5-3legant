<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone'=> 'required|string|max:15',
        ]);

        $address = $request->user()->addresses()->create($validated);
        return response()->json([
            'message' => 'Address created successfully',
            'address' => $address,
        ]);
    }


    public function update(Request $request, $id)
    {
         $validated = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone'=> 'required|string|max:15',
        ]);

        $address = $request->user()->addresses()->findOrFail($id);
        $address->update($validated);

        return response()->json([
            'message' => 'Address updated successfully',
            'address' => $address,
        ]);

    }

    public function destroy($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        $address->delete();

        return response()->json([
            'message' => 'Address deleted successfully',
        ]);
    }
}
