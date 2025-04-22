<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterpriseType extends Model
{
    /** @use HasFactory<\Database\Factories\EnterpriseTypeFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'icon',
    ];
}
