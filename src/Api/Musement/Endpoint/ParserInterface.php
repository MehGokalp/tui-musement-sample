<?php

namespace App\Api\Musement\Endpoint;

interface ParserInterface
{
    public function parse(string $rawResponse);
}