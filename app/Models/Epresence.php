<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Epresence extends Model
{
    use HasFactory;

    protected $table = 'epresence';

    public function user() {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
