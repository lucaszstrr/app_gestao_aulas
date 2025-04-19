<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id",
        "teacher_id",
        "quantity_classes",
        "class_value",
        "total_value",
        "paid",
    ];

    public function student(){
        return $this->hasOne(Student::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }
}
