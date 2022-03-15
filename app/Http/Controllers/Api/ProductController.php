<?php
namespace App\Http\Controllers\Api;

use App\Api\ApiError;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;

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
        $data = ['data' => $id];
        return response()->json($data);
    }

    public function create(Request $request) {
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
}

