<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_as',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'alamat',
        'tanda_tangan',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'id');
    }

    public function registrasiPengambilan()
    {
        return $this->hasOne(RegistrasiPengambilan::class, 'id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the regency associated with the biodata.
     */
    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    /**
     * Get the district associated with the biodata.
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the village associated with the biodata.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function pendataanSurveyorSiswa()
    {
        return $this->hasMany(PendataanSurveyorSiswa::class, 'id_user');
    }
}
