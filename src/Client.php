<?php

namespace Chetkov\GetProxyListClient;

use Chetkov\GetProxyListClient\Assembler\ProxyAssembler;
use Chetkov\GetProxyListClient\DTO\FilterParams;
use Chetkov\GetProxyListClient\DTO\Proxy;
use Chetkov\GetProxyListClient\Exception\ExceededDailyLimitException;
use Chetkov\GetProxyListClient\Exception\InvalidApiKeyException;
use Chetkov\GetProxyListClient\Exception\RequestException;
use Chetkov\GetProxyListClient\Extractor\FilterParamsExtractor;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 * @package Chetkov\GetProxyListClient
 */
class Client
{
    /** @var ClientInterface */
    private $httpClient;

    /** @var FilterParamsExtractor */
    private $filterParamsExtractor;

    /** @var ProxyAssembler */
    private $proxyAssembler;

    /**
     * ApiClient constructor.
     * @param ClientInterface $httpClient
     * @param FilterParamsExtractor $filterParamsExtractor
     * @param ProxyAssembler $proxyAssembler
     */
    public function __construct(
        ClientInterface $httpClient,
        FilterParamsExtractor $filterParamsExtractor,
        ProxyAssembler $proxyAssembler
    ) {
        $this->httpClient = $httpClient;
        $this->filterParamsExtractor = $filterParamsExtractor;
        $this->proxyAssembler = $proxyAssembler;
    }

    /**
     * @param FilterParams $filterParams
     * @return Proxy
     * @throws ClientExceptionInterface
     * @throws ExceededDailyLimitException
     * @throws InvalidApiKeyException
     * @throws RequestException
     */
    public function getProxy(FilterParams $filterParams): Proxy
    {
        $requestMethod = 'GET';
        $params = $this->filterParamsExtractor->extract($filterParams);
        $apiUri = 'https://api.getproxylist.com/proxy?' . http_build_query($params);
        $httpRequest = new Request($requestMethod, $apiUri);

        $response = $this->sendRequest($httpRequest);
        if ($response->getStatusCode() !== 200) {
            $this->handleError($response);
        }

        return $this->handleResponse($response);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws RequestException
     */
    private function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            if (!$response) {
                throw new RequestException(sprintf(
                    'An error occurred while executing the http request: %s', $e->getMessage()
                ), 0, $e);
            }
        }
        return $response;
    }

    /**
     * @param ResponseInterface $response
     * @throws ExceededDailyLimitException
     * @throws InvalidApiKeyException
     * @throws RequestException
     */
    private function handleError(ResponseInterface $response): void
    {
        $errorMessage = $this->getErrorMessageFromResponse($response);
        switch ($response->getStatusCode()) {
            case 403:
                throw new ExceededDailyLimitException($errorMessage, 403);
            case 401:
                throw new InvalidApiKeyException($errorMessage, 401);
            default:
                throw new RequestException($errorMessage, $response->getStatusCode());
        }
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    private function getErrorMessageFromResponse(ResponseInterface $response): string
    {
        $errorMessage = $response->getReasonPhrase();
        if ($body = $response->getBody()->getContents()) {
            $body = json_decode($body, false);
            if (isset($body->error) && json_last_error() === JSON_ERROR_NONE) {
                $errorMessage = $body->error;
            }
        }
        return $errorMessage;
    }

    /**
     * @param ResponseInterface $response
     * @return Proxy
     * @throws RequestException
     */
    private function handleResponse(ResponseInterface $response): Proxy
    {
        $responseBody = $response->getBody()->getContents();
        $responseBody = json_decode($responseBody, false);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RequestException(json_last_error_msg());
        }

        return $this->proxyAssembler->create($responseBody);
    }
}
