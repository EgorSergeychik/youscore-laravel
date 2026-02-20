<?php

namespace EgorSergeychik\YouScore;

use EgorSergeychik\YouScore\Exceptions\PollingTimeoutException;
use EgorSergeychik\YouScore\Resources\ExpressAnalysisResource;
use EgorSergeychik\YouScore\Resources\RegistrationDataResource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client
{
    public function __construct(
        protected string $baseUrl,
        protected array $apiKeys,
        protected int $timeout,
        protected array $pollingConfig,
    ) {}

    public function buildRequest(string $apiKey): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->acceptJson()
            ->withToken($apiKey)
            ->throw();
    }

    /**
     * @throws PollingTimeoutException
     * @throws ConnectionException
     */
    public function get(string $url, array $query = [], string $apiKey = ''): Response
    {
        $attempts = $this->pollingConfig['enabled'] ? max(1, $this->pollingConfig['max_attempts']) : 1;
        $delay = $this->pollingConfig['delay'];

        for ($i = 1; $i <= $attempts; $i++) {
            $response = $this->buildRequest($apiKey)->get($url, $query);

            if ($response->status() !== 202) {
                return $response;
            }

            if ($i < $attempts) {
                usleep($delay * 1000);
            }
        }

        throw new PollingTimeoutException(
            message: "API is still processing the request after {$attempts} attempts.",
            response: $response
        );
    }

    public function registrationData(): RegistrationDataResource
    {
        $key = $this->apiKeys['data'] ?? '';
        if (empty($key)) {
            throw new \InvalidArgumentException('YouScore: API key for "Data" module is missing.');
        }

        return new RegistrationDataResource($this, $key);
    }

    public function expressAnalysis(): ExpressAnalysisResource
    {
        $key = $this->apiKeys['analytics'] ?? '';
        if (empty($key)) {
            throw new \InvalidArgumentException('YouScore: API key for "Analytics" module is missing.');
        }

        return new ExpressAnalysisResource($this, $key);
    }
}
