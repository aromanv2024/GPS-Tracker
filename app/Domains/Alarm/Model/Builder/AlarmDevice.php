<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model\Builder;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class AlarmDevice extends BuilderAbstract
{
    /**
     * @param int $alarm_id
     *
     * @return self
     */
    public function byAlarmId(int $alarm_id): self
    {
        return $this->where('alarm_id', $alarm_id);
    }

    /**
     * @param int $device_id
     *
     * @return self
     */
    public function byDeviceId(int $device_id): self
    {
        return $this->where('device_id', $device_id);
    }

    /**
     * @param int $device_id
     *
     * @return self
     */
    public function byDeviceIdEnabled(int $device_id): self
    {
        return $this->whereIn('device_id', DeviceModel::query()->selectOnly('id')->byId($device_id)->enabled());
    }

    /**
     * @param string $serial
     *
     * @return self
     */
    public function byDeviceSerial(string $serial): self
    {
        return $this->whereIn('device_id', DeviceModel::query()->selectOnly('id')->bySerial($serial));
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->whereIn('device_id', DeviceModel::query()->selectOnly('id')->byUserId($user_id));
    }
}
