<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\allStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $fillable = [
        'name',
        'user_phone',
        'user_type',
        'user_information',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $casts=[
        'status'=> allStatus::class
    ];
    protected $attributes;
    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes(array(
        'user_type' => 'admin',
        ), true);
        parent::__construct($attributes);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('admin', function (Builder $builder) {
            $builder->where('user_type','admin');
        });
    }
    /**
     * Get the user's  status.
     *
     * @param  boolean  $value
     * @return string
     */

    /**
     * Get the user's account.
     */
    public function account(): MorphOne
    {
        return $this->morphOne(Account::class, 'accountable');
    }
}
