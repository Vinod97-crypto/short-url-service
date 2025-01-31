<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['email', 'client_id', 'role', 'expires_at', 'token'];

   public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function urls()
    {
        return $this->hasMany(Url::class, 'user_id', 'id'); 
    }
	public function curls()
{
    return $this->hasMany(Url::class, 'client_id', 'client_id');  
}

}