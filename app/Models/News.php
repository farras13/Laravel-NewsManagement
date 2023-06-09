<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class News extends Model
{
    use HasApiTokens,HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
    ];

    public function NewsComments()
    {
        return $this->hasMany(NewsComments::class, 'news_id', 'id');
    }
}
