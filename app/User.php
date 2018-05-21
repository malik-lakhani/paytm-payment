<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email','adhar_no','mobile_no','address'];

     /**
     * Get the comments for the blog post.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction')->where('status', '=', 2);
    }
}
