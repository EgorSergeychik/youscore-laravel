<?php

namespace EgorSergeychik\YouScore\Tests\Feature;

use EgorSergeychik\YouScore\Facades\YouScore;
use Illuminate\Support\Facades\Http;
use EgorSergeychik\YouScore\Tests\TestCase;

class PollingTest extends TestCase
{
    public function test_it_retries_on_202_status_until_success()
    {
        // Arrange
        Http::fake([
            'api.youscore.com.ua/*' => Http::sequence()
                ->push(['status' => 'Update in progress'], 202)
                ->push(['status' => 'Update in progress'], 202)
                ->push(['name' => ['fullName' => 'ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ "Ю-КОНТРОЛ"']], 200)
        ]);

        // Act
        $response = YouScore::registrationData()->getUnitedStateRegisterData('39404434');

        // Assert
        $this->assertEquals('ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ "Ю-КОНТРОЛ"', $response['name']['fullName']);

        Http::assertSentCount(3);
    }

    public function test_it_stops_retrying_after_max_attempts()
    {
        // Arrange
        config(['youscore.polling.max_attempts' => 2]);

        Http::fake([
            'api.youscore.com.ua/*' => Http::sequence()
                ->push(['status' => 'Update in progress 1'], 202)
                ->push(['status' => 'Update in progress 2'], 202)
                ->push(['name' => ['fullName' => 'ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ "Ю-КОНТРОЛ"']], 200)
        ]);

        // Act
        $response = YouScore::registrationData()->getUnitedStateRegisterData('39404434');

        // Assert
        $this->assertEquals('Update in progress 2', $response['status']);

        Http::assertSentCount(2);
    }
}
