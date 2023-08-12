<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory; 
    /* Model of clients*/
    protected $filable = ['name', 'year', 'time_subscription', 'type_subscription'];
}
