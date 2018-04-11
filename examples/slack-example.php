<?php

use pmill\RabbitRabbit\Conditions\GreaterThan;
use pmill\RabbitRabbit\ConsumerManager;
use pmill\RabbitRabbit\RabbitConfig;
use pmill\RabbitRabbitSlack\SlackRule;

require __DIR__ . '/../vendor/autoload.php';

$config = new RabbitConfig([
    'baseUrl' => 'localhost:15672',
    'username' => 'guest',
    'password' => 'guest',
]);

$manager = new ConsumerManager($config);
$vhostName = '/';
$queueName = 'messages';

// To get this webhook URL
// 1. Create a slack app
// 2. Add an incoming webhook to your app
// 3. You will be given a URL for your webhook
$slackWebhookUrl = '';

$manager->addRule(
    new SlackRule(
        $vhostName,
        $queueName,
        $slackWebhookUrl,
        'There are currently :messageCount ready messages in :vhostName/:queueName'
    ),
    new GreaterThan(0)
);

$manager->run();
