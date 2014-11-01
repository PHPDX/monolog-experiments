<?php

use Monolog\Formatter\HtmlFormatter;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\NativeMailerHandler;
use Monolog\Logger;

require 'vendor/autoload.php';

$to = "user@example.com";
$subject = "Buffered Email Test";
$from = "monolog.scratch@example.com";

$mailHandler = new NativeMailerHandler($to, $subject, $from, Logger::NOTICE);
$mailHandler->setContentType('text/html');
$mailHandler->setFormatter(new HtmlFormatter());

$bufferSize = 3;
$fingersCrossed = new FingersCrossedHandler($mailHandler, Logger::CRITICAL, $bufferSize, true, false);

$logger = new Logger("phpdx-experiments-buffered.email");
$logger->pushHandler($fingersCrossed);

////////////////// EMAIL 1 ////////////////////////////////////
$logger->debug('test.debug will not be in emails or buffers');
for ($i = 0; $i < ($bufferSize - 1); $i++) {
    $logger->notice('test.notice');
}
// This critical log activates a handling of the FingersCrossed buffer.
$logger->critical('test.critical');

////////////////// EMAIL 2 ////////////////////////////////////
$logger->warning('test.warning');
$logger->info('test.info will not be in emails or buffers');
// This emergency log activates a second handling of the FingersCrossed buff
$logger->emergency('test.emergency');

// Wont see these next two, they're put in buffer, but no CRITICAL+ log triggers them to be sent.
$logger->notice('test.notice will not be in email');
$logger->error('test.notice will not be in email');
