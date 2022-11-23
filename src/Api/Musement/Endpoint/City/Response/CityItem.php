<?php

declare(strict_types=1);

namespace App\Api\Musement\Endpoint\City\Response;

// DTO
class CityItem
{
    public int $id;
    public string $name;
    public string $latitude; // it's better to keep latitude as string
    public string $longitude; // it's better to keep longitude as string

    // TODO ADD OTHERS
}
