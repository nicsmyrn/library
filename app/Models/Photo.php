<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model
{
    //
    protected $fillable = [
        'path',
        'type',
        'thumbnail_path',
        'name'
    ];

    protected $baseDir = 'img/books/photos';

    public function imageable(){
        return $this->morphTo();
    }

    public static function named($name, $type)
    {
        return (new static)->saveAs($name,$type);
    }

    public function move(UploadedFile $file){
        $file->move($this->baseDir,  $this->name);
        $this->makeThumbnail();
    }

    public function saveAs($name, $type){
        $this->name = sprintf("%s-%s", time(), $name);
        $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
        $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);
        $this->type = $type;

        return $this;
    }

    private function makeThumbnail()
    {
        Image::make($this->path)
            ->fit(200)
            ->save($this->thumbnail_path);
    }
}
