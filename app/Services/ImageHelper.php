<?php

/**
 * Created by PhpStorm.
 * User: lucio
 * Date: 12/02/19
 * Time: 09:14
 */

namespace App\Services;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageHelper
{

    public static function saveResize($img) : string
    {
        $img = Image::make($img);

        if($img->mime == 'image/jpeg' || $img->mime == 'image/jpg') {
            $ext = 'jpg';
        }else if($img->mime == 'image/png'){
            $ext = 'png';
        }

        $nameFile = sha1(rand().rand().microtime().uniqid('',true)) . '.'.$ext;

        $date = Carbon::now()->format('Y/m/d');
        $path = 'uploads/' . $date;
        Storage::disk('public')->makeDirectory($path);

        $img->save(storage_path('app/public/'. $path . '/' . $nameFile), 90);

        $file_name = $date . '/' . $nameFile;

        $file = File::create([
            'name' => $nameFile,
            'description' => '',
            'size' => $img->filesize(),
            'format' => 'image/'.$ext,
            'path' => $date,
            'privacy' => 'public',
            'extension' => $ext
        ]);

        return $file;
    }

}
