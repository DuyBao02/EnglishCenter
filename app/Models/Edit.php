<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Kyslik\ColumnSortable\Sortable;

class Edit extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;

    protected $casts = [
        'data' => 'json',
    ];


    protected $fillable = [
        'user_id',
        'data',
        'status',
    ];

    public $sortable = ['id', 'user_id', 'status', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
