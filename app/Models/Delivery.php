<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'source_address',
        'delivery_address',
        'customer_id',
        'phone_number',
        'email',
        'size_depth',
        'size_width',
        'size_height',
        'weight',
        'status'
    ];

    public function statuses()
    {
        return $this->hasMany(DeliveryStatus::class,"delivery_id")->orderBy('created_at','desc');
    }

    public static function boot()
    {
        parent::boot();

        self::updated(function(Delivery $delivery){

            if(array_key_exists("status",$delivery->getChanges())) {
                $status = new DeliveryStatus();
                $status->delivery_id = $delivery->id;
                $status->status = $delivery->status;
                $status->save();
            }
        });
    }
}
