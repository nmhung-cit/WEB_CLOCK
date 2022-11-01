<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\user\ApiCartRequest;
use App\Models\User\Cart;

class CartController extends Controller
{
    public function Cart(ApiCartRequest $request){
        
        if(Cart::where('id_user',$request->id_user)->
        where('id_product',$request->id_product)
        ->where('colors',$request->colors)->first())
        {
           $cart = Cart::where('id_user',$request->id_user)->
            where('id_product',$request->id_product)->get();

            $cart[0]->quantity=$cart[0]->quantity + $request->quantity;
            $cart[0]->save();
        }
        else
        {
            $cart = new Cart;
            $cart ->id_product = $request->id_product;
            $cart ->id_user = $request->id_user;
            $cart ->quantity = $request->quantity;
            $cart ->colors = $request->colors;
            $cart->save();
        }
        $cart = Cart::where('id_user',$request->id_user)->get();
        return response()->json($cart);
    }
    public function GetCart(Request $request){
        $cart = Cart::where('id_user',$request->id)->get();
        return response()->json($cart);   
    }
    public function GetProductCart(Request $request){
        $cart = Cart::leftJoin('products','id_product','=','products.id')
        ->leftJoin('promotion_products','carts.id_product','=','promotion_products.id_products')
        ->where('id_user',$request->id)
        ->get();
        return $cart;
    }
    public function DeleteCart(Request $request){
        $cart = Cart::find($request->id_cart);
        $cart->delete();

        $cart = Cart::leftJoin('products','id_product','=','products.id')
        ->leftJoin('promotion_products','carts.id_product','=','promotion_products.id_products')
        ->where('id_user',$request->id_user)->get();
        return $cart;
    }

    public function UpdateCart(Request $request){
        foreach($request->products as $Product){
            $cart = Cart::find($Product['id_cart']);
            if($Product['quantity'] <= 0 ){
                $cart->delete();
            }
            else{
                $cart->quantity = $Product['quantity'];
                $cart->save();
            };
            $id_user = $Product['id_user'];
        }
        $cart = Cart::leftJoin('products','id_product','=','products.id')
        ->leftJoin('promotion_products','carts.id_product','=','promotion_products.id_products')
        ->where('id_user',$id_user)->get();
        return $cart;        
    }
    public function DeleteUserCart($id){
        $cart = Cart::where('id_user',$id)->delete();
        return;
    }
}
