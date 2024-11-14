<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'tracking_code',
        'commune_id',
        'delivery_type_id',
        'status_id',
        'store_id',
        'address',
        'can_be_opened',
        'name',
        'client_first_name',
        'client_last_name',
        'client_phone',
        'client_phone2',
        'cod_to_pay',
        'commission',
        'status_updated_at',
        'delivered_at',
        'delivery_price',
        'extra_weight_price',
        'free_delivery',
        'packaging_price',
        'partner_cod_price',
        'partner_delivery_price',
        'partner_return',
        'price',
        'price_to_pay',
        'return_price',
        'total_price',
        'weight',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $package) {
            $package->uuid = Str::uuid();
            $package->tracking_code = Str::random(10);
        });
    }

    protected function clientFullName(): Attribute
    {
        return Attribute::make(get: fn() => "{$this->client_first_name} {$this->client_last_name}");
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PackageStatus::class);
    }

    public function deliveryType(): BelongsTo
    {
        return $this->belongsTo(DeliveryType::class);
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }
}
