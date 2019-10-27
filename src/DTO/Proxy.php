<?php

namespace Chetkov\GetProxyListClient\DTO;

/**
 * Class Proxy
 * @package Chetkov\GetProxyListClient\DTO
 */
class Proxy
{
    public const PROTOCOL_HTTP = 'http';
    public const PROTOCOL_SOCKS4 = 'socks4';
    public const PROTOCOL_SOCKS4A = 'socks4a';
    public const PROTOCOL_SOCKS5 = 'socks5';
    public const PROTOCOL_SOCKS5H = 'socks5h';
    public const ALLOWED_PROTOCOLS = [
        self::PROTOCOL_HTTP,
        self::PROTOCOL_SOCKS4,
        self::PROTOCOL_SOCKS4A,
        self::PROTOCOL_SOCKS5,
        self::PROTOCOL_SOCKS5H,
    ];

    public const ANONYMITY_TRANSPARENT = 'transparent';
    public const ANONYMITY_ANONYMOUS = 'anonymous';
    public const ANONYMITY_HIGH = 'high anonymity';
    public const ALLOWED_ANONYMITY = [
        self::ANONYMITY_TRANSPARENT,
        self::ANONYMITY_ANONYMOUS,
        self::ANONYMITY_HIGH,
    ];

    /** @var string */
    private $ip;

    /** @var int */
    private $port;

    /** @var string */
    private $protocol;

    /** @var string */
    private $anonymity; //": "high anonymity",

    /** @var \DateTimeImmutable */
    private $lastTested;

    /** @var bool */
    private $allowsRefererHeader;

    /** @var bool */
    private $allowsUserAgentHeader;

    /** @var bool */
    private $allowsCustomHeaders;

    /** @var bool */
    private $allowsCookies;

    /** @var bool */
    private $allowsPost;

    /** @var bool */
    private $allowsHttps;

    /** @var string */
    private $country;

    /** @var float */
    private $connectTime;

    /** @var float */
    private $downloadSpeed;

    /** @var float */
    private $secondsToFirstByte;

    /** @var float */
    private $uptime;

    /**
     * Proxy constructor.
     * @param string $ip
     * @param int $port
     * @param string $protocol
     * @param string $anonymity
     * @param \DateTimeImmutable $lastTested
     * @param bool $allowsRefererHeader
     * @param bool $allowsUserAgentHeader
     * @param bool $allowsCustomHeaders
     * @param bool $allowsCookies
     * @param bool $allowsPost
     * @param bool $allowsHttps
     * @param string $country
     * @param float $connectTime
     * @param float $downloadSpeed
     * @param float $secondsToFirstByte
     * @param float $uptime
     */
    public function __construct(
        string $ip,
        int $port,
        string $protocol,
        string $anonymity,
        \DateTimeImmutable $lastTested,
        bool $allowsRefererHeader,
        bool $allowsUserAgentHeader,
        bool $allowsCustomHeaders,
        bool $allowsCookies,
        bool $allowsPost,
        bool $allowsHttps,
        string $country,
        float $connectTime,
        float $downloadSpeed,
        float $secondsToFirstByte,
        float $uptime
    ) {
        $this->ip = $ip;
        $this->port = $port;
        $this->protocol = $protocol;
        $this->anonymity = $anonymity;
        $this->lastTested = $lastTested;
        $this->allowsRefererHeader = $allowsRefererHeader;
        $this->allowsUserAgentHeader = $allowsUserAgentHeader;
        $this->allowsCustomHeaders = $allowsCustomHeaders;
        $this->allowsCookies = $allowsCookies;
        $this->allowsPost = $allowsPost;
        $this->allowsHttps = $allowsHttps;
        $this->country = $country;
        $this->connectTime = $connectTime;
        $this->downloadSpeed = $downloadSpeed;
        $this->secondsToFirstByte = $secondsToFirstByte;
        $this->uptime = $uptime;
    }


    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @return string
     */
    public function getAnonymity(): string
    {
        return $this->anonymity;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLastTested(): \DateTimeImmutable
    {
        return $this->lastTested;
    }

    /**
     * @return bool
     */
    public function isAllowsRefererHeader(): bool
    {
        return $this->allowsRefererHeader;
    }

    /**
     * @return bool
     */
    public function isAllowsUserAgentHeader(): bool
    {
        return $this->allowsUserAgentHeader;
    }

    /**
     * @return bool
     */
    public function isAllowsCustomHeaders(): bool
    {
        return $this->allowsCustomHeaders;
    }

    /**
     * @return bool
     */
    public function isAllowsCookies(): bool
    {
        return $this->allowsCookies;
    }

    /**
     * @return bool
     */
    public function isAllowsPost(): bool
    {
        return $this->allowsPost;
    }

    /**
     * @return bool
     */
    public function isAllowsHttps(): bool
    {
        return $this->allowsHttps;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return float
     */
    public function getConnectTime(): float
    {
        return $this->connectTime;
    }

    /**
     * @return float
     */
    public function getDownloadSpeed(): float
    {
        return $this->downloadSpeed;
    }

    /**
     * @return float
     */
    public function getSecondsToFirstByte(): float
    {
        return $this->secondsToFirstByte;
    }

    /**
     * @return float
     */
    public function getUptime(): float
    {
        return $this->uptime;
    }
}
