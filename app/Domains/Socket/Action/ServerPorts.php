<?php declare(strict_types=1);

namespace App\Domains\Socket\Action;

use App\Services\Command\Artisan;

class ServerPorts extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach (array_keys(config('sockets')) as $port) {
            $this->command($port);
        }
    }

    /**
     * @param int $port
     *
     * @return void
     */
    protected function command(int $port): void
    {
        if (in_array($port, $this->data['ports'])) {
            Artisan::new($this->commandString($port))->exec();
        }
    }

    /**
     * @param int $port
     *
     * @return string
     */
    protected function commandString(int $port): string
    {
        return 'socket:server --reset --port='.$port;
    }
}