<?php declare(strict_types=1);

namespace App\Services\Protocol\GPS103\Parser;

use App\Services\Protocol\Resource\Command as CommandResource;

class Command extends ParserAbstract
{
    /**
     * @return ?\App\Services\Protocol\Resource\Command
     */
    public function resource(): ?CommandResource
    {
        if ($this->bodyIsValid() === false) {
            return null;
        }

        $this->values = explode(',', $this->body);

        return new CommandResource([
            'body' => $this->body,
            'serial' => $this->serial(),
            'type' => $this->type(),
            'response' => $this->response(),
        ]);
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        return (bool)preg_match($this->bodyIsValidRegExp(), $this->body);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/^'
            .'imei:[0-9]+,'    //  0 - serial
            .'[015][0-9]{2},'  //  1 - type
            .'[0-9]{6,},'      //  2 - datetime
            .'[^,]*,'          //  3 - rfid
            .'[FL],'           //  4 - signal
            .'[0-9\.]+,'       //  5 - fix time
            .'[AV],'           //  6 - signal
            .'[0-9]+\.[0-9]+,' //  7 - latitude
            .'[NS],'           //  8 - latitude direction
            .'[0-9]+\.[0-9]+,' //  9 - longitude
            .'[EW],'           // 10 - longitude direction
            .'/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return explode(':', $this->values[0])[1];
    }

    /**
     * @return ?string
     */
    protected function type(): ?string
    {
        return $this->values[1];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return '';
    }
}
