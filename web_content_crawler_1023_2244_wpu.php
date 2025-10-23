<?php
// 代码生成时间: 2025-10-23 22:44:07
use Phalcon\Http\Client;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as LoggerFile;
use Phalcon\Di\FactoryDefault;

class WebContentCrawler
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->httpClient = new Client();
        $this->logger = new LoggerFile('crawler.log');
    }

    /**
     * Fetches content from a given URL
     *
     * @param string $url
     * @return mixed
     */
    public function fetchContent(string $url)
    {
        try {
            $response = $this->httpClient->get($url);
            if ($response->getStatusCode() === 200) {
                return $response->getBody();
            } else {
                $this->logger->error("Failed to retrieve content from {$url}, Status Code: " . $response->getStatusCode());
                return false;
            }
        } catch (Exception $e) {
            $this->logger->error("Error fetching content from {$url}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Sets the User-Agent header for HTTP requests
     *
     * @param string $userAgent
     * @return void
     */
    public function setUserAgent(string $userAgent): void
    {
        $this->httpClient->setUserAgent($userAgent);
    }
}

// Example usage
$crawler = new WebContentCrawler();
$crawler->setUserAgent('Mozilla/5.0 (compatible; MyBot/1.0; +http://www.mybot.com/bot.html)');
$content = $crawler->fetchContent('https://www.example.com');

if ($content !== false) {
    echo "Fetched content: " . $content;
} else {
    echo "Failed to fetch content.";
}
