<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
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
}
