<?php

namespace Tests\Unit;

use App\Plugins\Afas\AfasClient;
use App\Plugins\Afas\AfasConfig;
use Illuminate\Support\Facades\Http;

use Tests\TestCase;

class AfasClientTest extends TestCase
{
    public function testAfasClientIsCreatedWithCorrectHeaders()
    {
        $config = new AfasConfig();
        $config->base64Token = base64_encode('base64Token');
        $config->integrationID = 'integrationID';

        $client = new AfasClient($config);

        $this->assertArrayHasKey('Content-Type', $client->getHeaders());
        $this->assertArrayHasKey('Authorization', $client->getHeaders());
        $this->assertArrayHasKey('IntegrationId', $client->getHeaders());
    }

    public function testAfasClientIsCreatedWithCorrectHeadersWithoutIntegrationId()
    {
        $config = new AfasConfig();
        $config->base64Token = base64_encode('base64Token');

        $client = new AfasClient($config);

        $this->assertArrayHasKey('Content-Type', $client->getHeaders());
        $this->assertArrayHasKey('Authorization', $client->getHeaders());
        $this->assertArrayNotHasKey('IntegrationId', $client->getHeaders());
    }

    public function testAfasClientThrowsRequestExceptionOnInvalidJsonResponse()
    {

        Http::fake([
            '*' => Http::response('invalid json', 200),
        ]);

        $client = new AfasClient(new AfasConfig());

        $this->expectException(\App\Plugins\Afas\RequestException::class);

        $client->get('http://example.com');
    }

    public function testAfasClientThrowsRequestExceptionOnErrorResponse()
    {
        Http::fake([
            '*' => Http::response(['message' => 'error message'], 400),
        ]);

        $client = new AfasClient(new AfasConfig());

        $this->expectException(\App\Plugins\Afas\RequestException::class);

        $client->get('http://example.com');
    }

    public function testAfasClientCorrectlyHandlesValidJsonResponse()
    {
        Http::fake([
            '*' => Http::response(['message' => 'success'], 200),
        ]);

        $client = new AfasClient(new AfasConfig());

        $response = $client->get('http://example.com');

        $this->assertEquals(['message' => 'success'], $response);
    }

}