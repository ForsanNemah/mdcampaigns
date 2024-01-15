<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Account
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string $accountable_type
 * @property int $accountable_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $accountable
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 */
	class Account extends \Eloquent implements \Filament\Models\Contracts\HasName {}
}

namespace App\Models{
/**
 * App\Models\Campaign
 *
 * @property int $id
 * @property string $campaign_name
 * @property int $clinic_id
 * @property string|null $start_date
 * @property string|null $expiry_date
 * @property int $platform_id
 * @property string $daily_exchange
 * @property string $campaign_link
 * @property string $campaign_status
 * @property int $Published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Clinic $clinic
 * @property-read mixed $is_published
 * @property-read \App\Models\Platform $platform
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign query()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereCampaignLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereCampaignName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereCampaignStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereDailyExchange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign wherePlatformId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign withoutTrashed()
 */
	class Campaign extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Clinic
 *
 * @property int $id
 * @property string $name
 * @property string $clinic_phone
 * @property string $clinic_location
 * @property string|null $clinic_information
 * @property string $status
 * @property int $customer_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Coordinator> $Coordinators
 * @property-read int|null $coordinators_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Marketer> $Marketers
 * @property-read int|null $marketers_count
 * @property-read \App\Models\Account|null $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Campaign> $campaigns
 * @property-read int|null $campaigns_count
 * @property-read \App\Models\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereClinicInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereClinicLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereClinicPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic withoutTrashed()
 */
	class Clinic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Coordinator
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int $clinic_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Clinic $clinic
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Coordinator withoutTrashed()
 */
	class Coordinator extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $name
 * @property string|null $user_type
 * @property string $user_phone
 * @property string|null $user_information
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Clinic> $clinics
 * @property-read int|null $clinics_count
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer withoutTrashed()
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FollowUpStatus
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Register> $registers
 * @property-read int|null $registers_count
 * @method static \Illuminate\Database\Eloquent\Builder|FollowUpStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FollowUpStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FollowUpStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FollowUpStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|FollowUpStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FollowUpStatus withoutTrashed()
 */
	class FollowUpStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Marketer
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int $clinic_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Clinic $clinic
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Marketer withoutTrashed()
 */
	class Marketer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Platform
 *
 * @property int $id
 * @property string $platform_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Platform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Platform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Platform query()
 * @method static \Illuminate\Database\Eloquent\Builder|Platform whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Platform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Platform wherePlatformName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Platform whereUpdatedAt($value)
 */
	class Platform extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Register
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $marketer_id
 * @property string $register_name
 * @property string $register_phone
 * @property string $register_service
 * @property string $register_information
 * @property string $registration_source
 * @property string $doctor_name
 * @property string $note
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FollowUpStatus> $FollowUpStatus
 * @property-read int|null $follow_up_status_count
 * @method static \Illuminate\Database\Eloquent\Builder|Register newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Register newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Register onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Register query()
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereDoctorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereMarketerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereRegisterInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereRegisterName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereRegisterPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereRegisterService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereRegistrationSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Register withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Register withoutTrashed()
 */
	class Register extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $user_type
 * @property string $user_phone
 * @property string|null $user_information
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $account
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

