<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class homework extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $incrementing = false; //Xử lý việc khóa chính là chuỗi và không phải cột tự tăng
    protected $primaryKey = 'id_hw';

    protected $fillable = [
        'id_hw',
        'date_delivered',
        'hw_type',
        'note',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
