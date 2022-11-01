<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User\Order;
use App\Models\User\OrderDetails;
use App\Models\User\ProductReviews;

use App\Models\Products;


class OderController extends Controller
{
    public function Addder(Request $request){
        $order = new Order;
        $order->id_user = $request->id_user;
        $order->id_shipment_Details = $request->id_shipment_Details;
        $order->id_user = $request->id_user;
        $order->node = $request->node;
        $order->status = '0';
        $order->save();
        return response()->json($order);
    }
    public function AddOrderDetail(Request $request){
        foreach($request->orderdetails as $order){
        $orderdetails = new OrderDetails;
        $orderdetails->fill($order);
        $orderdetails->save();            
        }
    }
    public function GetOrder($id){
        $order = Order::where('id_user',$id)->latest()->get();
        return response()->json($order);
        // $order = 
    }
    public function GetOrderdetails($id){
        $orderdetails = OrderDetails::Join('orders','order_details.id_order','=','orders.id_order')
        ->Join('products','id_product','=','products.id')
        ->where('orders.id_user',$id)->get();

        return response()->json($orderdetails);
    }
    public function CancelOrder($id,$id_user,$status){
        $order = Order::find($id);
        $order->update([
            'status'=>$status,
        ]);
        $order = Order::where('id_user',$id_user)->latest()->get();
        return response()->json($order);
    }
    public function SetReviews(Request $request ){
        foreach($request->reviews as $reviews){
            $Setreviews = new ProductReviews;
            $Setreviews->fill($reviews);
            $Setreviews->save();
        }
        $order = Order::find($request->reviews[0]['id_order']);
        $order->update([
            'status'=>4
        ]);
        $order = Order::where('id_user',$request->reviews[0]['id_user'])->latest()->get();
        return response()->json($order);
    }
    public function GetProductReviews($id){
        $idProduct = OrderDetails::Join('orders','order_details.id_order','orders.id_order')
        ->where('orders.id_order',$id)->Join('products','id','order_details.id_product')
        ->select('id_product')
        ->get();

        $product = Products::whereIn('id',$idProduct)
        ->get();
        return $product;
    }
    //admin
    public function AdimGetOrder(){
        $order = Order::Join('users','orders.id_user','=','users.id')
        ->join('shipment_details','orders.id_shipment_Details','=','shipment_details.id_shipment_details')
        ->select('id_order','orders.id_user','status','node','users.name as userName','orders.created_at',
        'surname','shipment_details.name','phone_number','city_province',
        'district','wards','address')
        ->latest()->get();
        
        return response()->json($order);
    }
    public function AdminGetOrderDetails($id){
        $orderdetails = OrderDetails::where('id_order',$id)
        ->join('products','id_product','=','products.id')
        ->get();
        return response()->json($orderdetails);
    }
    public function UpStatusOrder($id, $status){
        $order = Order::find($id);
        $order->update([
            'status'=>$status,
        ]);

        $order = Order::Join('users','orders.id_user','=','users.id')
        ->join('shipment_details','orders.id_shipment_Details','=','shipment_details.id_shipment_details')
        ->select('id_order','orders.id_user','status','node','users.name as userName','orders.created_at',
        'surname','shipment_details.name','phone_number','city_province',
        'district','wards','address')
        ->latest()->get();
        
        return response()->json($order);
    }
    public function GetFeedbackReviews($id){
        $reviews = ProductReviews::where('id_order',$id)
        ->Join('products','id_product','products.id')
        ->select('id_reviews','id_product','id_user',
        'id_order','star','comment','feedback','name','image','type_product','price')
        ->get();
        return response()->json($reviews);
    }
    public function SetFeedbackReviews(Request $request, $id){
        foreach($request->feedback as $feedback){
            $reviews = ProductReviews::find($feedback['id_reviews']);
            $reviews->update([
                'feedback'=>$feedback['feedback']
            ]);
        }
        $order = Order::find($id);
        $order->update([
            'status'=>5,
        ]);
        return response()->json($order);
    }
}
