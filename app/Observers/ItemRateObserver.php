<?php

namespace App\Observers;

use App\Models\ItemRate;
use App\Models\ShopItem;

class ItemRateObserver
{
    public function creating(ItemRate $itemRate) : void
    {
        $shop_item = ShopItem::where("id",$itemRate->shop_item_id)->first();

        $count = ItemRate::where("user_id",$itemRate->user_id)->where("shop_item_id",$itemRate->shop_item_id)->count();

        $shop_item->avg_rate = (($shop_item->avg_rate * $count) + $itemRate->rate) / ($count + 1);

        $shop_item->save();
    }

    public function updating(ItemRate $itemRate) : void
    {
        $shop_item = ShopItem::where("id",$itemRate->shop_item_id)->first();

        $count = ItemRate::where("user_id",$itemRate->user_id)->where("shop_item_id",$itemRate->shop_item_id)->count();
        $old = ItemRate::where("id",$itemRate->id)->first();

        $shop_item->avg_rate = ((($shop_item->avg_rate * $count) - $old->rate) + $itemRate->rate) / $count;

        $shop_item->save();
    }
    /**
     * Handle the ItemRate "created" event.
     *
     * @param  \App\Models\ItemRate  $itemRate
     * @return void
     */
    public function created(ItemRate $itemRate)
    {
        //
    }

    /**
     * Handle the ItemRate "updated" event.
     *
     * @param  \App\Models\ItemRate  $itemRate
     * @return void
     */
    public function updated(ItemRate $itemRate)
    {
        //
    }

    /**
     * Handle the ItemRate "deleted" event.
     *
     * @param  \App\Models\ItemRate  $itemRate
     * @return void
     */
    public function deleted(ItemRate $itemRate)
    {
        //
    }

    /**
     * Handle the ItemRate "restored" event.
     *
     * @param  \App\Models\ItemRate  $itemRate
     * @return void
     */
    public function restored(ItemRate $itemRate)
    {
        //
    }

    /**
     * Handle the ItemRate "force deleted" event.
     *
     * @param  \App\Models\ItemRate  $itemRate
     * @return void
     */
    public function forceDeleted(ItemRate $itemRate)
    {
        //
    }
}
