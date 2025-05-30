<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'imageable_id', 'imageable_type'];


    public function imageable()
    {
        return $this->morphTo();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
