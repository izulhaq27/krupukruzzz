<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Order;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email', 
        'password',
        'phone',    
        'address',     
        'city',          
        'province',   
        'postal_code',
        'avatar', // optional: jika ingin ada foto profil
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Appended attributes for convenience
     */
    protected $appends = [
        'full_address',
        'initial',
    ];

    /**
     * Get all orders for the user
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get only active orders (not delivered/cancelled)
     */
    public function activeOrders(): HasMany
    {
        return $this->hasMany(Order::class)->active();
    }

    /**
     * Get only completed orders
     */
    public function completedOrders(): HasMany
    {
        return $this->hasMany(Order::class)
                    ->where('status', Order::STATUS_DELIVERED);
    }

    /**
     * Get only pending orders
     */
    public function pendingOrders(): HasMany
    {
        return $this->hasMany(Order::class)
                    ->where('status', Order::STATUS_PENDING);
    }

    /**
     * Check if user has any pending orders
     */
    public function hasPendingOrders(): bool
    {
        return $this->orders()->where('status', Order::STATUS_PENDING)->exists();
    }

    /**
     * Get the user's latest order
     */
    public function latestOrder()
    {
        return $this->hasOne(Order::class)->latestOfMany();
    }

    /**
     * Get total spent by user
     */
    public function getTotalSpentAttribute()
    {
        return $this->orders()
                    ->where('status', '!=', Order::STATUS_CANCELLED)
                    ->sum('total_amount');
    }

    /**
     * Get formatted total spent
     */
    public function getFormattedTotalSpentAttribute(): string
    {
        return 'Rp ' . number_format($this->total_spent, 0, ',', '.');
    }

    /**
     * Get user's full address
     */
    public function getFullAddressAttribute(): string
    {
        $addressParts = [
            $this->address,
            $this->city,
            $this->province,
            $this->postal_code ? 'Kode Pos: ' . $this->postal_code : null
        ];

        // Filter out empty/null values
        $addressParts = array_filter($addressParts);

        return implode(', ', $addressParts);
    }

    /**
     * Get user's initial for avatar
     */
    public function getInitialAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    /**
     * Get user's order count
     */
    public function getOrderCountAttribute(): int
    {
        return $this->orders()->count();
    }

    /**
     * Check if user has made any orders
     */
    public function hasOrders(): bool
    {
        return $this->orders()->exists();
    }

    /**
     * Scope: Users with orders
     */
    public function scopeHasOrders($query)
    {
        return $query->whereHas('orders');
    }

    /**
     * Scope: Users without orders
     */
    public function scopeNoOrders($query)
    {
        return $query->whereDoesntHave('orders');
    }

    /**
     * Scope: Search users by name or email
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%")
                     ->orWhere('phone', 'like', "%{$search}%");
    }
}