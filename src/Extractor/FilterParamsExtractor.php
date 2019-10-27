<?php

namespace Chetkov\GetProxyListClient\Extractor;

use Chetkov\GetProxyListClient\DTO\FilterParams;

/**
 * Class FilterParamsExtractor
 * @package Chetkov\GetProxyListClient\Extractor
 */
class FilterParamsExtractor
{
    /**
     * @param FilterParams $filterParams
     * @return array
     */
    public function extract(FilterParams $filterParams): array
    {
        $result = [];

        $lastTested = $filterParams->getLastTested();
        if (null !== $lastTested) {
            $result['lastTested'] = $lastTested;
        }

        $portList = $filterParams->getPortList();
        if (!empty($portList)) {
            $result['port'] = $portList;
        }

        $anonymityList = $filterParams->getAnonymityList();
        if (!empty($anonymityList)) {
            $result['anonymity'] = $anonymityList;
        }

        $protocolList = $filterParams->getProtocolList();
        if (!empty($protocolList)) {
            $result['protocol'] = $protocolList;
        }

        $allowsRefererHeader = $filterParams->getAllowsRefererHeader();
        if (null !== $allowsRefererHeader) {
            $result['allowsRefererHeaders'] = $allowsRefererHeader;
        }

        $allowsUserAgentHeader = $filterParams->getAllowsUserAgentHeader();
        if (null !== $allowsUserAgentHeader) {
            $result['allowsUserAgentHeader'] = $allowsUserAgentHeader;
        }

        $allowsCustomHeaders = $filterParams->getAllowsCustomHeaders();
        if (null !== $allowsCustomHeaders) {
            $result['allowsCustomHeader'] = $allowsCustomHeaders;
        }

        $allowsCookies = $filterParams->getAllowsCookies();
        if (null !== $allowsCookies) {
            $result['allowsCookies'] = $allowsCookies;
        }

        $allowsPost = $filterParams->getAllowsPost();
        if (null !== $allowsPost) {
            $result['allowsPost'] = $allowsPost;
        }

        $allowsHttps = $filterParams->getAllowsHttps();
        if (null !== $allowsHttps) {
            $result['allowsHttps'] = $allowsHttps;
        }

        $countryList = $filterParams->getCountryList();
        if (!empty($countryList)) {
            $result['country'] = $countryList;
        }

        $notCountryList = $filterParams->getNotCountryList();
        if (!empty($notCountryList)) {
            $result['notCountry'] = $notCountryList;
        }

        $ipList = $filterParams->getIpList();
        if (!empty($ipList)) {
            $result['ip'] = $ipList;
        }

        $apiKey = $filterParams->getApiKey();
        if (null !== $apiKey) {
            $result['apiKey'] = $apiKey;
        }

        $maxConnectTime = $filterParams->getMaxConnectTime();
        if (null !== $maxConnectTime) {
            $result['maxConnectTime'] = $maxConnectTime;
        }

        $maxSecondsToFirstByte = $filterParams->getMaxSecondsToFirstByte();
        if (null !== $maxSecondsToFirstByte) {
            $result['maxSecondsToFirstByte'] = $maxSecondsToFirstByte;
        }

        $minDownloadSpeed = $filterParams->getMinDownloadSpeed();
        if (null !== $minDownloadSpeed) {
            $result['minDownloadSpeed'] = $minDownloadSpeed;
        }

        $minUptime = $filterParams->getMinUptime();
        if (null !== $minUptime) {
            $result['minUptime'] = $minUptime;
        }

        $all = $filterParams->getAll();
        if (null !== $all) {
            $result['all'] = $all;
        }

        return $result;
    }
}
