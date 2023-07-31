<?php

namespace Acme\TestBundle\Tests\TestCase;

use Isklad\EgonErrorHandlerBundle\Exception\ErrorApiException;
use Isklad\EgonErrorHandlerBundle\Handler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Component\HttpFoundation\Response;

class HandlerTest extends TestCase
{
    public function testHandlerWillPushException()
    {
        $expectedRequests = [
            function ($method, $url, $options): MockResponse {
                $this->assertSame('POST', $method);
                $this->assertSame('https://localhost/endpoint', $url);
                $this->stringStartsWith('message=Some+dummy+exception', $options['body']);
                return new MockResponse(json_encode(['success' => true]), [
                    'http_code' => 200,
                ]);
            },
        ];

        $client = new MockHttpClient($expectedRequests);

        $handler = new Handler($client, 'https://localhost/endpoint', 'dummy');
        $exception = new \Exception('Some dummy exception');
        $handler->push($exception);
    }

    public function testHandlerWillFailIfApiFailsWithStatusCode()
    {
        $client = $this->getMockBuilder(ScopingHttpClient::class)->disableOriginalConstructor()->getMock();
        $response = new MockResponse(json_encode(['success' => false]), [
            'http_code' => 500,
        ]);
        $client->expects($this->once())->method('request')
            ->willReturn($response);

        $this->expectException(ErrorApiException::class);

        $handler = new Handler($client, 'https://localhost/endpoint', 'dummy');
        $exception = new \Exception('Some dummy exception');
        $handler->push($exception);
    }

    public function testHandlerWillFailIfApiFailsWithNoSuccess()
    {
        $client = $this->getMockBuilder(ScopingHttpClient::class)->disableOriginalConstructor()->getMock();
        $response = new MockResponse(json_encode(['success' => false]), [
            'http_code' => 200,
        ]);
        $client->expects($this->once())->method('request')
            ->willReturn($response);

        $this->expectException(ErrorApiException::class);

        $handler = new Handler($client, 'https://localhost/endpoint', 'dummy');
        $exception = new \Exception('Some dummy exception');
        $handler->push($exception);
    }
}