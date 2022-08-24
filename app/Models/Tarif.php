<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarifs';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'price',
        'link',
        'speed',
        'pay_period',
        'tarif_group_id'
    ];

    public function services() {
        return $this->belongsTo(Service::class, 'tarif_id', 'tarif_group_id');
    }
}
