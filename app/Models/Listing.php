<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'city',
        'weight',
        'dimensions',
        'status',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ListingPhoto::class)->orderBy('order');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeGifted($query)
    {
        return $query->where('status', 'gifted');
    }

    public function scopeSearch($query, string $search = null)
    {
        if ($search) {
            return $query->whereFullText(['title', 'description'], $search);
        }
        return $query;
    }

    public function scopeFilterByCategory($query, $categoryId = null)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    public function scopeFilterByCity($query, $city = null)
    {
        if ($city) {
            return $query->where('city', 'like', "%{$city}%");
        }
        return $query;
    }
}
