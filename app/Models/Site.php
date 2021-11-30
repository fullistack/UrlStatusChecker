<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        "url",
        "type",
        "response",
        "email",
    ];

    public function checks(){
        return $this->hasMany(SiteCheck::class,"site_id","id")->orderByDesc("created_at");
    }

    public function check(){
        return $this->hasOne(SiteCheck::class,"site_id","id")->orderByDesc("created_at");
    }
}
