<?php
namespace pmill\RabbitRabbitSlack;

use GuzzleHttp\Client as HttpClient;
use pmill\RabbitRabbit\AbstractRule;

class SlackRule extends AbstractRule
{
    /**
     * @var string
     */
    protected $slackWebhookUrl;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $message;

    /**
     * SlackRule constructor.
     *
     * @param string $vHostName
     * @param string $queueName
     * @param string $slackWebhookUrl
     * @param string $message
     */
    public function __construct(string $vHostName, string $queueName, string $slackWebhookUrl, string $message)
    {
        $this->slackWebhookUrl = $slackWebhookUrl;
        $this->message = $message;
        parent::__construct($vHostName, $queueName);
    }

    /**
     * @param int $readyMessageCount
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function run(int $readyMessageCount): void
    {
        if (!$this->httpClient) {
            $this->createHttpClient();
        }

        $message = $this->message;
        $message = str_replace(':messageCount', $readyMessageCount, $message);
        $message = str_replace(':queueName', $this->queueName, $message);
        $message = str_replace(':vhostName', $this->vHostName, $message);

        $this->httpClient->request('POST', $this->slackWebhookUrl, [
            'json' => ['text' => $message],
        ]);
    }

    protected function createHttpClient(): void
    {
        $this->httpClient = new HttpClient();
    }
}
