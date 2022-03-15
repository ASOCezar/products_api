<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {

    private $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function index() {
        $data = ['data' => $this->product->all()];
        return response()->json($data);
    }

    public function show($id) {
        $product = $this->product->find($id);

        if (!$product) {
            return response()->json(['data' => ['message' => 'Product not found']], 400);
        }
        try {
            $data = ['data' => $id];
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['data' => ['message' => 'Internal Error', 'debug' => $th]], 500);
        }
    }

    public function create(Request $request) {
        if (!$request["price"] || !$request["name"] || !$request["description"]) {
            return response()->json(['data' => ['message' => 'New products should have name, description and price']], 400);
        }

        $requestData = $request->all();
        try {
            $this->product->create($requestData);
            return response($requestData, 201);
        } catch (\Throwable $th) {
            return response()->json(['data' => ['message' => 'Internal Error', 'debug' => $th]], 500);
        }
    }

    public function update($id, Request $request) {
        $product = $this->product->find($id);

        if (!$product) {
            return response()->json(['data' => ['message' => 'Product not found']], 400);
        }
        try {
            $product->update($request->all());
            return response()->json(['data' => $id], 201);

        } catch (\Throwable $th) {
            return response()->json(['data' => ['message' => 'Internal Error', 'debug' => $th]], 500);
        }
    }

    public function delete($id) {
        $product = $this->product->find($id);

        if (!$product) {
            return response()->json(['data' => ['message' => 'Product not found']], 400);
        }

        try {
            $product->delete();
            return response()->json(['message' => 'Success'], 204);
        } catch (\Throwable $th) {
            return response()->json(['data' => ['message' => 'Internal Error', 'debug' => $th]], 500);
        }
    }
}
