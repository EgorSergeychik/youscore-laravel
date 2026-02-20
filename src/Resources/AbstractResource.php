<?php

namespace EgorSergeychik\YouScore\Resources;

use EgorSergeychik\YouScore\Client;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

abstract class AbstractResource
{
    public function __construct(
        protected Client $client,
        protected string $apiKey,
    ) {}

    protected function get(string $url, array $query = []): Response
    {
        return $this->client->get($url, $query, $this->apiKey)->throw();
    }
}
