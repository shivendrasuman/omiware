<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentrequest extends Model
{
    use HasFactory;
    protected $table = 'payment_request';
	public $timestamps = true;
	public $incrementing = true;
	protected $fillable = [        
                 'order_id',
                 'mode',
                 'amount',
                 'currency',
                 'description',
                 'name',
                 'email',
                 'phone',
                 'address_line_1',
                 'address_line_2',
                 'city',
                 'state',
                 'country',
                 'zip_code',
                 'hash',
                 'payment_status',
                 'transaction_id',
                 'payment_channel',
                 'creation_datetime'
        ];
}
