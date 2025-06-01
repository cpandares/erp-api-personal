<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BancosSaldo extends Model
{
    /** @use HasFactory<\Database\Factories\BancosSaldoFactory> */
    use HasFactory;
    protected $table = 'bancos_saldos';
    /* nombre_banco
numero_cuenta
saldo */
    protected $fillable = [
        'nombre_banco',
        'numero_cuenta',
        'saldo',
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    public function getSaldoFormattedAttribute()
    {
        return number_format($this->saldo, 2, '.', ',');
    }
    public function getSaldoFormattedWithCurrencyAttribute()
    {
        return '$' . $this->getSaldoFormattedAttribute();
    }
}
