<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "responsible",
        "age",
        "school_year",
        "school",
        "number",
        "class_value",
        "responsible",
        "responsible_number",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function responsible(){
        return $this->hasOne(Responsible::class);
    }

    public function management(){
        return $this->hasMany(Management::class);
    }
}
