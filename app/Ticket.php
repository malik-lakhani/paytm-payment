<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['transaction_id', 'adhar_no', 'order_id', 'fee', 'status', 'ticket_unique_id', 'name', 'email', 'mobile_no', 'address'];

}
