<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @codeCoverageIgnore
 */
class ApiException extends \Exception
{
    public function __construct(string $message = '', ?\Throwable $previous = null, private readonly ?ResponseInterface $response = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
