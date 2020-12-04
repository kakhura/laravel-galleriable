<?php

namespace Kakhura\LaravelGalleriable\Models\Gallery;

use Illuminate\Database\Eloquent\Builder;
use Kakhura\LaravelGalleriable\Models\Base;
use Kakhura\LaravelGalleriable\Models\File\File;

/**
 * @property File image
 * @property integer image_id
 * @property integer sort_index
 */
class Gallery extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'galleries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'galleriable_id',
        'galleriable_type',
        'image_id',
        'sort_index',
    ];

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id', 'id');
    }

    public function galleriable()
    {
        return $this->morphTo();
    }

    public function scopeTypeIs($query, string $model)
    {
        /** @var Builder $query */
        $query->where('galleriable_type', $model);
    }
}
