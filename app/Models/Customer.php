<?php

namespace App\Models;

use App\Enums\allStatus;
use Carbon\Carbon;
use Database\Factories\CustomerFactory;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    protected $table='users';
    protected $fillable=[
     'name',
     'user_type',
     'user_phone',
    'user_information',
        'created_at',
        'updated_at'
    ];
    public $timestamps=false;



    /**
     * The "booted" method of the model.
     *
     * @return void
     */

    protected static function booted(): void
    {
        /**
         * global Scope a queries to only get specific DATA based on their type.
         *
         * @param Builder $query
         * @return void
         */if (Filament::auth()->check()) {
        if (isAdmin()) {
            static::addGlobalScope('customer', function (Builder $builder) {
                $builder->where('user_type', 'customer');
            });
        } elseif (isCustomer()) {
            static::addGlobalScope('CurrentCustomer', function (Builder $builder) {
                $builder->where('user_type', 'customer')
                    ->where('id', auth()->user()->accountable_id);
            });
        } elseif (isClinic()) {
            static::addGlobalScope('RelatedCustomer', function (Builder $builder) {
                $clinic = Clinic::find(auth()->user()->accountable_id)->first();
                $builder->where('user_type', 'customer')
                    ->where('id', $clinic->customer_id);
            });
        }
    }
    }

    /**
     * Scope a query to only include active customers.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeActive(Builder $query)
    {
        $query->whereRelation('account','status', 1);
    }

    /**
     * The Model __construct to set user type to a customer when insert data using customer Resource form.
     *
     */
    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes(array(
            'user_type' => 'customer',
            'created_at'=>Carbon::now()), true);
        parent::__construct($attributes);
    }



    public function clinics(){
            return $this->hasMany(Clinic::class);
    }
    public function account(): MorphOne
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    public function accountStatus(): MorphOne
    {
        $customer= $this->morphOne(Account::class, 'accountable')->get('status');
        return $customer->account->sataus;
    }
/*    public function accountStatus($id): MorphOne
    {
        return $this->morphOne(Account::class, 'accountable')->find()->status;
    }*/

    /**
     * Get the customer's  status.
     *
     * @param  boolean  $value
     * @return string
     */
    public function getStatusAttribute($value)
    {

    }

}
