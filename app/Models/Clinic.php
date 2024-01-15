<?php

namespace App\Models;

use App\Enums\allStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'clinic_phone',
        'clinic_location',
        'clinic_information',
        'customer_id',
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
         */
        if(isAdmin()){
            static::addGlobalScope('AllClinics', function (Builder $builder) {
                $builder->orderBy('created_at','DESC');
            });
        }
        elseif(isCustomer()){
            static::addGlobalScope('CustomerClinics', function (Builder $builder) {
                $builder->where('customer_id',auth()->user()->accountable_id);
            });
        }
        elseif(isClinic()){
            static::addGlobalScope('CurrentClinic', function (Builder $builder) {
                $builder->where('id',auth()->user()->accountable_id);
            });
        }

    }

    /**
     * Scope a query to only include active Clinics.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeActive(Builder $query)
    {
        $query->whereRelation('account','status', 1);
    }

    public function account(): MorphOne
    {
        return $this->morphOne(Account::class, 'accountable');
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function Coordinators(){
        return $this->hasMany(Coordinator::class);
    }
    public function campaigns(){
        return $this->hasMany(Campaign::class);
    }

    public function Marketers(){
        return $this->hasMany(Marketer::class);
    }


}
