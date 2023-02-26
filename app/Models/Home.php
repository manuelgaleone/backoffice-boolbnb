<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Home extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'rooms', 'beds', 'bathrooms', 'square_meters', 'address', 'latitude', 'longitude', 'cover_image', 'visible', 'sponsored'];

    public static function createSlug($title)
    {
        $home_slug = Str::slug($title);
        return $home_slug;
    }

    /**
     * Get the type that owns the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The tags that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * The tags that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sponsoreds(): BelongsToMany
    {
        return $this->belongsToMany(Sponsored::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }
}
