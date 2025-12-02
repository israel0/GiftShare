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
        'upvotes_count',
        'downvotes_count',
        'comments_count',
        'gifted_at'
    ];

    protected $casts = [
        'gifted_at' => 'datetime',
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
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function markAsGifted(): void
    {
        $this->update([
            'status' => 'gifted',
            'gifted_at' => now()
        ]);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeGifted($query)
    {
        return $query->where('status', 'gifted');
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereFullText(['title', 'description'], $search);
    }

    public function scopeFilterByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeFilterByCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }
}
