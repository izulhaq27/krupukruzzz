<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'name',
        'phone',
        'address',
        'total_amount',
        'snap_token',
        'payment_type',
        'transaction_id',
        'status',
        'payment_proof',
        'bank_name',
        'paid_at',
        'email',
        //couriers
        'shipping_courier',
        'shipping_service',
        'shipping_cost',
        'tracking_number',
        'shipped_at',
        'estimated_delivery',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'estimated_delivery' => 'date'
    ];

    /**
     * Attributes to append
     */
    protected $appends = [
        'tracking_link',
        'status_color',
        'formatted_total_amount',
        'formatted_shipping_cost'
    ];

    /**
     * Status constants for consistency
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_PROCESSING = 'processed';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Accessor for formatted total amount
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Accessor for formatted shipping cost
     */
    public function getFormattedShippingCostAttribute(): string
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    /**
     * Accessor untuk link tracking
     */
    public function getTrackingLinkAttribute(): ?string
    {
        if (!$this->tracking_number) {
            return null;
        }
        
        $couriers = [
            'jne' => 'https://cekresi.com/?carrier=jne&awb=',
            'tiki' => 'https://cekresi.com/?carrier=tiki&awb=',
            'pos' => 'https://cekresi.com/?carrier=pos&awb=',
            'sicepat' => 'https://cekresi.com/?carrier=sicepat&awb=',
            'jnt' => 'https://cekresi.com/?carrier=jnt&awb=',
            'anteraja' => 'https://cekresi.com/?carrier=anteraja&awb=',
            'ninja' => 'https://cekresi.com/?carrier=ninja&awb=',
            'wahana' => 'https://cekresi.com/?carrier=wahana&awb=',
            'lion' => 'https://cekresi.com/?carrier=lion&awb=',
        ];
        
        $courier = strtolower($this->shipping_courier ?? 'jne');
        $baseUrl = $couriers[$courier] ?? $couriers['jne'];
        
        return $baseUrl . $this->tracking_number;
    }

    /**
     * Status color helper
     */
    public function getStatusColorAttribute(): string
    {
        $colors = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_PAID => 'info',
            self::STATUS_PROCESSING => 'primary',
            self::STATUS_SHIPPED => 'success',
            self::STATUS_DELIVERED => 'dark',
            self::STATUS_CANCELLED => 'danger'
        ];
        
        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Status label for better display
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            self::STATUS_PENDING => 'Menunggu Pembayaran',
            self::STATUS_PAID => 'Dibayar',
            self::STATUS_PROCESSING => 'Diproses',
            self::STATUS_SHIPPED => 'Dikirim',
            self::STATUS_DELIVERED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->status !== self::STATUS_PENDING;
    }

    /**
     * Check if order is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    /**
     * Check if order is cancellable
     */
    public function isCancellable(): bool
    {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_PAID,
            self::STATUS_PROCESSING
        ]);
    }

    /**
     * Scope untuk pesanan yang aktif (belum selesai/dibatalkan)
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED
        ]);
    }

    /**
     * Scope untuk pesanan berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk pesanan pending
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Relasi ke user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke order items
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Calculate subtotal from items
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Calculate total with shipping
     */
    public function getGrandTotalAttribute()
    {
        return $this->subtotal + $this->shipping_cost;
    }
}