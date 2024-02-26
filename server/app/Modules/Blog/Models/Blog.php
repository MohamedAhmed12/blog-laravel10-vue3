<?php

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Blog\factories\BlogFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use  HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'title',
        'content',
        'published_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    protected static function newFactory(): BlogFactory
    {
        return BlogFactory::new();
    }

}
