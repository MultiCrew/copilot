<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Aircraft{
/**
 * App\Models\Aircraft\Aircraft
 *
 * @property int $id
 * @property string $icao
 * @property string $iata
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Aircraft newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Aircraft newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Aircraft query()
 * @method static \Illuminate\Database\Eloquent\Builder|Aircraft whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aircraft whereIata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aircraft whereIcao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aircraft whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aircraft whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aircraft whereUpdatedAt($value)
 */
	class Aircraft extends \Eloquent {}
}

namespace App\Models\Aircraft{
/**
 * App\Models\Aircraft\ApprovedAircraft
 *
 * @property int $id
 * @property string $icao
 * @property string $name
 * @property string $sim
 * @property bool $approved
 * @property string|null $added_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Flights\FlightRequest[] $flights
 * @property-read int|null $flights_count
 * @property-read \App\Models\FlightSim\Simulator $simulator
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft whereIcao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft whereSim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApprovedAircraft whereUpdatedAt($value)
 */
	class ApprovedAircraft extends \Eloquent {}
}

namespace App\Models\Airports{
/**
 * App\Models\Airports\Airport
 *
 * @property int $id
 * @property string $icao
 * @property string $name
 * @property string $latitude
 * @property string $longitude
 * @property int|null $elevation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Airport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Airport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Airport query()
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereElevation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereIcao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereUpdatedAt($value)
 */
	class Airport extends \Eloquent {}
}

namespace App\Models\FlightSim{
/**
 * App\Models\FlightSim\Simulator
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Simulator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Simulator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Simulator query()
 * @method static \Illuminate\Database\Eloquent\Builder|Simulator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Simulator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Simulator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Simulator whereUpdatedAt($value)
 */
	class Simulator extends \Eloquent {}
}

namespace App\Models\FlightSim{
/**
 * App\Models\FlightSim\WeatherEngine
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WeatherEngine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeatherEngine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeatherEngine query()
 * @method static \Illuminate\Database\Eloquent\Builder|WeatherEngine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeatherEngine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeatherEngine whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeatherEngine whereUpdatedAt($value)
 */
	class WeatherEngine extends \Eloquent {}
}

namespace App\Models\Flights{
/**
 * App\Models\Flights\ArchivedFlight
 *
 * @property int $id
 * @property int $requestee_id
 * @property int $acceptee_id
 * @property string $departure
 * @property string $arrival
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $aircraft_id
 * @property-read \App\Models\Users\User $acceptee
 * @property-read \App\Models\Aircraft\ApprovedAircraft $aircraft
 * @property-read \App\Models\Users\User $requestee
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight whereAccepteeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight whereAircraftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight whereArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight whereDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight whereRequesteeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArchivedFlight whereUpdatedAt($value)
 */
	class ArchivedFlight extends \Eloquent {}
}

namespace App\Models\Flights{
/**
 * App\Models\Flights\FlightPlan
 *
 * @property int $id
 * @property array|null $ofp_json
 * @property int|null $requestee_accept
 * @property int|null $acceptee_accept
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $file
 * @property string|null $dep_stand
 * @property string|null $arr_stand
 * @property-read \App\Models\Flights\FlightRequest $flight
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan whereAccepteeAccept($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan whereArrStand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan whereDepStand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan whereOfpJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan whereRequesteeAccept($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightPlan whereUpdatedAt($value)
 */
	class FlightPlan extends \Eloquent {}
}

namespace App\Models\Flights{
/**
 * Class FlightRequest
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $requestee_id
 * @property int|null $acceptee_id
 * @property int|null $plan_id
 * @property string|null $code
 * @property int $public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $departure
 * @property array|null $arrival
 * @property int $aircraft_id
 * @property string|null $expiry
 * @property string|null $callback
 * @property int|null $client_id
 * @property-read \App\Models\Users\User|null $acceptee
 * @property-read \App\Models\Aircraft\ApprovedAircraft $aircraft
 * @property-read \App\Models\Flights\FlightPlan|null $plan
 * @property-read \App\Models\Users\User $requestee
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest acceptedRequest()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest openRequest()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest plannedFlight()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest public()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest unplannedFlight()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest userPlans()
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereAccepteeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereAircraftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereCallback($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereRequesteeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlightRequest whereUpdatedAt($value)
 */
	class FlightRequest extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\AccessLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property string $user_agent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereUserId($value)
 */
	class AccessLog extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\ApplicationForm
 *
 * @property int $id
 * @property int $user_id
 * @property string $software_dev
 * @property string $flight_sim
 * @property string $network
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users\User|null $requests
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm whereFlightSim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm whereNetwork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm whereSoftwareDev($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationForm whereUserId($value)
 */
	class ApplicationForm extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\Profile
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property bool $show_name
 * @property string|null $picture
 * @property string|null $location
 * @property array|null $sims
 * @property array|null $weather
 * @property bool|null $airac
 * @property string|null $level
 * @property string|null $connection
 * @property string|null $procedures
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereAirac($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereConnection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereProcedures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereShowName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereSims($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereWeather($value)
 */
	class Profile extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property string|null $discord_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users\ApplicationForm|null $application
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Users\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Users\UserNotification|null $userNotification
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDiscordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\UserNotification
 *
 * @property int $id
 * @property int $user_id
 * @property array|null $new_request
 * @property bool $request_accepted
 * @property int $request_accepted_email
 * @property int $request_accepted_push
 * @property int $plan_reviewed
 * @property int $plan_reviewed_email
 * @property int $plan_reviewed_push
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereNewRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification wherePlanReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification wherePlanReviewedEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification wherePlanReviewedPush($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereRequestAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereRequestAcceptedEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereRequestAcceptedPush($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereUserId($value)
 */
	class UserNotification extends \Eloquent {}
}

