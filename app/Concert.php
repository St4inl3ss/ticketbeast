<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Concert
 *
 * @method        static Builder published()
 * @property-read Carbon date
 * @property-read int ticket_price
 *
 * @package App
 */
class Concert extends Model
{
    protected $guarded = [];

    protected $dates = [
        'date',
        'published_at',
    ];

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return string
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('F j, Y');
    }

    /**
     * @return string
     */
    public function getFormattedStartTimeAttribute(): string
    {
        return $this->date->format('g:ia');
    }

    /**
     * @return string
     */
    public function getTicketPriceInDollarsAttribute(): string
    {
        return number_format($this->ticket_price / 100, 2);
    }

    /**
     * @param string $email
     * @param int $ticketQuantity
     * @return Order
     */
    public function orderTickets(string $email, int $ticketQuantity): Order
    {
        /**
         * @var Order $order
         */
        $order = $this->orders()->create(['email' => $email]);

        for ($i = 1; $i <= $ticketQuantity; $i++) {
            $order->tickets()->create([]);
        }

        return $order;
    }
}
