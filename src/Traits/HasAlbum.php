<?php


namespace Bek96\Album\Traits;

/**
 * Created by PhpStorm.
 * User: Azizbek Eshonaliyev
 * Date: 1/31/2019
 * Time: 5:25 PM
 */

use Bek96\Album\Models\Album;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasAlbum
{
    public function album(): MorphOne
    {
        return $this->morphOne(Album::class, 'albumable');
    }

    public function createAlbum()
    {
        if (!$this->album)
            return $this->album()->create();

        return $this->album;
    }

}