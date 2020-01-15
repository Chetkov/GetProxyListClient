<?php

namespace Chetkov\GetProxyListClient;

use Chetkov\GetProxyListClient\Assembler\ProxyAssembler;
use Chetkov\GetProxyListClient\DTO\FilterParams;
use Chetkov\GetProxyListClient\DTO\Proxy;
use Chetkov\GetProxyListClient\Exception\ExceededDailyLimitException;
use Chetkov\GetProxyListClient\Exception\InvalidApiKeyException;
use Chetkov\GetProxyListClient\Exception\RequestException;
use Chetkov\GetProxyListClient\Exception\ValidationException;
use Chetkov\GetProxyListClient\Extractor\FilterParamsExtractor;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 * @package Chetkov\GetProxyListClient
 */
class Client implements ClientInterface
{
    /** @var HttpClientInterface */
    private $httpClient;

    /** @var FilterParamsExtractor */
    private $filterParamsExtractor;

    /** @var ProxyAssembler */
    private $proxyAssembler;

    /**
     * Client constructor.
     * @param HttpClientInterface $httpClient
     * @param FilterParamsExtractor $filterParamsExtractor
     * @param ProxyAssembler $proxyAssembler
     */
    public function __construct(
        HttpClientInterface $httpClient,
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
     * @throws ExceededDailyLimitException
     * @throws InvalidApiKeyException
     * @throws RequestException
     * @throws ValidationException
     */
    public function getProxy(FilterParams $filterParams): Proxy
    {
        if ($filterParams->getAll()) {
            throw new ValidationException('If you want to get all proxies you should use getList method');
        }

        $responseBody = $this->execute($filterParams);
        return $this->proxyAssembler->create($responseBody);
    }

    /**
     * @param FilterParams $filterParams
     * @return Proxy[]
     * @throws ExceededDailyLimitException
     * @throws InvalidApiKeyException
     * @throws RequestException
     */
    public function getList(FilterParams $filterParams): array
    {
        $filterParams->setAll(true);
        if (!$filterParams->getApiKey()) {
            throw new ValidationException('If you want to get all proxies you should set api_key');
        }

        $result = [];
        $responseBody = $this->execute($filterParams);
        foreach ($responseBody as $key => $proxyData) {
            if ($key === '_links') {
                continue;
            }
            $result[] = $this->proxyAssembler->create($proxyData);
        }
        return $result;
    }

    /**
     * @param FilterParams $filterParams
     * @return \stdClass
     * @throws ExceededDailyLimitException
     * @throws InvalidApiKeyException
     * @throws RequestException
     */
    private function execute(FilterParams $filterParams): \stdClass
    {
        $requestMethod = 'GET';
        $params = $this->filterParamsExtractor->extract($filterParams);
        $apiUri = 'https://api.getproxylist.com/proxy?' . http_build_query($params);
        $httpRequest = new Request($requestMethod, $apiUri);

        $response = $this->sendRequest($httpRequest);
        if ($response->getStatusCode() !== 200) {
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

        $responseBody = $response->getBody()->getContents();
        $responseBody = json_decode($responseBody, false);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RequestException(sprintf('JSON parsing error: %s', json_last_error_msg()));
        }

        return $responseBody;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws RequestException
     */
    private function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->httpClient->send($request);
        } catch (GuzzleException $e) {
            if ($e instanceof \GuzzleHttp\Exception\RequestException) {
                $response = $e->getResponse();
            }
            if (!isset($response)) {
                throw new RequestException(sprintf(
                    'An error occurred while executing the http request: %s', $e->getMessage()
                ), 0, $e);
            }
        }
        return $response;
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
            if (isset($body->error)) {
                $errorMessage = $body->error;
            }
        }
        return $errorMessage;
    }
}
