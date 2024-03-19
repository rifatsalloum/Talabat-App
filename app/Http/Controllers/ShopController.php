<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Cuisine;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
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
                                        $this->sellType($request)

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

                    $data =  ($data)? $data->sortBy("name") : Shop::orderBy("name")->get();
                    break;

                case "rate":

                    $data =  ($data)? $data->sortByDesc("avg_rate") : Shop::orderBy("avg_rate", "desc")->get();
                    break;

                default:

                    return $data;

            }

            return $data;

        }catch (\Exception $e){

            return $data;

        }
    }
    private function cuisine(Request $request,$data = [])
    {
        try {

        if ($request->cuisine)
            $data =  ($data)? $data->filter(

                function ($one) use ($request){

                    return ($cuisine = $one->cuisine) && $cuisine->name == $request->cuisine;

                }) :
                   Shop::query()->whereHas("cuisine",

                       function ($query) use ($request){

                           $query->where("name",$request->cuisine);

                       })->get();


        return $data;

        }catch (\Exception $e){

            return $data;

        }
    }
    private function rate(Request $request,$data = [])
    {

        try {

            if ($request->rate)
                $data =  ($data)? $data->where("avg_rate",">=",$request->rate) :
                       Shop::where("avg_rate",">=",$request->rate)->get();

            return $data;

        }catch (\Exception $e){

            return $data;

        }

    }
    private function freeDelivery(Request $request,$data = [])
    {
        try {

            if ($request->free_delivery)
                $data =  ($data)? $data->filter(function ($one){

                    return $one->delivery_price === 0 || $one->delivery_discount === 100;

                }) :
                    Shop::where("delivery_price",0)->orWhere("delivery_discount",100)->get();

            return $data;

        }catch (\Exception $e){

            return $data;

        }
    }
    private function underMinutes(Request $request,$data = [])
    {
        try {

            if ($request->minutes)
                $data =  ($data)? $data->where("delivery_time","<",$request->minutes) :
                       Shop::where("delivery_time","<",$request->minutes)->get();

            return $data;

        }catch (\Exception $e){

            return $data;

        }
    }
    private function newlyAdded(Request $request,$data = [])
    {
        try {

            if ($request->newly_added)
                $data =  ($data)? $data->sortByDesc("created_at") :
                       Shop::orderBy("created_at","desc")->get();

            return $data;

        }catch (\Exception $e){

            return $data;

        }
    }
    private function sellType(Request $request,$data = [])
    {
        try {

            if ($request->type)
                 $data = ($data)? $data->filter(

                    function ($one) use ($request) {

                        return ($items = $one->items) && $items->filter(

                            function ($one) use ($request){

                               return ($category = $one->category) && $category->name == $request->type;

                            }
                        )->count() > 0;
                    }
                ) :
                    Shop::query()->whereHas("items",

                        function ($query) use ($request) {

                            $query->whereHas("category",

                                function ($query) use ($request){

                                    $query->where("name",$request->type);

                                }
                            );
                        }
                    )->get();

            return $data;

        }catch (\Exception $e){

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
