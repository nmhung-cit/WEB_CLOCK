<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\User\imageProduct;
use App\Models\User\ProductReviews;



class ProductController extends Controller
{
    public function ShearchProduct($name){
        $search = $name;
        $product = Products::where('name', 'LIKE', "%{$search}%")
        ->orWhere('trademark', 'LIKE', "%{$search}%")
        ->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->latest('products.id')
        ->paginate(12);
        return $product;
    }
    //all product
    public function Product(){
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->latest('products.id')
        ->paginate(12);
        return response()->json($product);
    }
    public function productOld(){
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->paginate(12);
        // $product->latest();
        return response()->json($product);
    }
    public function productIncrease(){
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->orderBy('products.price', 'desc')->paginate(12);
        return $product;
    }
    public function productdiscount(){
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->orderBy('products.price', 'asc')->paginate(12);
        return $product;
    }
    //men_clock
    public function MenProduct(){
        $product = Products::where('type_product',0)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->latest('products.id')
        ->paginate(12);
        return response()->json($product);
    }
    public function MenproductOld(){
        $product = Products::where('type_product',0)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->paginate(12);
        return response()->json($product);
    }
    public function MenproductIncrease(){
        $product = Products::where('type_product',0)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->orderBy('products.price', 'desc')->paginate(12);
        return $product;
    }
    public function menproductdiscount(){
        $product = Products::where('type_product',0)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->orderBy('products.price', 'asc')->paginate(12);
        return $product;
    }

    //womem_clock
    public function WomenProduct(){
        $product = Products::where('type_product',1)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->latest('products.id')
        ->paginate(12);
        return response()->json($product);
    }
    public function WomenproductOld(){
        $product = Products::where('type_product',1)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->paginate(12);
        return response()->json($product);
    }
    public function WomenproductIncrease(){
        $product = Products::where('type_product',1)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->orderBy('products.price', 'desc')->paginate(12);
        return $product;
    }
    public function Womenproductdiscount(){
        $product = Products::where('type_product',1)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->orderBy('products.price', 'asc')->paginate(12);
        return $product;
    }

    public function trademark(){
        $trademark = Products::all('trademark');
        $filter = $trademark->unique('trademark');
        return $filter;
    }
    public function getnewproduct(){
        $product = Products::latest()->get()->take(5);
        return response()->json($product);
    }
    public function HomeProductFeatured(){
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->latest('products.id')->get()->take(10);
        return response()->json($product);
    }
    public function HomeproductMen(){
        $product = Products::where('type_product',0)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->latest('products.id')->get()->take(8);
        return response()->json($product);
    }
    public function HomeproductWomen(){
        $product = Products::where('type_product',1)->leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->latest('products.id')->get()->take(8);
        return response()->json($product);
    }
    public function Productdetails($id){
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->leftJoin('product_details','id','=','product_details.id_product')
        ->leftJoin('insurances','id','=','insurances.id_product')
        ->find($id);

        return response()->json($product);
    }
    public function GetImages($id){
        $images = imageProduct::where('id_product',$id)->get();
        return response()->json($images);
    }
    public function GetProductReview($id){
        $reviews = ProductReviews::where('id_product',$id)
        ->Join('users','id_user','users.id')
        ->latest('product_reviews.id_reviews')
        ->select('id_reviews','id_product','id_user','star','comment','feedback',
        'product_reviews.created_at','name','image')->get();
        return response()->json($reviews);
    }
    public function GetStar($id){
        $review = ProductReviews::where('id_product',$id)->get();
        $star = 0;
        $length = $review->count();
        for($i = 0; $i < $length; $i++){
            $star += $review[$i]->star;
        }
        if($star == 0){
            return $star;
        }
        {
            return $star/$length;
        }
    }
}
