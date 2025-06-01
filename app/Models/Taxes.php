<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxes extends Model
{
    /** @use HasFactory<\Database\Factories\TaxesFactory> */
    use HasFactory;
    protected $table = 'taxes';
    protected $fillable = [
        'name',
        'description',
        'percentage',
        'is_active'
    ];
}
