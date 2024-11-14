<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}