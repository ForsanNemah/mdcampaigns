<?php

namespace App\Models;

use App\Enums\allStatus;
use App\Enums\publishedStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
    'campaign_name',
    'start_date',
    'expiry_date',
    'platform_id',
    'campaign_link',
    'clinic_id',
    'daily_exchange',
    'Published',
        'created_at',
        'updated_at'
    ];
public $timestamps=false;
    protected $casts=[
        'campaign_status'=> allStatus::class,
        'Published'=> publishedStatus::class
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
            static::addGlobalScope('AllCampaigns', function (Builder $builder) {
                $builder->orderBy('created_at','desc');
            });
        }
        elseif(isCustomer()){
            static::addGlobalScope('CustomerClinicsCampaigns', function (Builder $builder) {
                $builder->whereRelation('clinic','customer_id','=', auth()->user()->accountable_id)
                    ->orderBy('created_at','ASC');
            });
        }
        elseif(isClinic()){
            static::addGlobalScope('ClinicCampaigns', function (Builder $builder) {
                $builder->where('clinic_id',auth()->user()->accountable_id);
            });
        }
        elseif(isCoordinator()){
            static::addGlobalScope('CoordinatorClinicCampaigns', function (Builder $builder) {
                $coordinator= Coordinator::find(auth()->user()->accountable_id)->first();
                $builder->where('clinic_id',$coordinator->clinic_id);

            });
        }
        elseif(isMarketer()){
            static::addGlobalScope('MarketerClinicCampaigns', function (Builder $builder) {
                $marketer= Marketer::find(auth()->user()->accountable_id)->first();
                $builder->where('clinic_id',$marketer->clinic_id);
            });
        }
    }

    /**
     * Scope a query to only include active Campaigns.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeActive(Builder $query)
    {
        $query->where('campaign_status', 1);
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }
    public function registers(){
        return $this->hasMany(Register::class);
    }
    public function platform(){
     return $this->belongsTo(Platform::class);
     }

    public function registersCounts(): int
    {
    return  $this->hasMany(Register::class)->count();
        //Register::query()->where('campaign_id',$this->id)->count();
    }
    public function getregistersCountsAttribute()
    {
       return $this->getregistersCounts();
    }

    /**
     * Get the campaign's  status.
     *
     * @param  boolean  $value
     * @return string
     */


    public function __construct(array $attributes = array())
    {
        if (isClinic()){
        $this->setRawAttributes(array(
            'clinic_id' =>auth()->user()->accountable_id), true);
        }
        parent::__construct($attributes);
    }
}
