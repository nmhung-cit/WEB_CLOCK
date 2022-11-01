<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\admin\ApiProductRequest;
use App\Http\Requests\admin\ApiUpdataProductRequest;
use App\Http\Requests\admin\ApiProductdetailsRequest;
use App\Http\Requests\admin\ApiInsurancesRequest;
use App\Http\Requests\admin\ApiAddImagesRequest;


use Illuminate\Support\Facades\File;
use App\Models\Products;
use App\Models\User\PromotionProduct;
use App\Models\User\ProductDetails;
use App\Models\User\Insurance;
use App\Models\User\imageProduct;



class ApiProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->leftJoin('product_details','id','=','product_details.id_product')
        ->leftJoin('insurances','id','=','insurances.id_product')->get();

        return response()->json($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiProductRequest $request)
    {
        if($request->hasFile('image')){

            $pathToFile = $request->file('image')->store('public/images/products');
            $NameImage = $request->file('image')->hashName();

            $product = new Products;
            $product ->name = $request -> name;
            $product ->image = $NameImage;
            $product ->type_product = $request -> type_product;
            $product ->price = $request -> price;
            $product ->description = $request -> description;
            $product ->status = 0;
            $product ->trademark = $request -> trademark;

            $product->save();

            $product = Products::get();
            return response()->json($product);
        };
        // $product -> fill($request->all());

            
        // return response()->json($product);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApiUpdataProductRequest $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    public function deletes(Request $request){
        foreach($request->Products as $Product){
            if($Product['checked'] == true ){
                $images = imageProduct::where('id_product',$Product['id'])->get('images');
                $delete = Products::where('id',$Product['id'])->delete();

                $destination = 'storage/images/products/'.$Product['image'];
                if(File::exists($destination)){
                    File::delete($destination);
                }
                 foreach($images as $image){
                    $link = 'storage/images/products/'.$image['images'];
                    if(File::exists($link)){
                        File::delete($link);
                    }                     
                }
            }
        }
        $products = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->leftJoin('product_details','id','=','product_details.id_product')
        ->leftJoin('insurances','id','=','insurances.id_product')->get();
        return response()->json($products);
    }
    public function dataupload(ApiUpdataProductRequest $request, $id)
    {
        $product = Products::find($id);
        $image = $product->image;

        $product->name = $request->name;
        $product->type_product = $request->type_product;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->trademark = $request->trademark;
        if($request->hasFile('image')){
            $pathToFile = $request->file('image')->store('public/images/products');
            $NameImage = $request->file('image')->hashName();
            $product->image = $NameImage;

            $destination = 'storage/images/products/'.$image;
            if(File::exists($destination)){
                File::delete($destination);
            }
        }
        else{
            $product->image = $image;
        }
        $product->save();

        $promotion = PromotionProduct::where('id_products',$request->id_product)->first();
        if($promotion===null){

            $promotion = new PromotionProduct;
            $promotion->id_products = $request->id_product;
            $promotion->promotion_price = $request->price_promotion;
            $promotion->save();
        }
        else{
            $promotion->update([
                'promotion_price'=>$request->price_promotion,
            ]);
        }
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->leftJoin('product_details','id','=','product_details.id_product')
        ->leftJoin('insurances','id','=','insurances.id_product')->get();

        return response()->json($product);
    }
    public function UpdateProductDetails(ApiProductdetailsRequest $request){
        $details = ProductDetails::where('id_product',$request->id)->first();
        if($details === null){

            $details = new ProductDetails;
            $details->id_product = $request->id;
            $details->batery = $request->batery;
            $details->material = $request->material;
            $details->material_glass = $request->material_glass;
            $details->glass_shape = $request->glass_shape;
            $details->glass_size = $request->glass_size;
            $details->waterproof_lever = $request->waterproof_lever;
            $details->color = $request->color;
            $details->origin = $request->origin;

            $details->save();
        }
        {
            $details->update([
                'batery'=>$request->batery,
                'material'=>$request->material,
                'material_glass'=>$request->material_glass,
                'glass_shape'=>$request->glass_shape,
                'glass_size'=>$request->glass_size,
                'waterproof_lever'=>$request->waterproof_lever,
                'color'=>$request->color,
                'origin'=>$request->origin,
            ]);
        }
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->leftJoin('product_details','id','=','product_details.id_product')
        ->leftJoin('insurances','id','=','insurances.id_product')->get();

        return response()->json($product);
    }
    public function UpdateInsurances(ApiInsurancesRequest $request){
        $insurances = Insurance::where('id_product',$request->id)->first();
        if($insurances===null){
            $insurances = new Insurance;
            $insurances->id_product = $request->id;
            $insurances->content = $request->content;

            $insurances->save();
        }
        {
            $insurances->update([
                'content'=>$request->content,
            ]);
        }
        $product = Products::leftJoin('promotion_products','id','=','promotion_products.id_products')
        ->leftJoin('product_details','id','=','product_details.id_product')
        ->leftJoin('insurances','id','=','insurances.id_product')->get();

        return response()->json($product);
    }
    public function GetImages($id){
        $image = imageProduct::where('id_product',$id)->get();
        return response()->json($image);
    }
    public function AddImages(ApiAddImagesRequest $request){
        $PathToFile = $request->file('images')->store('public/images/products');
        $NameImage = $request->file('images')->hashName();

        $image = new imageProduct;
        $image->id_product = $request->id_product;
        $image->images = $NameImage;
        $image->descriptions = $request->descriptions;
        $image->save();

        $images = imageProduct::where('id_product',$request->id_product)->get();
        return response()->json($images);
    }
    public function DeleteImages(Request $request){
        $images = imageProduct::find($request->id_image);
        $images->delete();

        $destination = 'storage/images/products/'.$request->images;
                if(File::exists($destination)){
                    File::delete($destination);
                }
        $images = imageProduct::where('id_product',$request->id_product)->get();
        return response()->json($images);
    }
}
