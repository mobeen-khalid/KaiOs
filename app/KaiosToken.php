<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class KaiosToken extends Model
{
    protected $fillable = [
        'kId', 'secret_key',
    ];

    protected $table = 'kaios_token';
}
