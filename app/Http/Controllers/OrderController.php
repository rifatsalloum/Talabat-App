<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\OrderResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            return $this->apiResponse(

                OrderResource::collection(

                    Order::where("user_id",auth("sanctum")->user()->id)->get()

                )

            );

        }catch (\Exception $e){

            return $this->requiredField($e->getMessage());

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $storeOrderRequest)
    {
        try {

            $shop = Shop::where("uuid",$storeOrderRequest->shop_id)->firstOrFail();

            $baskets = $shop->baskets;

            if($baskets->isEmpty())
                return $this->requiredField("there is no order in the basket");

            $user = auth("sanctum")->user();
            $payment = Payment::where("uuid",$storeOrderRequest->payment_id)->firstOrFail();

            $order_before = Order::where("user_id",$user->id)->where("shop_id",$shop->id)->first();

            $delivery = Delivery::create(
                [
                    "uuid" => Str::uuid(),
                    "deliver_at" => $storeOrderRequest->deliver_at,
                    "address" => $storeOrderRequest->address,
                    "price" => ($order_before)? $shop->delivery_price : $shop->delivery_price - ( ($shop->delivery_price * $shop->delivery_discount) / 100),
                ]
            );

            $order = Order::create(
                [
                    "uuid" => Str::uuid(),
                    "user_id" => $user->id,
                    "shop_id" => $shop->id,
                    "payment_id" => $payment->id,
                    "delivery_id" => $delivery->id,
                    "overall_price" => $shop->basket_price,
                ]
            );

            $baskets->each(
                function ($data) use ($order){
                    OrderItem::create(
                        [
                            "uuid" => Str::uuid(),
                            "order_id" => $order->id,
                            "shop_item_id" => $data->shop_item_id,
                            "shop_item_attribute_id" => $data->shop_item_attribute_id,
                            "price" => $data->price,
                            "number" => $data->number,
                            "notes" => $data->notes,
                        ]
                    );
                }
            );

            $shop->baskets()->delete();

            return $this->apiResponse(

                MessageResource::make("order added correctly")

            );

        }catch (\Exception $e){

            return $this->requiredField($e->getMessage());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
