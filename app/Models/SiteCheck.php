<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteCheck extends Model
{
    use HasFactory;

    const STATUS_A = 'Available';
    const STATUS_U = 'Unavailable';
    const STATUS_P = 'In process';
    const STATUS_N = 'No data';

    protected $fillable = [
        'site_id',
        'status',
        'error',
    ];

    public function items(){
        return $this->hasMany(SiteCheckItem::class,"site_check_id","id");
    }
}
