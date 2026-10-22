<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type'); // optional: food|grocery

        $query = Product::query();

        if (in_array($type, ['food', 'grocery'], true)) {
            $query->where('type', $type);
        }

        $products = $query->orderBy('name')->get();

        return response()->json($products);
    }

    public function myProducts(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if (! in_array($user->role, ['seller', 'grocer'], true)) {
            return response()->json(['message' => 'Only sellers or grocers can view their products'], 403);
        }

        $products = Product::where('user_id', $user->id)
            ->orderBy('name')
            ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if (! in_array($user->role, ['seller', 'grocer'], true)) {
            return response()->json(['message' => 'Only sellers or grocers can create products'], 403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'type' => $user->role === 'seller' ? 'food' : 'grocery',
            'stock' => $validated['stock'],
        ]);

        return response()->json($product, 201);
    }
}

