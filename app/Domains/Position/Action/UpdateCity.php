<?php declare(strict_types=1);

namespace App\Domains\Position\Action;

use App\Domains\City\Model\City as CityModel;
use App\Domains\Position\Model\Position as Model;

class UpdateCity extends ActionAbstract
{
    /**
     * @var ?\App\Domains\City\Model\City
     */
    protected ?CityModel $city;

    /**
     * @return \App\Domains\Position\Model\Position
     */
    public function handle(): Model
    {
        $this->city();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function city(): void
    {
        $this->city = $this->row->city_id
            ? $this->row->city
            : $this->factory('City')->action($this->cityData())->getOrNew();
    }

    /**
     * @return array
     */
    protected function cityData(): array
    {
        return [
            'latitude' => $this->row->latitude,
            'longitude' => $this->row->longitude,
        ];
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        if ($this->city?->id === $this->row->city_id) {
            return;
        }

        $this->row->city_id = $this->city->id;
        $this->row->state_id = $this->city->state_id;
        $this->row->country_id = $this->city->country_id;
        $this->row->save();
    }
}
