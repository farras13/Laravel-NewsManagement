<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class NewsComments extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'user_id', 'news_id', 'comment'
    ];

    public function News()
    {
        return $this->belongsTo(News::class, 'id', 'news_id');
    }
}
