<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug'];

    public static function createSlug($title)
    {
        $service_slug = Str::slug($title);
        return $service_slug;
    }
    /**
     * The tags that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function homes(): BelongsToMany
    {
        return $this->belongsToMany(Home::class);
    }
}
