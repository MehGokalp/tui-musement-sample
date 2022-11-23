<?php

declare(strict_types=1);

namespace App\Api\Musement\Endpoint;

interface ValidatorInterface
{
    public function validate(): void;
}
