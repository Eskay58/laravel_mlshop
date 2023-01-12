<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Owner;
use App\Models\Product;

class CartService {
    public static function getItemsInCart($items) {
        $products = [];
        
        // カート情報からメール送信に必要な各情報の抽出
;       foreach ($items as $item) {
            // オーナー情報抽出
            $p = Product::findOrFail($item->product_id);
            $owner = $p->shop->owner;
            $ownerInfo = [
                'ownerName' => $owner->name,
                'email' => $owner->email
            ];

            // 商品情報抽出
            $product = Product::where('id', $item->product_id)
            ->select('id', 'name', 'price')->get()->toArray();

            // 在庫情報抽出
            $quantity = Cart::where('product_id', $item->product_id)
            ->select('quantity')->get()->toArray();

            // 配列の結合
            $result = array_merge($product[0], $ownerInfo, $quantity[0]);

            array_push($products, $result);
        }

        return $products;
    }
}