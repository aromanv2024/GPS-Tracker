<?php declare(strict_types=1);

namespace App\Domains\Position\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\CoreApp\Model\Builder\Traits\Gis as GisTrait;
use App\Domains\Refuel\Model\Refuel as RefuelModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Trip\Model\Builder\Trip as TripBuilder;

class Position extends BuilderAbstract
{
    use GisTrait;

    /**
     * @param int $city_id
     *
     * @return self
     */
    public function byCityId(int $city_id): self
    {
        return $this->where('city_id', $city_id);
    }

    /**
     * @param array $city_ids
     *
     * @return self
     */
    public function byCityIds(array $city_ids): self
    {
        return $this->whereIntegerInRaw('city_id', $city_ids);
    }

    /**
     * @param int $country_id
     *
     * @return self
     */
    public function byCountryId(int $country_id): self
    {
        return $this->where('country_id', $country_id);
    }

    /**
     * @param array $country_ids
     *
     * @return self
     */
    public function byCountryIds(array $country_ids): self
    {
        return $this->whereIntegerInRaw('country_id', $country_ids);
    }

    /**
     * @param string $date_utc_at
     *
     * @return self
     */
    public function byDateUtcAt(string $date_utc_at): self
    {
        return $this->where('date_utc_at', $date_utc_at);
    }

    /**
     * @param int $device_id
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     * @param ?string $start_end
     *
     * @return self
     */
    public function byDeviceIdWhenTripStartUtcAtDateBetween(int $device_id, ?string $before_start_utc_at, ?string $after_start_utc_at, ?string $start_end): self
    {
        return $this->byDeviceId($device_id)
            ->whenTripStartUtcAtDateBetween($before_start_utc_at, $after_start_utc_at)
            ->whenTripStartEnd($start_end);
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param float $radius
     *
     * @return self
     */
    public function byFence(float $latitude, float $longitude, float $radius): self
    {
        return $this->inRadius($latitude, $longitude, intval($radius * 1000));
    }

    /**
     * @param int $state_id
     *
     * @return self
     */
    public function byStateId(int $state_id): self
    {
        return $this->where('state_id', $state_id);
    }

    /**
     * @param array $state_ids
     *
     * @return self
     */
    public function byStateIds(array $state_ids): self
    {
        return $this->whereIntegerInRaw('state_id', $state_ids);
    }

    /**
     * @param int $trip_id
     *
     * @return self
     */
    public function byTripId(int $trip_id): self
    {
        return $this->where('trip_id', $trip_id);
    }

    /**
     * @param array $trip_ids
     *
     * @return self
     */
    public function byTripIds(array $trip_ids): self
    {
        return $this->whereIntegerInRaw('trip_id', $trip_ids);
    }

    /**
     * @param \App\Domains\Trip\Model\Builder\Trip $query
     *
     * @return self
     */
    public function byTripQuery(TripBuilder $query): self
    {
        return $this->whereIn('trip_id', $query->select('id'));
    }

    /**
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     *
     * @return self
     */
    public function byTripStartUtcAtDateBetween(?string $before_start_utc_at, ?string $after_start_utc_at): self
    {
        return $this->whereIn('trip_id', TripModel::query()->selectOnly('id')->whenStartUtcAtDateBetween($before_start_utc_at, $after_start_utc_at));
    }

    /**
     * @param int $vehicle_id
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     * @param ?string $start_end
     *
     * @return self
     */
    public function byVehicleIdWhenTripStartUtcAtDateBetween(int $vehicle_id, ?string $before_start_utc_at, ?string $after_start_utc_at, ?string $start_end): self
    {
        return $this->byVehicleId($vehicle_id)
            ->whenTripStartUtcAtDateBetween($before_start_utc_at, $after_start_utc_at)
            ->whenTripStartEnd($start_end);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderByDateUtcAtAsc();
    }

    /**
     * @param string $date_at
     *
     * @return self
     */
    public function nearToDateAt(string $date_at): self
    {
        return $this->where('date_at', '<=', $date_at)->orderByDateAtDesc();
    }

    /**
     * @param string $date_utc_at
     *
     * @return self
     */
    public function nearToDateUtcAt(string $date_utc_at): self
    {
        return $this->where('date_utc_at', '<=', $date_utc_at)->orderByDateUtcAtDesc();
    }

    /**
     * @param string $date_utc_at
     *
     * @return self
     */
    public function nextToDateUtcAt(string $date_utc_at): self
    {
        return $this->where('date_utc_at', '>', $date_utc_at);
    }

    /**
     * @return self
     */
    public function orderByDateAtDesc(): self
    {
        return $this->orderBy('date_at', 'DESC');
    }

    /**
     * @return self
     */
    public function orderByDateUtcAtAsc(): self
    {
        return $this->orderBy('date_utc_at', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByDateUtcAtDesc(): self
    {
        return $this->orderBy('date_utc_at', 'DESC');
    }

    /**
     * @param string ...$columns
     *
     * @return self
     */
    public function selectOnly(string ...$columns): self
    {
        return $this->withoutGlobalScope('selectPointAsLatitudeLongitude')->select($columns);
    }

    /**
     * @return self
     */
    public function selectOnlyLatitudeLongitude(): self
    {
        return $this->withoutGlobalScope('selectPointAsLatitudeLongitude')->selectLatitudeLongitude();
    }

    /**
     * @return self
     */
    public function selectOnlyBoundingBox(): self
    {
        return $this->withoutGlobalScope('selectPointAsLatitudeLongitude')->selectRaw('
            MIN(`position`.`latitude`) AS `latitude_min`,
            MIN(`position`.`longitude`) AS `longitude_min`,
            MAX(`position`.`latitude`) AS `latitude_max`,
            MAX(`position`.`longitude`) AS `longitude_max`
        ');
    }

    /**
     * @return self
     */
    public function selectLatitudeLongitude(): self
    {
        return $this->selectRaw('`position`.`longitude`, `position`.`latitude`, NULL AS `point`');
    }

    /**
     * @return self
     */
    public function selectPointAsLatitudeLongitude(): self
    {
        return $this->selectRaw('
            `id`, `speed`, `direction`, `signal`, `date_at`, `date_utc_at`, `created_at`, `updated_at`,
            `longitude`, `latitude`, `country_id`, `city_id`, `device_id`, `state_id`, `timezone_id`,
            `trip_id`, `user_id`, `vehicle_id`
        ');
    }

    /**
     * @param ?int $user_id
     * @param ?int $vehicle_id
     * @param ?string $before_date_at
     * @param ?string $after_date_at
     *
     * @return self
     */
    public function whenRefuelUserIdVehicleIdDateAtBetween(?int $user_id, ?int $vehicle_id, ?string $before_date_at, ?string $after_date_at): self
    {
        return $this->whereIn('id', RefuelModel::query()->selectOnly('position_id')->whenUserIdVehicleIdDateAtBetween($user_id, $vehicle_id, $before_date_at, $after_date_at));
    }

    /**
     * @param ?string $start_end
     *
     * @return self
     */
    public function whenTripStartEnd(?string $start_end): self
    {
        return match ($start_end) {
            'start' => $this->whereTripStart(),
            'end' => $this->whereTripEnd(),
            default => $this,
        };
    }

    /**
     * @param ?string $before_start_utc_at
     * @param ?string $after_start_utc_at
     *
     * @return self
     */
    public function whenTripStartUtcAtDateBetween(?string $before_start_utc_at, ?string $after_start_utc_at): self
    {
        return $this->when($before_start_utc_at || $after_start_utc_at, static fn ($q) => $q->byTripStartUtcAtDateBetween($before_start_utc_at, $after_start_utc_at));
    }

    /**
     * @param ?int $user_id
     * @param ?int $vehicle_id
     * @param ?string $before_date_at
     * @param ?string $after_date_at
     *
     * @return self
     */
    public function whenTripUserIdVehicleIdStartUtcAtBetween(?int $user_id, ?int $vehicle_id, ?string $before_start_utc_at, ?string $after_start_utc_at): self
    {
        return $this->whereIn('trip_id', TripModel::query()->selectOnly('id')->whenUserIdVehicleIdStartUtcAtBetween($user_id, $vehicle_id, $before_start_utc_at, $after_start_utc_at));
    }

    /**
     * @return self
     */
    public function whereTripEnd(): self
    {
        return $this->whereRaw('`date_utc_at` IN (SELECT MAX(`date_utc_at`) FROM `position` GROUP BY `trip_id`)');
    }

    /**
     * @return self
     */
    public function whereTripStart(): self
    {
        return $this->whereRaw('`date_utc_at` IN (SELECT MIN(`date_utc_at`) FROM `position` GROUP BY `trip_id`)');
    }

    /**
     * @return self
     */
    public function withCity(): self
    {
        return $this->with('city');
    }

    /**
     * @return self
     */
    public function withCityState(): self
    {
        return $this->withCity()->withState();
    }

    /**
     * @return self
     */
    public function withCountry(): self
    {
        return $this->with('country');
    }

    /**
     * @return self
     */
    public function withoutCity(): self
    {
        return $this->whereNull('city_id');
    }

    /**
     * @return self
     */
    public function withDevice(): self
    {
        return $this->with('device');
    }

    /**
     * @return self
     */
    public function withState(): self
    {
        return $this->with('state');
    }

    /**
     * @return self
     */
    public function withTimezone(): self
    {
        return $this->with('timezone');
    }

    /**
     * @return self
     */
    public function withTrip(): self
    {
        return $this->with('trip');
    }

    /**
     * @return self
     */
    public function withVehicle(): self
    {
        return $this->with('vehicle');
    }
}
