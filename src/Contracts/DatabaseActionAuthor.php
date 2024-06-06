<?php declare(strict_types=1);

namespace BadChoice\Thrust\Contracts;

interface DatabaseActionAuthor
{
    public function name(): string;

    public function type(): ?string;

    public function id(): ?int;
}
