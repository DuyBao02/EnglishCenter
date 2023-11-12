<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Kyslik\ColumnSortable\Sortable;

class Feedback extends Model
{
    use HasFactory, Sortable;

    protected $table = 'feedbacks';

    protected $fillable = [
        'comment_content',
        'user_id',
        'datesend'
    ];

    public $sortable = ['id', 'comment_content', 'user_id', 'datesend', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
