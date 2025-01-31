<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Url extends Model
{
    protected $fillable = ['long_url', 'short_url', 'hits', 'user_id', 'client_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
	
	public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
	public function invitation()
{
    return $this->belongsTo(Invitation::class, 'client_id', 'client_id');  
}

}

