<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\admin\ApiAddImageSlideRquest;

use App\Models\Slides;
use Illuminate\Support\Facades\File;

class ApiSlideController extends Controller
{
    public function GetImageSlide(){
        $Slide = Slides::all();
        return $Slide;
    }
    public function AddSlide(ApiAddImageSlideRquest $request){
        if($request->hasFile('image')){
            $request->file('image')->store('public/images/Slides');
            $NameImage = $request->file('image')->hashName();
            $ImageSlide = new Slides;
            $ImageSlide->image = $NameImage;
            $ImageSlide->save();

            $Slide = Slides::all();
            return $Slide;
        }
    }
    public function DeleteImageSlide(Request $request){
        Slides::where('id_slide',$request->id_slide)->delete();
        $linkImage = 'storage/images/Slides/'.$request->image;
        if(File::exists($linkImage)){
            File::delete($linkImage);
        }
        $Slide = Slides::all();
        return $Slide;
    }
}
