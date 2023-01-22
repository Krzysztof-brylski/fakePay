<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $primaryKey="id";

    protected $fillable=[
        'token',
        'originUrl',
        'statusUpdateUrl',
        'toPay',
        'currency',
        'clientEmail',
    ];


}
