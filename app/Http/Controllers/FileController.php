<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function uploadsinglefile(Request $request){

        // $filespath =null;
        if($request->has('file'))
            {
                $fileName = time().'_'.$request->file->getClientOriginalName();
                $request->file->move(public_path('/img/temp/avatars'),$fileName);
                return '/img/temp/avatars/'.$fileName;
            }

        // return $request->all();
    }
}
