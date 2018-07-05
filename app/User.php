<?php

namespace App;

// use Laravel\Passport\HasApiTokens;
use App\Notifications\verifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;
	// use HasApiTokens, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'phone', 'location', 'id_no', 'status',
		'current_status', 'current_location', 'cv', 'good_coduct', 'rating', 'verifyToken',
	];

	/**
	 * The roles that belong to the user.
	 */
	public function roles() {
		return $this->belongsToMany('App\Role');
	}

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function verified() {
		return $this->verifyToken === null;
	}

	public function sendVerificationEmail() {
		$this->notify(new verifyEmail($this));
	}

	public function jobs() {
		return $this->hasMany('App\Jobs', 'user_id');
	}
}
