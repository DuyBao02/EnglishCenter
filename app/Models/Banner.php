<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Kyslik\ColumnSortable\Sortable;

class Banner extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'title',
        'picture',
        'user_id',
    ];

    public $sortable = ['id', 'title', 'picture', 'user_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
