<?php

/**
 *
 */
class SlackLog
{
    ////////////////
    // Log Levels //
    ////////////////
    const EMERGENCY = 'emergency';
    const ALERT     = 'alert';
    const CRITICAL  = 'critical';
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const NOTICE    = 'notice';
    const INFO      = 'info';
    const DEBUG     = 'debug';

    /**
     * Match each log level to a Slack Icon.
     * @var [type]
     */
    private $logLevelIconPrefixes = [
        self::EMERGENCY => ":radioactive_sign: *[EMERGENCY]*",
        self::ALERT => ":fire: *[ALERT]*",
        self::CRITICAL => ":ambulance: *[CRITICAL]*",
        self::ERROR => ":x: *[ERROR]*",
        self::WARNING => ":warning: *[WARNING]*",
        self::NOTICE => ":incoming_envelope: *[NOTICE]*",
        self::INFO => ":information_source: *[INFO]*",
        self::DEBUG => ":computer: *[DEBUG]*"
    ];

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

    /**
     * [__construct description]
     */
    function __construct($channel = "#general")
    {
        $this->channel = $channel;
    }

    /**
     * [post description]
     * @param  [type] $message [description]
     * @param  string $channel [description]
     * @return [type]          [description]
     */
    private function post($message, array $context = array())
    {
        $ch = curl_init($this->incomingWebhookURL);
        $data = [
            "text" => $message,
            "channel" => $this->channel,
            "username" => $this->username,
            "icon_emoji" => ":desktop_computer:"
        ];
        $payload = ["payload" => json_encode($data)];

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        return $this->log(self::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert($message, array $context = array())
    {
        return $this->log(self::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical($message, array $context = array())
    {
        return $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        return $this->log(self::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        return $this->log(self::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice($message, array $context = array())
    {
        return $this->log(self::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        return $this->log(self::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        return $this->log(self::DEBUG, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        // Prefix each message with the proper Slack icon prefix
        $message = "{$this->logLevelIconPrefixes[$level]} $message";

        return $this->post($message, $context);
    }
}
