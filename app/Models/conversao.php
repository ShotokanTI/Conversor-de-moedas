<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class conversao extends Model
{
    protected $table = "conversoes";
    protected $fillable = [
        'email',
        'value_before_convertion',
        'currency_origin',
        'target_currency',
        'value_after_convertion',
        'target_currency_quote',
        'source_currency_quote',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
