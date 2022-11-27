<?php declare(strict_types=1);

namespace App\Domains\Device\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdateAlarm extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'related' => ['bail', 'array'],
            'related.*' => ['bail', 'integer'],
        ];
    }
}
