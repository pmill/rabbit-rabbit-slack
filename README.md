# pmill/rabbit-rabbit-slack

## Introduction

This library allows you to post to Slack channels when RabbitMQ queues message counts match conditions.

## Requirements

This library package requires PHP 7.1 or later, and a slack account.

## Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest version:

```bash
composer require pmill/rabbut-rabbit
```

## Slack Setup

You will need to generate a webhook URL for the channel you want to post messages to, to do this:

1. Create a Slack app
2. Create an incoming webhook URL to the app for each channel you want to post to

# Usage

The following example will post the message count for your queue in your Slack channel when the message count is greater 
than 5000. There is a complete example in the `examples/` folder.

```php
$config = new RabbitConfig([
    'baseUrl' => 'localhost:15672',
    'username' => 'guest',
    'password' => 'guest',
]);

$manager = new ConsumerManager($config);

$vhostName = '/';
$queueName = 'messages';
$slackWebhookUrl = '';

$manager->addRule(
    new SlackRule(
        $vhostName,
        $queueName,
        $slackWebhookUrl,
        'There are currently :messageCount ready messages in :vhostName/:queueName'
    ),
    new GreaterThan(5000)
);

$manager->run();
```


# Version History

0.1.0 (12/04/2018)

*   First public release of rabbit-rabbit-slack


# Copyright

pmill/rabbit-rabbit-slack
Copyright (c) 2018 pmill (dev.pmill@gmail.com) 
All rights reserved.