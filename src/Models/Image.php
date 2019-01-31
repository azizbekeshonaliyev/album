<?php
/**
 * Created by PhpStorm.
 * User: Azizbek Eshonaliyev
 * Date: 1/31/2019
 * Time: 5:32 PM
 */
namespace Bek96\Album\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as Picture;

class Image extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'images';

    const IMAGE_RESOURCE = "bek96/album/images/";

    /**
     * @var array
     */
    protected $fillable = [
        'path',
        'type',
        'image_id',
        'album_id',
    ];

    static public function store($file = false, $id = null, $album = null){
        /** @var TYPE_NAME $file */

        if (strpos($file->getMimeType(), 'image/') === false)
            return null;

        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
        $name = $timestamp . '-' . rand(0, 100) . '.' . $file->extension();
        $folder = (Image::IMAGE_RESOURCE) . '/initial/';
        $path = public_path($folder);

        $image = Image::find($id);

        if(is_null($image)){
            $image = new Image();
        }
        else{
            $image->delete_all_size();
            $image->delete_file($image->path);
        }

        if(!file_exists(self::IMAGE_RESOURCE))
        {
            @mkdir(self::IMAGE_RESOURCE . 'initial', 0777, false);
        }

        $file->move($path, $name);
        $image->path = $folder . $name;
        $image->album_id = ($album) ? $album->id : null;
        if ($image->save())
            return $image;
        else
            return null;
    }

    /**
     * @param $path
     */
    public function delete_file($path){
        $filename = public_path().'/'.$path;
        File::delete($filename);
    }
    /**
     * Create a directory.
     *
     * @param  string  $path
     * @param  int     $mode
     * @param  bool    $recursive
     * @param  bool    $force
     * @return bool
     */
    public function makeDirectory($path, $mode = 0777, $recursive = false, $force = false)
    {
        if(file_exists($path))
            return true;
        if ($force)
        {
            return @mkdir($path, $mode, $recursive);
        }
        else
        {
            return @mkdir($path, $mode, $recursive);
        }
    }

    public function delete_all_size(){

        $images = $this->all_size;

        foreach ($images as $image) {
            $this->delete_file($image->path);
            $image->delete();
        }

        $this->delete_file($this->path);
        $this->delete();

        return true;
    }

    /**
     * @param null $width
     * @param null $size_type
     * @param null $folder
     */
    public function create_image($width = null, $size_type = null, $folder = null){

        $img = Image::where('image_id', $this->id)->where('type',$size_type)->first();

        if ($img != null)
            return;

        $storagePath = public_path() . '/'  . $this->path;

        try{ $img = Picture::make($storagePath); }
        catch(\Intervention\Image\Exception\NotReadableException  $e){ dd('Rasm ochishda muammo'); }

        $old_height = $img->height();
        $old_width  = $img->width();

        $img = Picture::canvas($old_width, $old_height, 'ffffff');

        $img->insert($storagePath);
        $img->encode('jpg');

        if($old_width >= $old_height)
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        else
            $img->resize(null, $width, function ($constraint) {
                $constraint->aspectRatio();
            });

        $image = new Image();

        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
        $name = $timestamp . '-' . $this->id . '-' . $size_type . '.jpg';

        $path = self::IMAGE_RESOURCE . $folder . '/' . $name;
        $this->makeDirectory(self::IMAGE_RESOURCE . $folder,0777);

        $image->path = $path;
        $image->image_id = $this->id;
        $image->type = $size_type;

        $img->save(public_path().'/'.$path);
        $image->save();
    }

    /**
     * @return mixed
     */
    public function xs(){
        $width = 128;
        $size_type = 'xs';
        $folder = 'xs';
        $this->create_image($width, $size_type, $folder);
        return $this->hasOne(Image::class,'image_id')->whereType($size_type);
    }

    /**
     * @return mixed
     */
    public function sm(){
        $width = 256;
        $size_type = 'sm';
        $folder = 'sm';
        $this->create_image($width, $size_type, $folder);
        return $this->hasOne(Image::class,'image_id')->whereType($size_type);
    }

    /**
     * @return mixed
     */
    public function md(){
        $width = 512;
        $size_type = 'md';
        $folder = 'md';
        $this->create_image($width, $size_type, $folder);
        return $this->hasOne(Image::class,'image_id')->whereType($size_type);
    }

    /**
     * @return mixed
     */
    public function lg(){
        $width = 1024;
        $size_type = 'lg';
        $folder = 'lg';
        $this->create_image($width, $size_type, $folder);
        return $this->hasOne(Image::class,'image_id')->whereType($size_type);
    }

    /**
     * @return mixed
     */
    public function xl(){
        $width = 1920;
        $size_type = 'xl';
        $folder = 'xl';
        $this->create_image($width, $size_type, $folder);
        return $this->hasOne(Image::class,'image_id')->whereType($size_type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function all_size(){
        return $this->hasMany(Image::class);
    }
}