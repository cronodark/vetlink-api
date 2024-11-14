<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'last_seen',
        'description',
        'characteristics',
        'pet_image',
        'id_user',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function comments()
    {
        return $this->hasMany(ForumComment::class);
    }

}
