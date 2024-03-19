<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use App\Models\Shop;
use App\Models\ShopItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreBasketRequest extends FormRequest
{
    use GeneralTrait;

   public $attribute_ids = [];
   public $shop_item_ids = [];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "data" => "required|array|min:1",
            "data.*.shop_item_id" => "required|string|min:10|max:40|exists:shop_items,uuid",
            "data.*.shop_item_attribute_id" => "nullable|string|min:10|max:40|exists:shop_item_attributes,uuid",
            "data.*.number" => "required|integer|min:1",
            "data.*.notes" => "nullable|string|min:3|max:255",
            "coupon" => "nullable|string|min:11|max:11",
        ];
    }

    public function checkOrder(Shop $shop) : bool
    {
        foreach ($this->data as $chart) {

            $shop_item = ShopItem::where("uuid", $chart["shop_item_id"])->first();

            if ($shop_item->shop_id != $shop->id || $shop_item->quantity < $chart["number"] || isset($this->shop_item_ids[$shop_item->id]))
                return false;

            $this->shop_item_ids[$shop_item->id] = $shop_item;
            $this->shop_item_ids[$shop_item->uuid] = $shop_item;
            $item_attribute = $shop_item->attributes;

            if($chart["shop_item_attribute_id"]) {

                if($item_attribute->isEmpty())
                    return false;

               $attrib = $item_attribute->where("uuid", $chart["shop_item_attribute_id"]);

                if ($attrib->isEmpty())
                    return false;

            }else{

                $attrib = $shop_item->attribute;

                if($attrib && $attrib->value->attribute->is_required)
                    return false;

            }
        }

        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField($validator->errors()));
    }
}
