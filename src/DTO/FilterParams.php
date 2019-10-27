<?php

namespace Chetkov\GetProxyListClient\DTO;

use Chetkov\GetProxyListClient\Exception\ValidationException;

/**
 * Class FilterParams
 * @package Chetkov\GetProxyListClient\DTO
 */
class FilterParams
{
    /**
     * Seconds since last tested - /proxy?lastTested=600
     * @var int|null
     */
    private $lastTested;

    /**
     * Available ports - /proxy?port[]=80&port[]=8080
     * @var int[]
     */
    private $portList = [];

    /**
     * How much of your info is hidden: transparent, anonymous or high anonymity - /proxy?anonymity[]=high%20anonymity&anonymity[]=transparent
     * @var string[]
     */
    private $anonymityList = [];

    /**
     * The type: http, socks4, socks4a, socks5, socks5h - /proxy?protocol[]=socks4&protocol[]=socks5
     * @var string[]
     */
    private $protocolList = [];

    /**
     * Supports the Referer header - /proxy?allowsRefererHeader=1
     * @var bool|null
     */
    private $allowsRefererHeader;

    /**
     * Supports the User-Agent header - /proxy?allowsUserAgentHeader=1
     * @var bool|null
     */
    private $allowsUserAgentHeader;

    /**
     * Supports any custom headers - /proxy?allowsCustomHeaders=1
     * @var bool|null
     */
    private $allowsCustomHeaders;

    /**
     * Supports cookies - /proxy?allowsCookies=1
     * @var bool|null
     */
    private $allowsCookies;

    /**
     * Supports POST requests - /proxy?allowsPost=1
     * @var bool|null
     */
    private $allowsPost;

    /**
     * Supports HTTPS requests - /proxy?allowsHttps=1
     * @var bool|null
     */
    private $allowsHttps;

    /**
     * Country it originates from (ISO 3166-1 alpha-2) - /proxy?country[]=CA&country[]=US
     * @var string[]
     */
    private $countryList = [];

    /**
     * Filter out specific countries (ISO 3166-1 alpha-2) - /proxy?notCountry[]=CA&notCountry[]=US
     * @var string[]
     */
    private $notCountryList = [];

    /**
     * The IP - /proxy?ip[]=31.202.117.137&ip[]=211.153.17.151
     * @var string[]
     */
    private $ipList = [];

    /**
     * Optional, removes daily limits - /proxy?apiKey=YOUR_API_KEY
     * @var string|null
     */
    private $apiKey;

    /**
     * Seconds to establish connection - /proxy?maxConnectTime=1
     * @var float|null
     */
    private $maxConnectTime;

    /**
     * Seconds before data is received - /proxy?maxSecondsToFirstByte=1
     * @var float|null
     */
    private $maxSecondsToFirstByte;

    /**
     * Download speed in bytes per second - /proxy?minDownloadSpeed=500
     * @var float|null
     */
    private $minDownloadSpeed;

    /**
     * What percentage uptime the proxy has - /proxy?minUptime=75
     * @var float|null
     */
    private $minUptime;

    /**
     * Returns all matching proxies - Paid only - /proxy?all=1
     * @var bool|null
     */
    private $all;

    /**
     * @return int|null
     */
    public function getLastTested(): ?int
    {
        return $this->lastTested;
    }

    /**
     * @param int|null $lastTested
     * @return FilterParams
     */
    public function setLastTested(?int $lastTested): FilterParams
    {
        $this->lastTested = $lastTested;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getPortList(): array
    {
        return $this->portList;
    }

    /**
     * @param int[] $portList
     * @return FilterParams
     */
    public function setPortList(array $portList): FilterParams
    {
        foreach ($portList as $port) {
            $this->addPort($port);
        }
        return $this;
    }

    /**
     * @param int $port
     * @return FilterParams
     */
    public function addPort(int $port): FilterParams
    {
        $this->portList[] = $port;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAnonymityList(): array
    {
        return $this->anonymityList;
    }

    /**
     * @param string[] $anonymityList
     * @return FilterParams
     * @throws ValidationException
     */
    public function setAnonymityList(array $anonymityList): FilterParams
    {
        foreach ($anonymityList as $anonymity) {
            $this->addAnonymity($anonymity);
        }
        return $this;
    }

    /**
     * @param string $anonymity
     * @return FilterParams
     * @throws ValidationException
     */
    public function addAnonymity(string $anonymity): FilterParams
    {
        if (!in_array($anonymity, Proxy::ALLOWED_ANONYMITY)) {
            throw new ValidationException(sprintf(
                'Invalid value for property anonymity. Expected one of: %s, but received: %s',
                implode(', ', Proxy::ALLOWED_ANONYMITY),
                $anonymity
            ));
        }
        $this->anonymityList[] = $anonymity;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getProtocolList(): array
    {
        return $this->protocolList;
    }

    /**
     * @param string[] $protocolList
     * @return FilterParams
     * @throws ValidationException
     */
    public function setProtocolList(array $protocolList): FilterParams
    {
        foreach ($protocolList as $protocol) {
            $this->addProtocol($protocol);
        }
        return $this;
    }

    /**
     * @param string $protocol
     * @return FilterParams
     * @throws ValidationException
     */
    public function addProtocol(string $protocol): FilterParams
    {
        if (!in_array($protocol, Proxy::ALLOWED_PROTOCOLS)) {
            throw new ValidationException(sprintf(
                'Invalid value for property protocol. Expected one of: %s, but received: %s',
                implode(', ', Proxy::ALLOWED_PROTOCOLS),
                $protocol
            ));
        }
        $this->protocolList[] = $protocol;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowsRefererHeader(): ?bool
    {
        return $this->allowsRefererHeader;
    }

    /**
     * @param bool|null $allowsRefererHeader
     * @return FilterParams
     */
    public function setAllowsRefererHeader(?bool $allowsRefererHeader): FilterParams
    {
        $this->allowsRefererHeader = $allowsRefererHeader;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowsUserAgentHeader(): ?bool
    {
        return $this->allowsUserAgentHeader;
    }

    /**
     * @param bool|null $allowsUserAgentHeader
     * @return FilterParams
     */
    public function setAllowsUserAgentHeader(?bool $allowsUserAgentHeader): FilterParams
    {
        $this->allowsUserAgentHeader = $allowsUserAgentHeader;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowsCustomHeaders(): ?bool
    {
        return $this->allowsCustomHeaders;
    }

    /**
     * @param bool|null $allowsCustomHeaders
     * @return FilterParams
     */
    public function setAllowsCustomHeaders(?bool $allowsCustomHeaders): FilterParams
    {
        $this->allowsCustomHeaders = $allowsCustomHeaders;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowsCookies(): ?bool
    {
        return $this->allowsCookies;
    }

    /**
     * @param bool|null $allowsCookies
     * @return FilterParams
     */
    public function setAllowsCookies(?bool $allowsCookies): FilterParams
    {
        $this->allowsCookies = $allowsCookies;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowsPost(): ?bool
    {
        return $this->allowsPost;
    }

    /**
     * @param bool|null $allowsPost
     * @return FilterParams
     */
    public function setAllowsPost(?bool $allowsPost): FilterParams
    {
        $this->allowsPost = $allowsPost;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowsHttps(): ?bool
    {
        return $this->allowsHttps;
    }

    /**
     * @param bool|null $allowsHttps
     * @return FilterParams
     */
    public function setAllowsHttps(?bool $allowsHttps): FilterParams
    {
        $this->allowsHttps = $allowsHttps;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getCountryList(): array
    {
        return $this->countryList;
    }

    /**
     * @param string[] $countryList
     * @return FilterParams
     */
    public function setCountryList(array $countryList): FilterParams
    {
        foreach ($countryList as $country) {
            $this->addCountry($country);
        }
        return $this;
    }

    /**
     * @param string $country
     * @return FilterParams
     */
    public function addCountry(string $country): FilterParams
    {
        $this->countryList[] = $country;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getNotCountryList(): array
    {
        return $this->notCountryList;
    }

    /**
     * @param string[] $notCountryList
     * @return FilterParams
     */
    public function setNotCountryList(array $notCountryList): FilterParams
    {
        foreach ($notCountryList as $notCountry) {
            $this->addNotCountry($notCountry);
        }
        return $this;
    }

    /**
     * @param string $notCountry
     * @return FilterParams
     */
    public function addNotCountry(string $notCountry): FilterParams
    {
        $this->notCountryList[] = $notCountry;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getIpList(): array
    {
        return $this->ipList;
    }

    /**
     * @param string[] $ipList
     * @return FilterParams
     */
    public function setIpList(array $ipList): FilterParams
    {
        foreach ($ipList as $ip) {
            $this->addIp($ip);
        }
        return $this;
    }

    /**
     * @param string $ip
     * @return FilterParams
     */
    public function addIp(string $ip): FilterParams
    {
        $this->ipList[] = $ip;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * @param string|null $apiKey
     * @return FilterParams
     */
    public function setApiKey(?string $apiKey): FilterParams
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMaxConnectTime(): ?float
    {
        return $this->maxConnectTime;
    }

    /**
     * @param float|null $maxConnectTime
     * @return FilterParams
     */
    public function setMaxConnectTime(?float $maxConnectTime): FilterParams
    {
        $this->maxConnectTime = $maxConnectTime;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMaxSecondsToFirstByte(): ?float
    {
        return $this->maxSecondsToFirstByte;
    }

    /**
     * @param float|null $maxSecondsToFirstByte
     * @return FilterParams
     */
    public function setMaxSecondsToFirstByte(?float $maxSecondsToFirstByte): FilterParams
    {
        $this->maxSecondsToFirstByte = $maxSecondsToFirstByte;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMinDownloadSpeed(): ?float
    {
        return $this->minDownloadSpeed;
    }

    /**
     * @param float|null $minDownloadSpeed
     * @return FilterParams
     */
    public function setMinDownloadSpeed(?float $minDownloadSpeed): FilterParams
    {
        $this->minDownloadSpeed = $minDownloadSpeed;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMinUptime(): ?float
    {
        return $this->minUptime;
    }

    /**
     * @param float|null $minUptime
     * @return FilterParams
     */
    public function setMinUptime(?float $minUptime): FilterParams
    {
        $this->minUptime = $minUptime;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAll(): ?bool
    {
        return $this->all;
    }

    /**
     * @param bool|null $all
     * @return FilterParams
     */
    public function setAll(?bool $all): FilterParams
    {
        $this->all = $all;
        return $this;
    }
}
