<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() {
        $user = User::findOrfail(Auth::id());
        $products = $user->products;
        $totalPrice = 0;

        foreach($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        return view('user.cart', compact('products', 'totalPrice'));
    }

    public function add(Request $request) {
        $itemInCart = Cart::where('user_id', Auth::id())
        ->where('product_id', $request->product_id)->first(); 
        // カートに同じ商品があるか確認 get()で取得すると配列になるためfirst()

        if($itemInCart) {
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        return redirect()->route('user.cart.index');
    }

    public function delete($id) {
        Cart::where('user_id', Auth::id())
        ->where('product_id', $id)->delete();

        return redirect()->route('user.cart.index');
    }

    public function checkout() {
        $user = User::findOrfail(Auth::id());
        $products = $user->products;
        
        // カートに入っている情報
        $lineItems = [];
        foreach($products as $product) {
            $quantity = '';
            $quantity = Stock::where('product_id', $product->id)
            ->sum('quantity');

            if($product->pivot->quantity > $quantity) {
                return redirect()->route('user.cart.index');
            }else{
                $lineItem = [
                    'price_data' => [
                        'unit_amount' => $product->price,
                        'currency' => 'JPY',
 
                    'product_data' => [
                        'name' => $product->name,
                        'description' => $product->information,
                ],
                ],
                'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }

            // } else {
            //     $lineItem = [
            //         'name' => $product->name,
            //         'description' => $product->information,
            //         'amount' => $product->price,
            //         'currency' => 'jpy',
            //         'quantity' => $product->pivot->quantity,
            //     ];
            //     array_push($lineItems, $lineItem);
            // }
        }

        foreach($products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['reduce'],
                'quantity' => $product->pivot->quantity * -1
            ]);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('user.items.index'),
            'cancel_url' => route('user.cart.index'),
        ]);

        $publicKey = env('STRIPE_PUBLIC_KEY');

        return view('user.checkout', compact('session', 'publicKey'));
    }
}
