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
        try {
            $response = $this->httpClient->sendRequest($httpRequest);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($response = $e->getResponse()) {
                $errorMessage = $this->getErrorMessageFromResponse($response);
                switch ($response->getStatusCode()) {
                    case 403:
                        throw new ExceededDailyLimitException($errorMessage, 403, $e);
                    case 401:
                        throw new InvalidApiKeyException($errorMessage, 401, $e);
                    default:
                        throw new RequestException($errorMessage, $response->getStatusCode(), $e);
                }
            }
            throw new RequestException(sprintf(
                'An error occurred while executing the http request: %s', $e->getMessage()
            ), 0, $e);
        }

        $responseBody = $response->getBody()->getContents();
        $responseBody = json_decode($responseBody, false);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RequestException(json_last_error_msg());
        }

        return $this->proxyAssembler->create($responseBody);
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
}
