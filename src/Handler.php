<?php

namespace Isklad\EgonErrorHandlerBundle;

use Isklad\EgonErrorHandlerBundle\Exception\ErrorApiException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Handler
{
    public function __construct(private readonly HttpClientInterface $client, private string $errorApiUrl, private string $errorApiKey)
    {
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ErrorApiException
     */
    public function push(\Throwable $throwable): void
    {
        $content = $this->content($throwable);
        try {
            $response = $this->report($content);
            if ($response->getStatusCode() !== Response::HTTP_OK) {
                throw new ErrorApiException('Egon Error Api call failed, statusCode: ' . $response->getStatusCode() . ', response: ' . $response->getContent(false));
            }
            $return = json_decode($response->getContent(true), true);
            if(!is_array($return)) {
                throw new ErrorApiException('Egon Error Api call failed, response: ' . $response->getContent(false));
            }
        } catch (TransportExceptionInterface|ServerExceptionInterface $exception) {
            throw new ErrorApiException('Egon Error Api call failed, ' . $exception->getMessage(), 0, $exception);
        }
        if (!isset($return['success']) || $return['success'] !== true) {
            throw new ErrorApiException('Egon Error Api call failed, success!=true, '.json_encode($return));
        }
    }

    /**
     * @param array $data
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    private function report(array $data): ResponseInterface
    {
        return $this->client->request(
            'POST',
            $this->errorApiUrl,
            [
                'body' => $data,
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->errorApiKey,
                ],
            ],
        );
    }

    private function content(\Throwable $throwable): array
    {
        return [
            'message' => $throwable->getMessage(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
        ];
    }
}
