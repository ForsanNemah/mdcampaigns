<?php

namespace App\Models;

use App\Enums\allStatus;
use App\Enums\publishedStatus;
use App\Enums\registerStatus;
use Database\Factories\RegistertFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Register extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps=false;
    protected $fillable=[
        'note',
        'current_status',
        'updated_at'
    ];


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
            static::addGlobalScope('AllRegisters', function (Builder $builder) {

            });
        }
        elseif(isCustomer()){
            static::addGlobalScope('CustomerClinicsCampaignsRegisters', function (Builder $builder) {
                $builder->whereRelation('campaign.clinic','customer_id','=', auth()->user()->accountable_id);
            });
        }
        elseif(isClinic()){
            static::addGlobalScope('ClinicCampaignsRegisters', function (Builder $builder) {
                $builder->whereRelation('campaign','clinic_id',auth()->user()->accountable_id);
            });
        }
        elseif(isCoordinator()){
            static::addGlobalScope('CoordinatorClinicCampaignsRegisters', function (Builder $builder) {

                $builder->whereRelation('campaign','clinic_id',coordinatorClinic());
            });
        }
        elseif(isMarketer()){
            static::addGlobalScope('MarketerRegisters', function (Builder $builder) {
                $builder->where('marketer_id','=',auth()->user()->accountable_id);
            });
        }
    }



    public function FollowUpStatus(): BelongsToMany
    {
        return $this->belongsToMany(FollowUpStatus::class, 'follow_up_status_register', 'register_id', 'follow_up_status_id')->withPivot(['id','coordinator_id','note'])->withTimestamps();
    }

    public function latestStatus():HasOne
    {
        return $this->hasOne(FollowUpStatus_Register::class,'register_id', 'id')->latest();
    }
    public function campaign():BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function marketer():BelongsTo
    {
        return $this->belongsTo(Marketer::class);
    }


}
