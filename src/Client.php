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
        protected string $apiKey,
        protected int $timeout,
        protected array $pollingConfig,
    ) {}

    public function buildRequest(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->acceptJson()
            ->withToken($this->apiKey)
            ->throw();
    }

    /**
     * @throws PollingTimeoutException
     * @throws ConnectionException
     */
    public function get(string $url, array $query = []): Response
    {
        $attempts = $this->pollingConfig['enabled'] ? max(1, $this->pollingConfig['max_attempts']) : 1;
        $delay = $this->pollingConfig['delay'];

        for ($i = 1; $i <= $attempts; $i++) {
            $response = $this->buildRequest()->get($url, $query);

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
        return new RegistrationDataResource($this);
    }

    public function expressAnalysis(): ExpressAnalysisResource
    {
        return new ExpressAnalysisResource($this);
    }
}
