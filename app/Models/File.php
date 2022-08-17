<?php

namespace App\Models;

use App\Utilities\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'files';
    protected $fillable = [
        'name',
        'format',
        'size',
        'path',
        'privacy',
        'extension'
    ];

    public function sizeFormated()
    {
        return Helper::formatBytes($this->attributes['size'], 1);
    }

    public function absolutePath()
    {
        $privacy = $this->attributes['privacy'];
        $path =  $this->attributes['path'];
        $name =  $this->attributes['name'];

        return storage_path('app/' . $privacy . '/uploads/' . $path) . '/' . $name;
    }

    public function publicPath()
    {
        $privacy = $this->attributes['privacy'];
        $path =  $this->attributes['path'];
        $name =  $this->attributes['name'];

        return asset('storage/uploads/' . $path) . '/' . $name;
    }


    public function pathName()
    {
        $path =  $this->attributes['path'];
        $name =  $this->attributes['name'];

        return $path . '/' . $name;
    }

    public function download()
    {
        return response()->download($this->absolutePath());
    }

    public function view()
    {
        return response()->download($this->absolutePath(), null, [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => 'Thu, 19 Nov 1981 08:52:00 GMT',
        ], null);
    }


}
