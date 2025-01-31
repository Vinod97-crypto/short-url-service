<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['email', 'client_id', 'role'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function urls(): HasMany
    {
        return $this->hasMany(Url::class, 'user_id');
    }
}


