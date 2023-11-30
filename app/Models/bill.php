<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Bill extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;

    protected $primaryKey = 'id_bill';

    protected $casts = [
        'name_bill' => 'json',
    ];

    protected $fillable = [
        'name_bill',
        'is_paid',
        'payment_time',
        'tuitionFee',
        'user_id',
    ];

    public $sortable = ['id', 'name_bill', 'user_id', 'payment_time', 'tuitionFee', 'created_at', 'updated_at'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
