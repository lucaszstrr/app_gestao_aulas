<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;

    protected $table = 'managements';

    protected $fillable = [
        "student_id",
        "teacher_id",
        "quantity_classes",
        "class_value",
        "total_value",
        "paid",
        "description",
    ];

    public function students(){
        return $this->hasOne(Student::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }
}
