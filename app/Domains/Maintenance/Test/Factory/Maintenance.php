<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Maintenance extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Maintenance\Model\Maintenance>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'date_at' => date('Y-m-d'),

            'name' => $this->faker->name,
            'workshop' => $this->faker->name,
            'description' => $this->faker->text,

            'distance' => rand(100, 1000),
            'distance_next' => rand(1000, 10000),
            'amount' => $this->faker->randomFloat(2, 100, 1000),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

            'user_id' => $this->userFirstOrFactory(),
            'vehicle_id' => $this->firstOrFactory(VehicleModel::class),
        ];
    }
}