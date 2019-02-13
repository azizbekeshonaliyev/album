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
    /**
     * @return mixed
     */
    public function album()
    {
        if (!$this->getAlbum()->exists())
                $this->getAlbum()->create();

        return $this->getAlbum();
    }

    /**
     * @return mixed
     */
    public function getAlbum():MorphOne
    {
        return $this->morphOne(Album::class, 'albumable');
    }
}