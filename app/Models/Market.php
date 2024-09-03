<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'market_name',
        'state',
        'city',
        'address',
        'phone',
        'lat',
        'lng',
    ];

    /**
     * Get the user that owns the market.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the files for the market.
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    //scope search
    public function scopeSearch($query, $search)
    {
        return $search ? $query->where('market_name', 'like', '%'.$search.'%') : $query;
    }

    //scope get markets based on user role
    public function scopeMarkets($query)
    {
        return auth()->user()->hasRole('Vendor') ? $query->where('user_id', auth()->id()) : $query;
    }


}
