<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingAdress extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_name',
        'address',
        'city',
        'state',
        'phone',
        'lat',
        'lng',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}";
    }

// Scope for searching by name or phone number
public function scopeSearch($query, $search)
{
    return $query->where('user_name', 'like', "%{$search}%")
                 ->orWhere('phone', 'like', "%{$search}%");
}

        //scope get markets based on user role
        public function scopeAdresses($query)
        {
            return auth()->user()->hasRole('Vendor') ? $query->where('user_id', auth()->id()) : $query;
        }
    
}
