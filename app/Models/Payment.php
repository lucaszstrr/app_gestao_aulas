<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "teacher_id",
        "responsible_id",
        "payer_pix_key",
        "beneficiary_pix_key",
        "rent_value",
        "classes_total_value",
        "beneficiary",
        "rent",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
