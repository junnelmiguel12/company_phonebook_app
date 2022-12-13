<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Department extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'departments';
    
    protected $fillable = [
        'user_id',
        'company_id',
        'department_code',
        'department_name'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
