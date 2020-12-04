<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Story extends Model
{
    //
    use Notifiable;

    protected $fillable = [
        'title', 'body', 'section', 'likes' , 'writer_id', 'images', 'tags', 'share' ,'approved'
    ];

    protected $casts = [
        'upload_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
}
