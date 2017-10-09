<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Order
 *
 * @property-read string $email
 * @package App
 */
class Order extends Model
{
    protected $guarded = [];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
