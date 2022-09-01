<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Storage;
use App\Models\Agency;

class RealEstate extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'address',
        'price',
        'number_of_rooms',
        'description',
        'is_rent',
        'rented_at',
        'agency_id',
        'type',
		'sold_date'
    ];

    public function images()
	{
		return $this->hasMany(Storage::class);
	}

    public function agency()
	{
		return $this->belongsTo(Agency::class);
	}
}
