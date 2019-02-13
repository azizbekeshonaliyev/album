<?php
/**
 * Created by PhpStorm.
 * User: Azizbek Eshonaliyev
 * Date: 1/31/2019
 * Time: 5:19 PM
 */

namespace Bek96\Album;

use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageServiceProvider;

class AlbumServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishFiles();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(ImageServiceProvider::class);
    }

    public function publishFiles(){
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations/'),
        ],'bek96/album db');
        $this->publishes([
            __DIR__ . '/default/' => public_path('/vendor/bek96/album/images'),
        ],'bek96/album default image');

    }
}