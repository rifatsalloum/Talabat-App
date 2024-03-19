<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Country;
use App\Models\Cuisine;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    use GeneralTrait;

    private $isReturned = false;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function search(Request $request)
    {
        try {

            return $this->apiResponse(

                ShopResource::collection(

                $this->sortBy(

                    $request,
                    $this->cuisine(

                        $request,
                        $this->rate(

                            $request,
                            $this->freeDelivery(

                                $request,
                                $this->underMinutes(

                                    $request,
                                    $this->newlyAdded(

                                        $request,
                                        $this->sellType(

                                            $request,
                                            $this->byCountry($request)

                                        )

                                    )

                                )

                            )

                        )

                    )
                )
             )

            );

        }catch (\Exception $e){

            return $this->requiredField($e->getMessage());

        }
    }
    private function sortBy(Request $request,$data = [])
    {
        try {

            switch ($request->sortby) {

                case "az" :

                    $data =  ($this->isReturned)? (($data)? $data->sortBy("name") : $data) :
                             ( Shop::orderBy("name")->get() );
                    break;

                case "rate":

                    $data =  ($this->isReturned)? (($data)? $data->sortByDesc("avg_rate") : $data) :
                             ( Shop::orderBy("avg_rate", "desc")->get() );
                    break;

                default:
                    return $data;

            }

            $this->isReturned = true;

            return $data;

        }catch (\Exception $e){

            $this->isReturned = true;

            return $data;

        }
    }
    private function cuisine(Request $request,$data = [])
    {
        try {

        if ($request->cuisine) {

            $data = ($this->isReturned) ? (($data) ? $data->filter(

                function ($one) use ($request) {

                    return ($cuisine = $one->cuisine) && $cuisine->name === $request->cuisine;

                }) :

                $data) :

                (
                Shop::query()->whereHas("cuisine",

                    function ($query) use ($request) {

                        $query->where("name", $request->cuisine);

                    })->get());

            $this->isReturned = true;

        }

        return $data;

        }catch (\Exception $e){

            $this->isReturned = true;

            return $data;

        }
    }
    private function rate(Request $request,$data = [])
    {

        try {

            if ($request->rate) {

                $data = ($this->isReturned) ? (($data) ? $data->where("avg_rate", ">=", $request->rate) : $data) :
                    (Shop::where("avg_rate", ">=", $request->rate)->get());

                $this->isReturned = true;

            }

            return $data;

        }catch (\Exception $e){

            $this->isReturned = true;

            return $data;

        }

    }
    private function freeDelivery(Request $request,$data = [])
    {
        try {

            if ($request->free_delivery) {

                $data = ($this->isReturned) ? (($data) ? $data->filter(function ($one) {

                    return $one->delivery_price === 0 || $one->delivery_discount === 100;

                }) :
                    $data) :
                    (Shop::where("delivery_price", 0)->orWhere("delivery_discount", 100)->get());

                $this->isReturned = true;

            }

            return $data;

        }catch (\Exception $e){

            $this->isReturned = true;

            return $data;

        }
    }
    private function underMinutes(Request $request,$data = [])
    {
        try {

            if ($request->minutes) {

                $data = ($this->isReturned) ? (($data) ? $data->where("delivery_time", "<", $request->minutes) : $data) :
                    (Shop::where("delivery_time", "<", $request->minutes)->get());

                $this->isReturned = true;

            }

            return $data;

        }catch (\Exception $e){

            $this->isReturned = true;

            return $data;

        }
    }
    private function newlyAdded(Request $request,$data = [])
    {
        try {

            if ($request->newly_added) {

                $data = ($this->isReturned) ? (($data) ? $data->sortByDesc("created_at") : $data) :
                    (Shop::orderBy("created_at", "desc")->get());

                $this->isReturned = true;

            }

            return $data;

        }catch (\Exception $e){

            $this->isReturned = true;

            return $data;

        }
    }
    private function sellType(Request $request,$data = [])
    {
        try {

            if ($request->type) {

                $data = ($this->isReturned) ? (($data) ? $data->filter(

                    function ($one) use ($request) {

                        return ($items = $one->items) && $items->filter(

                                function ($one) use ($request) {

                                    return ($category = $one->category) && $category->name === $request->type;

                                }
                            )->count() > 0;
                    }
                ) : $data) :
                    (
                    Shop::query()->whereHas("items",

                        function ($query) use ($request) {

                            $query->whereHas("category",

                                function ($query) use ($request) {

                                    $query->where("name", $request->type);

                                }
                            );
                        }
                    )->get());

                $this->isReturned = true;

            }

            return $data;

        }catch (\Exception $e){

            $this->isReturned = true;

            return $data;

        }

    }
    private function byCountry(Request $request,$data = [])
    {
        try{


            if($request->country) {

                $country = Country::where("uuid", $request->country)->firstOrFail();

                $data = ($this->isReturned) ? (($data) ? $data->where("country_id", $country->id) : $data) :
                    (Shop::where("country_id", $country->id)->get());

                $this->isReturned = true;

            }

            return $data;

        }catch (\Exception $e){

            $this->isReturned = true;

            return $data;

        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
