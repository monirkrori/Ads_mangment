<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'user_id',
        'category_id',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' $';
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUserAds($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeWithMainImage($query)
    {
        return $query->with(['images' => function ($q) {
            $q->orderBy('id', 'asc')->limit(1);
        }]);
    }

    // Review count
    public function scopeWithReviewCount($query)
    {
        return $query->withCount('reviews');
    }

}
