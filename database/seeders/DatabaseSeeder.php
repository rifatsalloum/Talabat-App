<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Attribute;
use App\Models\Country;
use App\Models\Cuisine;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Shop;
use App\Models\ShopItem;
use App\Models\ShopItemAttribute;
use App\Models\ShopItemCategory;
use App\Models\Value;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    private $attributes;
    private $countries;
    private $cuisines;
    private $itemCategories;
    private $items;
    private $offers;
    private $payments;
    private $shops;
    private $shopItemCategories;
    private $shopItems;
    private $values;
    private $shopItemAttributes;
    private function butData() : void
    {
        $this->attributes = [
            [
                "uuid" => Str::uuid(),
                "name" => "size",
                "is_required" => true,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "color",
                "is_required" => false,
            ],
        ];
        //------------------------------//
        $this->countries = [
            [
                "uuid" => Str::uuid(),
                "name" => "Syria",
                "coin" => "sy",
                "phone_prefix" => "+936",
                "image" => "url",
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "Lebanon",
                "coin" => "lb",
                "phone_prefix" => "+961",
                "image" => "url",
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "America",
                "coin" => "$",
                "phone_prefix" => "+01",
                "image" => "url",
            ]
        ];
        //------------------------------//
        $this->cuisines = [
            [
                "uuid" => Str::uuid(),
                "name" => "Asian",
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "Est",
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "chinese",
            ],
        ];
        //-----------------------------//
        $this->itemCategories = [
            [
                "uuid" => Str::uuid(),
                "name" => "food",
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "flowers",
            ]
        ];
        //-----------------------------//
        $this->items = [
            [
                "uuid" => Str::uuid(),
                "name" => "soci",
                "description" => "chinese food gives fun",
                "image" => "url",
                "item_category_id" => 1,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "pizza",
                "description" => "american food gives fun",
                "image" => "url",
                "item_category_id" => 1,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "butterfly",
                "description" => "flower type with good smell",
                "image" => "url",
                "item_category_id" => 2,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "sun",
                "description" => "flower type with good test",
                "image" => "url",
                "item_category_id" => 2,
            ]
        ];
        //-----------------------------//
        $this->offers = [
            [
                "uuid" => Str::uuid(),
                "description" => "save 20% of your item",
                "type" => "best_sellers",
                "discount" => 20,
                "limit" => 2,
                "expire_date" => "2024/04/01",
            ],
            [
                "uuid" => Str::uuid(),
                "description" => "save 50% of your menu",
                "type" => "on_menu",
                "discount" => 50,
                "limit" => null,
                "expire_date" => "2024/04/01",
            ],
        ];
        //--------------------------------//
        $this->payments = [
            [
                "uuid" => Str::uuid(),
                "method" => "paypal",
            ],
            [
                "uuid" => Str::uuid(),
                "method" => "visa card",
            ],
        ];
        //--------------------------------//
        $this->shops = [
            [
                "uuid" => Str::uuid(),
                "name" => "fodo",
                "address" => "homs alhamra",
                "phone" => "9384938384",
                "email" => "fodo@gmail.com",
                "image" => "url",
                "delivery_price" => 20,
                "delivery_time" => 20,
                "delivery_discount" => 0,
                "avg_rate" => 0,
                "basket_price" => 0,
                "country_id" => 1,
                "cuisine_id" => 1,
                "offer_id" =>2,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "be2be",
                "address" => "homs alhadara",
                "phone" => "9384938314",
                "email" => "be2be@gmail.com",
                "image" => "url",
                "delivery_price" => 50,
                "delivery_time" => 30,
                "delivery_discount" => 100,
                "avg_rate" => 10.2,
                "basket_price" => 0,
                "country_id" => 1,
                "cuisine_id" => 2,
                "offer_id" =>null,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "flowers seller",
                "address" => "homs aladaoia",
                "phone" => "9384958384",
                "email" => "flowyers@gmail.com",
                "image" => "url",
                "delivery_price" => 50,
                "delivery_time" => 5,
                "delivery_discount" => 20,
                "avg_rate" => 10.2,
                "basket_price" => 0,
                "country_id" => 1,
                "cuisine_id" => null,
                "offer_id" =>null,
            ],
        ];
        //------------------------------------//
        $this->shopItemCategories = [
            [
                "uuid" => Str::uuid(),
                "name" => "lunch",
                "item_category_id" => 1,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "borries",
                "item_category_id" => 2,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "dinner",
                "item_category_id" => 1,
            ],
        ];
        //------------------------------------//
        $this->shopItems = [
            [
                "uuid" => Str::uuid(),
                "shop_id" => 1,
                "item_id" => 1,
                "quantity" => 2,
                "price" =>10.5,
                "avg_rate" => 10,
                "trending" => true,
                "shop_item_category_id" => 1,
                "offer_id" => 1,
            ],
            [
                "uuid" => Str::uuid(),
                "shop_id" => 1,
                "item_id" => 2,
                "quantity" => 2,
                "price" =>10.5,
                "avg_rate" => 5,
                "trending" => false,
                "shop_item_category_id" => 1,
                "offer_id" => 1,
            ],
            [
                "uuid" => Str::uuid(),
                "shop_id" => 2,
                "item_id" => 2,
                "quantity" => 2,
                "price" =>10.5,
                "avg_rate" => 10,
                "trending" => true,
                "shop_item_category_id" => 1,
                "offer_id" => null,
            ],
            [
                "uuid" => Str::uuid(),
                "shop_id" => 3,
                "item_id" => 3,
                "quantity" => 10,
                "price" =>10.5,
                "avg_rate" => 10,
                "trending" => false,
                "shop_item_category_id" => 2,
                "offer_id" => null,
            ],
        ];
        //----------------------------------//
        $this->values = [
            [
                "uuid" => Str::uuid(),
                "name" => "small",
                "attribute_id" => 1,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "well done",
                "attribute_id" => 1,
            ],
            [
                "uuid" => Str::uuid(),
                "name" => "red",
                "attribute_id" => 2,
            ]
        ];
        //---------------------------------//
        $this->shopItemAttributes = [
            [
                "uuid" => Str::uuid(),
                "shop_item_id" => 1,
                "value_id" => 1,
                "plus_price" => 0,
            ],
            [
                "uuid" => Str::uuid(),
                "shop_item_id" => 1,
                "value_id" => 2,
                "plus_price" => 10,
            ],
            [
                "uuid" => Str::uuid(),
                "shop_item_id" => 3,
                "value_id" => 3,
                "plus_price" => 5,
            ],
        ];

    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->butData();

        foreach ($this->attributes as $attribute)
            Attribute::create($attribute);

        foreach ($this->countries as $country)
            Country::create($country);

        foreach ($this->cuisines as $cuisine)
            Cuisine::create($cuisine);

        foreach ($this->itemCategories as $itemCategory)
            ItemCategory::create($itemCategory);

        foreach ($this->items as $item)
            Item::create($item);

        foreach ($this->offers as $offer)
            Offer::create($offer);

        foreach ($this->payments as $payment)
            Payment::create($payment);

        foreach ($this->shops as $shop)
            Shop::create($shop);

        foreach ($this->shopItemCategories as $shopItemCategory)
            ShopItemCategory::create($shopItemCategory);

        foreach ($this->shopItems as $shopItem)
            ShopItem::create($shopItem);

        foreach ($this->values as $value)
            Value::create($value);

        foreach ($this->shopItemAttributes as $shopItemAttribute)
            ShopItemAttribute::create($shopItemAttribute);
    }
}
