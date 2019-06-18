<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class ImagesController extends Controller
{
    public function image($image)
    {
        $img = Image::find($image);
        if ($img !== null) {
            return view('img')->with('path', $img->id);
        } else {
            abort(404);
        }
    }
}
