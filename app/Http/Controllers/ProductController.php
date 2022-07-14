<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;


class ProductController extends Controller
{
    protected $entity;

    public function __construct(Product $model)
    {
        $this->entity = $model;
    }

    private function findProduct($id)
    {   return $this->entity->findOrFail($id);

    }
    public function index()
    {
        $products = $this->entity->get();

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $response = $this->entity
                    ->create([
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'price' => $data['price']
                    ]);

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $product = $this->findProduct($id);
        return new ProductResource($product);
    }

    public function update(StoreProductRequest $request, $id)
    {
          $product = $this->findProduct($id);
          $data = $request->validated();

          $product->update([
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'price' => $data['price']
          ]);

          return response()->json(['message'=>'Product name updated successfully'], 200);
    }

    public function destroy($id)
    {
        $product = $this->findProduct($id);

        $product->delete();

        return response()->json(['message'=>'Product deleted successfully'], 204);
    }

}
