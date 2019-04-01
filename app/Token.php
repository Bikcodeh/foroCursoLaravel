<?php

namespace App;

use App\Mail\TokenMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Token extends Model
{
    protected $guarded = [];

    //Un token pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'token';
    }

    public static function generateFor(User $user)
    {
        $token = new static;

        $token->token = str_random(60);
        
        $token->user()->associate($user);

        $token->save();

        return $token;
    }    

    public function sendByEmail()
    {
        Mail::to($this->user)->send(new TokenMail($this));
    }
}
