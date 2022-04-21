# Album
[![Latest Version on Packagist](https://img.shields.io/packagist/v/bek96/album.svg?style=flat-square)](https://packagist.org/packages/bek96/album)
[![Quality Score](https://img.shields.io/scrutinizer/g/azizbekeshonaliyev/album.svg?style=flat-square)](https://scrutinizer-ci.com/g/bek96/album)
[![Total Downloads](https://img.shields.io/packagist/dt/bek96/album.svg?style=flat-square)](https://packagist.org/packages/bek96/album)

## O'rnatish

Composer yordamida o'rnatish.

``` bash
$ composer require bek96/album
```

Konfiguratsiya fayylarini ko'chirish uchun ushbu commandani ishga tushiring.

    php artisan vendor:publish --provider="Bek96\Album\AlbumServiceProvider"

Album va Image modellari jadvallarini migratsiya qiling.

    php artisan migrate

## Foydalanish.
   
    <?php
    
    namespace App;
    
    use Bek96\Album\Traits\HasAlbum;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    
    class User extends Authenticatable
    {
        use HasAlbum;
    
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'email', 'password',
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];
    }

Albumning asosiy rasmini olish.

       $user->album->image->path

Album asosiy rasmini o'zgartirish
       
       $file   = $request->image;
       $user->album->setImageAsCover($file);
       
Asosiy rasmning quyidagi o'lchamlarini xam olish mumkin.

    $user->album->image->xl->path   1920xauto yoki autox1920    
    $user->album->image->lg->path   1024xauto yoki autox1024
    $user->album->image->md->path   512xauto yoki autox512
    $user->album->image->sm->path   256xauto yoki autox256
    $user->album->image->xs->path   128xauto yoki autox128
    $user->album->image->sp->path   config fayldan o'qiydi x auto yoki autox64

Albumdagi barcha rasmlarni olish.
    
    $user->album->images Rasmlar listini qaytaradi.
    
    Image:
        -   path
        -   xl() : hasOne Image|null
        -   lg() : hasOne Image|null
        -   md() : hasOne Image|null
        -   sm() : hasOne Image|null
        -   xs() : hasOne Image|null
        -   sp() : hasOne Image|null
        
Albumga yangi rasm qo'shish.

    $file   =   $request->image;
    $user->album->addImage($file);      

Albumdan rasm olib tashlash.

    $user->album->removeImage($id) 
    
$id o'chirilishi kerak bo'lgan image id si     
