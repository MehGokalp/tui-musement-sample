<?php

declare(strict_types=1);

namespace App\Api\Musement\Endpoint;

use App\Api\ApiException;

interface EndpointInterface
{
    /**
     * @throws ApiException
     */
    public function fetch(array $options): ResponseInterface;
}
