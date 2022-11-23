<?php

declare(strict_types=1);

namespace App\Api\Musement\Endpoint;

interface ParserInterface
{
    public function parse(string $rawResponse);
}
