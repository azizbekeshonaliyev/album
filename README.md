# Album

## Installation

Composer yordamida o'rnatish.

``` bash
$ composer require bek96/album
```

## Foydalanish.
   
    <?php
    
    namespace App;
    
    use Bek96\Album\Traits\HasAlbum;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    
    class User extends Authenticatable
    {
        use Notifiable,HasAlbum;
    
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

Albumdagi barcha rasmlarni olish.
    
    $user->album->images Rasmlar listini qaytaradi.
    
    Image:
        -   path
        -   xl() : hasOne Image|null
        -   lg() : hasOne Image|null
        -   md() : hasOne Image|null
        -   sm() : hasOne Image|null
        -   xs() : hasOne Image|null
Albumga yangi rasm qo'shish.
    $file   =   $request->image;
    $user->album->addImage($file);      
Albumdan rasm olib tashlash.
    $user->album->removeImage($id) 
   $id o'chirilishi kerak bo'lgan image id si     