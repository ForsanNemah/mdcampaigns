<?php

namespace App\Models;

use App\Enums\registerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FollowUpStatus extends Model
{
    use HasFactory;
    protected $table='followupstatus';
    public $timestamps=false;
protected $fillable=[
    'follow_up_status',
    'status_theme'
];

    public function registers(): BelongsToMany
    {
        return $this->belongsToMany(Register::class, 'follow_up_status_register', 'follow_up_status_id', 'register_id')->withPivot(['id','coordinator_id','note'])->withTimestamps();
    }
    public function followUpStatus_Register(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FollowUpStatus_Register::class);
    }
    public function coordinator(){
        return $this->belongsTo(Coordinator::class);
    }
}
