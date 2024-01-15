<?php

namespace App\Models;

use App\Enums\registerCurrentStatus;
use Carbon\Carbon;
use Database\Factories\RegistertFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUpStatus_Register extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $table='follow_up_status_register';
    protected $primaryKey='id';


    public function coordinator():BelongsTo
    {
        return $this->belongsTo(Coordinator::class);
    }

    public function register():BelongsTo
    {
        return $this->belongsTo(Register::class,'register_id','id');
    }

    public function __construct(array $attributes = array())
    {
            $this->setRawAttributes(array(
                'created_at' =>Carbon::now()), true);
        parent::__construct($attributes);
    }
    public function getFollowUpStatusIdAttribute($value)
    {
        $current_status=FollowUpStatus::find($value);
        return  [
            'current_status'=>$current_status->follow_up_status,
            'status_theme'=>$current_status->status_theme
        ];
    }


    public function status():BelongsTo
    {
        return $this->belongsTo(FollowUpStatus::class,'follow_up_status_id','id');
    }
}
