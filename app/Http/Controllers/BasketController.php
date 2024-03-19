<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBasketRequest;
use App\Http\Resources\BasketResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Basket;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Shop;
use App\Models\ShopItem;
use App\Models\ShopItemAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BasketController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBasketRequest $storeBasketRequest)
    {
        try {

            $shop = Shop::where("uuid",$storeBasketRequest->shop_id)->firstOrFail();

            if(!$storeBasketRequest->checkOrder($shop))
                return $this->requiredField("your order is not correct");

            $delivery_price = $shop->delivery_price;
            $delivery_discount = $shop->delivery_price - ( ($shop->delivery_price * $shop->delivery_discount) / 100);

            $menu_discount = ($of = $shop->offer)? $of->discount : 0;

            $coupon = ($storeBasketRequest->coupon)? Coupon::where("code",$storeBasketRequest->coupon)->first() : 0;

            $coupon = ($coupon)? $coupon->discount : 0;

            $shop->baskets()->delete();


            $baskets = [];

            $overall_price = 0;
            $item_discount = 0;

            foreach ($storeBasketRequest->data as $chart){

                 $shop_item = $storeBasketRequest->shop_item_ids[$chart["shop_item_id"]];
                 $item_dis = ($of = $shop_item->offer)? $of->discount : 0;
                 $limit = ($of)? $of->limit : null;
                 $item_price = 0;

                 $attribute = ($chart["shop_item_attribute_id"])? ShopItemAttribute::where("uuid",$chart["shop_item_attribute_id"])->firstOrFail()
                              : null;

                 if($attribute) {
                     $storeBasketRequest->attribute_ids[$attribute->id] = $attribute;
                     $shop_item->price += $attribute->plus_price;
                 }

                 $overall_price += $shop_item->price;

                 if($limit && $chart["number"] > $limit) {
                     $item_discount -= $limit * (($shop_item->price * $item_dis) / 100);
                     $item_price = $limit*($shop_item->price - (($shop_item->price * $item_dis)/100)) + ($chart["number"] - $limit) * $shop_item->price;
                 }
                 else {
                     $item_discount -= $chart["number"] * (($shop_item->price * $item_dis) / 100);
                     $item_price = $chart["number"]*($shop_item->price - (($shop_item->price * $item_dis)/100));
                 }

                 $b = Basket::create([

                         "uuid" => Str::uuid(),
                         "shop_id" => $shop->id,
                         "shop_item_id" => $shop_item->id,
                         "shop_item_attribute_id" => ($attribute)? $attribute->id : null,
                         "price" => $item_price,
                         "number" => $chart["number"],
                         "notes" => $chart["notes"],

                     ]
                 );

                 array_push($baskets,$b);
            }

            $user = auth("sanctum")->user();
            $order = ($user)? Order::where("user_id",$user->id)->where("shop_id",$shop->id)->first() : null;

            $total_price = ($overall_price - $item_discount);
            $total_price += ($order)? $delivery_price : $delivery_discount;

            $with_menu_dis = $total_price - (($total_price * $menu_discount)/100);
            $with_coupon_dis = $with_menu_dis - (($with_menu_dis * $coupon)/100);

            $shop->basket_price = $with_menu_dis;
            $shop->save();

            $storeBasketRequest["coin"] = $shop->country->coin;
            $storeBasketRequest["shop_item_ids"] = $storeBasketRequest->shop_item_ids;
            $storeBasketRequest["attribute_ids"] = $storeBasketRequest->attribute_ids;

            return $this->apiResponse(

                [
                    "chart" => BasketResource::collection($baskets),
                    "overall_price" => $overall_price . " " . $storeBasketRequest->coin,
                    "item_discount" => $item_discount . " " . $storeBasketRequest->coin,
                    "delivery_price" => $delivery_price . " " . $storeBasketRequest->coin,
                    "delivery_discount" => (!$order)? ($delivery_discount - $delivery_price) . " " . $storeBasketRequest->coin : null,
                    "total_price" => $total_price . " " . $storeBasketRequest->coin,
                    "menu_discount" => ($with_menu_dis - $total_price) . " " . $storeBasketRequest->coin,
                    "coupon_discount" => ($with_coupon_dis - $with_menu_dis) . " " . $storeBasketRequest->coin,
                    "final_price" => $with_coupon_dis . " " . $storeBasketRequest->coin,
                ]

            );

        }catch (\Exception $e){

            return $this->requiredField($e->getMessage());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function show(Basket $basket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Basket $basket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Basket $basket)
    {
        //
    }
}
