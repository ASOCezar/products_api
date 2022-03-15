<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Mockery\Exception\InvalidOrderException;

class ProductController extends Controller {

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index() {
        $data = ['data' => $this->product->all()];
        return response()->json($data);
    }

    public function show(Product $id) {
        if (!$id) {
            return response()->json(['message' => 'Product not found'], 400);
        }

        $data = ['data' => $id];
        return response()->json($data);
    }

    public function create(Request $request) {
        if (!$request["price"] || !$request["name"] || !$request["description"]) {
            return response()->json(['message' => 'New products should have name, description and price'], 400);
        }

        try {
            $requestData = $request->all();
            $this->product->create($requestData);

            return response($requestData, 201);
        } catch (\Throwable $th) {
            if(config('app.debug')) {
                return response()->json(ApiError::errorMessage($th->getMessage(), 1010));
            }

            return response()->json(ApiError::errorMessage('Internal Error', 500));
        }
    }

    public function update(Product $id, Request $request) {
        if (!$id) {
            return response()->json(['message' => 'Product not found'], 400);
        }

        $id->update($request->all());
        return response()->json(['data' => $id], 201);
    }
}

