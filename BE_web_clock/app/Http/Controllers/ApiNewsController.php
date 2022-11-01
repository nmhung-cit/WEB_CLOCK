<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\admin\ApiNewsRequest;

use Illuminate\Support\Facades\File;
use App\Models\User\News;

class ApiNewsController extends Controller
{
    public function GetNews(){
        $Getnews = News::all();
        return response()->json($Getnews);
    }
    public function Addnews(ApiNewsRequest $request){
        if($request->hasFile('image')){
            $request->file('image')->store('public/images/News');
            $NameImage = $request->file('image')->hashName();
            $news = new News;
            $news->image = $NameImage;
            $news->title = $request->title;
            $news->content = $request->content;
            $news->save();
        }
        $Getnews = News::all();
        return response()->json($Getnews);
    }
    public function DeleteNews(Request $request){
        News::where('id_news',$request->id_news)->delete();
        $linkImage = 'storage/images/News/'.$request->image;
        if(File::exists($linkImage)){
            File::delete($linkImage);
        }
        $Getnews = News::all();
        return response()->json($Getnews);
    }
    public function getnewNews(){
        $news = News::latest()->get()->take(5);
        return response()->json($news);
    }
    public function GetNewsDetail($id){
        $news = News::find($id);
        return response()->json($news);
    }
    public function HomgetnewNews(){
        $news = News::latest()->get()->take(3);
        return response()->json($news);
    }
}
