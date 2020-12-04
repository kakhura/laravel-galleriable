<?php

namespace Kakhura\LaravelGalleriable\Models\File;

use Kakhura\LaravelGalleriable\Models\Base;
use Kakhura\LaravelGalleriable\Models\Gallery\Gallery;

/**
 * @property string uuid
 * @property int id
 * @property string url
 * @property int type_id
 * @property string url_without_extension
 * @property string filename
 * @property string path
 * @property string extension
 * @property string path_without_extension
 * @property string public_path
 * @property string full_path
 */
class File extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'extension',
        'mime',
        'size',
        'type_id',
        'filename',
        'hash',
    ];

    public function type()
    {
        return $this->belongsTo(FileType::class, 'type_id', 'id');
    }

    public function getUrlAttribute()
    {
        return sprintf('%s.%s', $this->url_without_extension, $this->extension);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->url;
    }

    public function getUrlWithoutExtensionAttribute()
    {
        return sprintf('%s%s%s%s%s', config('custom.constants.website'), DIRECTORY_SEPARATOR, $this->path, DIRECTORY_SEPARATOR, $this->filename);
    }

    public function getFullPathAttribute()
    {
        return sprintf('%s.%s', $this->path_without_extension, $this->extension);
    }

    public function getPublicPathAttribute()
    {
        return sprintf('%s%s%s', $this->path, DIRECTORY_SEPARATOR, $this->filename);
    }

    public function getPathWithoutExtensionAttribute()
    {
        return public_path(sprintf('%s%s%s', $this->path, DIRECTORY_SEPARATOR, $this->filename));
    }

    /**
     * This scope only selects data that is required for generating url.
     *
     * @param $query
     */
    public function scopeOnlyUrlData($query)
    {
        $query->select(['id', 'path', 'extension', 'filename', 'type_id', 'is_old']);
    }

    public function scopeTypeIs($query, int $typeId)
    {
        $query->where('type_id', $typeId);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'image_id', 'id');
    }
}
