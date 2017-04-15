# slack-log

Is a simple PHP class that posts to an `incoming-webhook` URL in a Slack channel. Although it uses the [PSR-3 Logger Interface](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) as a template it is not an actual dependency for it to work.

## Slack incoming webhook configuration

Follow this extensive article to guide you through, https://www.smashingmagazine.com/2017/04/using-slack-monitor-app/.

## Setup

Just include it in your project and edit the following two variables to your desired values.

```php
/**
 * The incoming-webhook URL the Slack
 * integration configuration provides.
 * @var [type]
 */
private $incomingWebhookURL = "";

/**
 * The username that will be used when
 * posting on the channel.
 * @var string
 */
private $username = "";
```

<br/>
<br/>

My thanks to [@netgfx](https://github.com/netgfx) for the idea, and patience with all the spamming during development.
