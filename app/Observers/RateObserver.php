<?php

namespace App\Observers;

use App\Models\Rate;
use App\Models\Shop;

class RateObserver
{
    public function creating(Rate $rate) : void
    {
        $shop = Shop::where("id",$rate->shop_id)->first();

        $count = Rate::where("user_id",$rate->user_id)->where("shop_id",$rate->shop_id)->count();

        $shop->avg_rate = (($shop->avg_rate * $count) + $rate->rate) / ($count + 1);

        $shop->save();
    }

    public function updating(Rate $rate) : void
    {
        $shop = Shop::where("id",$rate->shop_id)->first();

        $count = Rate::where("user_id",$rate->user_id)->where("shop_id",$rate->shop_id)->count();
        $old = Rate::where("id",$rate->id)->first();

        $shop->avg_rate = ((($shop->avg_rate * $count) - $old->rate) + $rate->rate) / $count;

        $shop->save();

    }
    /**
     * Handle the Rate "created" event.
     *
     * @param  \App\Models\Rate  $rate
     * @return void
     */
    public function created(Rate $rate)
    {
        //
    }

    /**
     * Handle the Rate "updated" event.
     *
     * @param  \App\Models\Rate  $rate
     * @return void
     */
    public function updated(Rate $rate)
    {
        //
    }

    /**
     * Handle the Rate "deleted" event.
     *
     * @param  \App\Models\Rate  $rate
     * @return void
     */
    public function deleted(Rate $rate)
    {
        //
    }

    /**
     * Handle the Rate "restored" event.
     *
     * @param  \App\Models\Rate  $rate
     * @return void
     */
    public function restored(Rate $rate)
    {
        //
    }

    /**
     * Handle the Rate "force deleted" event.
     *
     * @param  \App\Models\Rate  $rate
     * @return void
     */
    public function forceDeleted(Rate $rate)
    {
        //
    }
}
