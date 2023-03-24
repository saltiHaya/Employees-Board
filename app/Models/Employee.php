<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_number', 
        'hire_date', 
        'department',
        'job_title',
        'user_id',
        'address_line_1',
        'address_line_2',
        'country',
        'city',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
