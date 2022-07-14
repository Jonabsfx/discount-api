<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    protected $entity;

    public function __construct(Discount $model)
    {
        $this->entity = $model;
    }

    public function associate_Campaign($campaign_id, $product_id, Request $request )
    {

        if($request->value > 0 && is_numeric($request->value))
        {
            $response = $this->entity
                        ->create([
                                'value' => $request->value,
                                'product_id' => $product_id,
                                'campaign_id' => $campaign_id
                        ]);

            return response()->json($response, 200);
        }

        return response()->json(['message'=> 'Inform a valid discount'], 400);
    }

    public function edit_associated_Campaign($campaign_id, $product_id, Request $request)
    {
        if($request->value > 0 && is_numeric($request->value))
        {
            $discount = Discount::select('*')
                                ->where('campaign_id', '=', $campaign_id)
                                ->where('product_id', '=', $product_id)
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
                                ->where('product_id', '=', $product_id)
                                ->first();
        $discount->delete();

        return response()->json(['message'=>'Discount deleted successfully'], 204);
    }
}
