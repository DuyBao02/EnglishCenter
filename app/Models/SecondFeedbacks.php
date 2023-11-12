<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SecondFeedbacks extends Model
{
    use HasFactory;

    protected $table = 'secondfeedbacks';

    protected $fillable = [
        'comment_content',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
