<?php

namespace App\Models;

use App\Enums\allStatus;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable implements  HasName,HasAvatar,MustVerifyEmail,FilamentUser
{
    use HasFactory,HasApiTokens,Notifiable,TwoFactorAuthenticatable;
    protected $table='accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'accountable_type',
        'status',
        'accountable_id'
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
        'password' => 'hashed',
        'status'=> allStatus::class
    ];
    public function canAccessPanel(Panel $panel): bool
    {

        return $this->status==allStatus::Active;
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null ;
    }
    /**
     * Get the parent accountable model (user , customer , marketer or clinic ).
     */
    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }
    /**
     * Get the user's first name.
     */
    protected function accountableType(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::of($value)
                ->remove('App\Models\\')
                ->lower()
        );
    }
    public function getNameAttribute($value)
    {
        return $this->getFilamentName();
    }
    public function getFilamentName(): string
    {
            $userTable=$this->accountable_type;
        if ($userTable=='customer'){
            $userTable='user';
        }
        $user = DB::table($userTable.'s')->where('id',$this->accountable_id)->first();
        return $user->name;
    }
}
