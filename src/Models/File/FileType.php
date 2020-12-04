<?php

namespace Kakhura\LaravelGalleriable\Models\File;

use Kakhura\LaravelGalleriable\Models\Base;

class FileType extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'file_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'display_name',
    ];

    public function files()
    {
        return $this->hasMany(File::class, 'type_id', 'id');
    }
}
