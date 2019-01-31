<?php

namespace Bek96\Album\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use  \Illuminate\Database\Eloquent\Model;
/**
 * Created by PhpStorm.
 * User: Azizbek Eshonaliyev
 * Date: 1/31/2019
 * Time: 5:31 PM
 */

class Album extends Model
{
    protected $table = 'albums';

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function image(){
        $cover = $this->cover_image;

        if ($cover)
            return  $this->belongsTo(Image::class,'cover_image_id');

        if (!$this->default_image)
        {
            $image = Image::create([
               'path'   => 'vendor/bek96/album/images/default.jpg',
            ]);
            $this->default_image_id = $image->id;
            $this->update();
        }

        return $this->belongsTo(Image::class,'default_image_id');
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function cover_image(){
        return $this->belongsTo(Image::class,'cover_image_id');
    }

    public function default_image(){
        return $this->belongsTo(Image::class,'default_image_id');
    }

    public function addImage($image){
         Image::store($image,null,$this);
    }

    public function removeImage($id)
    {
        $image = Image::find($id);
        if ($image)
            $image->delete_all_size();

        return true;
    }

    public function setImageAsCover($file)
    {
        $image = Image::store($file,$this->cover_image_id,null);
        $this->cover_image_id = ($image) ? $image->id : null;
        $this->update();
    }
}