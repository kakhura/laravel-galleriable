<?php

namespace App\Traits\Models;

use Kakhura\LaravelGalleriable\Gallery\Gallery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Collection gallery
 * @property Collection sortedGallery
 */
trait HasGallery
{
    public function gallery()
    {
        /** @var Model $this */
        return $this->morphMany(Gallery::class, 'galleriable');
    }

    /**
     * This method sync object gallery.
     * It deletes galleries of object and then creates new ones.
     *
     * @param array $images
     * @return void
     */
    public function syncGallery(array $images = [])
    {
        $this->gallery()->delete();
        $this->gallery()->createMany($images);
    }

    public function sortedGallery()
    {
        return $this->gallery()
            ->orderBy('sort_index', 'asc')
            ->orderBy('created_at', 'asc')
            ->with(['image' => function ($query) {
                $query->onlyUrlData();
            }]);
    }
}
