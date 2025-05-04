<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id",
        "student",
        "name",
        "number",
    ];
    
    public function student(){
        return $this->hasMany(Student::class);
    }
}
