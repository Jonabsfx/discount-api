<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Models\Campaign;
use App\Models\Discount;

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
                        'name' => $data->name,
                        'description' => $data->description,
                        'price' => $data->price
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
            'name' => $data->name,
            'description' => $data->description,
            'price' => $data->price
          ]);

          return response()->json(['message'=>'Product name updated successfully'], 200);
    }

    public function destroy($id)
    {
        $product = $this->findProduct($id);

        $product->delete();

        return response()->json(['message'=>'Product deleted successfully'], 204);
    }

    public function associate_Campaign($campaign_id, $product_id, Request $request )
    {
        if($request->value > 0 && is_numeric($request->value))
        {
            new Discount([
                            'value' => $request->value,
                            'product_id' => $product_id,
                            'campaign_id' => $campaign_id
                        ]);

            return response()->json(['message'=>'Product added to campaign successfully'], 200);
        }

        return response()->json(['message'=> 'Inform a valid discount'], 400);
    }

    public function edit_associated_Campaign($campaign_id, $product_id, Request $request)
    {
        if($request->value > 0 && is_numeric($request->value))
        {
            $discount = Discount::select('*')
                                ->where('campaign_id', '=', $campaign_id)
                                ->and('product_id', '=', $product_id)
                                ->first();
            $discount->update([
                'value' => $request->value
            ]);

            return response()->json(['message'=>'Discount updated successfully'], 200);
        }

        return response()->json(['message'=> 'Inform a valid discount'], 400);
    }

    public function remove_associated_Campaign($campaign_id, $product_id)
    {
        $discount = Discount::select('*')
                                ->where('campaign_id', '=', $campaign_id)
                                ->and('product_id', '=', $product_id)
                                ->first();
        $discount->delete();

        return response()->json(['message'=>'Discount deleted successfully'], 204);
    }

}
