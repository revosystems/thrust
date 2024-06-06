<?php declare(strict_types=1);

namespace BadChoice\Thrust\Models;

use BadChoice\Thrust\Contracts\DatabaseActionAuthor;

final class DatabaseActionDefaultAuthor implements DatabaseActionAuthor
{
    public function name(): string
    {
         if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return $this->runningCommand();
        }

        return auth()->user()?->email ?? 'Unknown';
    }

    public function type(): ?string
    {
        $user = auth()->user();

        return $user ? $user::class : null;
    }

    public function id(): ?int
    {
        $id = auth()->id();

        return is_string($id) ? intval($id) : $id;
    }

    private function runningCommand(): string
    {
        $command = request()->server('argv');
        if (is_array($command)) {
            $command = implode(' ', $command);
        }
        return "php {$command}";
    }
}
