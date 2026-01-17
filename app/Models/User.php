<?php

namespace App\Models;

use App\Models\Parking;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function generate(string $uuid): void
    {
        $this->name = Str::random(10);
        $this->uuid = $uuid;
        $this->email = Str::random(10) . '@' . Str::random(10) . '.tld';
        $this->password = Hash::make(Str::random(10));
        $this->remember_token = Str::random(60);
        $this->role_id = 3;
        $this->save();
    }

    public function parking()
    {
        return $this->hasOne(Parking::class, 'manager_id');
    }
     /**
     * Check if the user is a manager.
     *
     * @return bool
     */
    public function isManager()
    {
        return $this->parking()->exists();
    }
}
