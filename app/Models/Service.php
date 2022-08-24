<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tarif_id',
        'payday',
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function tarifs() {
        return $this->hasMany(Tarif::class, 'tarif_group_id', 'tarif_id');
    }
}
