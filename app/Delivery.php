<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class delivery extends Model
{

	protected $fillable = [
        'deliveryAddress', 'customerName', 'contactPhoneNumber', 'note', 'user_id',
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
