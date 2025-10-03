<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['user_id', 'action', 'table_name', 'record_id', 'description'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
