<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class demo extends Controller
{
    public function demo(Request $request){
        $pathToFile = $request->file('image')->store('images','public');
        // return $pathToFile;
    }
}
