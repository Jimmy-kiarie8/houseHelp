<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
    	'about', 'interest', 'quarification', 'mechanic_id', 'user_id', 'reference'
    ];
}
