<?php

namespace App\Models;

use App\Enums\allStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Marketer  extends Authenticatable
{
    use HasFactory;
    protected $fillable=[
        'name',
        'clinic_id',
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
            static::addGlobalScope('AllMarketers', function (Builder $builder) {
                $builder->where('id','>',0);
            });
        }
        elseif(isCustomer()){
            static::addGlobalScope('CustomerClinicsMarketers', function (Builder $builder) {
                $builder->whereRelation('clinic','customer_id','=', auth()->user()->accountable_id);
            });
        }
        elseif(isClinic()){
            static::addGlobalScope('ClinicMarketers', function (Builder $builder) {
                $builder->where('clinic_id',auth()->user()->accountable_id);
            });
        }
        elseif(isMarketer()){
            static::addGlobalScope('CurrentMarketer', function (Builder $builder) {
                $builder->where('id',auth()->user()->accountable_id);
            });
        }
    }
    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }
    public function account(): MorphOne
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    public function registers(){
        return $this->hasMany(Register::class);
    }



}
