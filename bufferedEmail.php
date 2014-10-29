<?php

use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\NativeMailerHandler;
use Monolog\Logger;

require 'vendor/autoload.php';

$to = "willieviseoae@gmail.com";
$subject = "Buffered Email Test";
$from = "monolog.scratch@example.com";

$bufferSize = 25;
$bubble = true;
$stopBuffering = false;
$activationLevel = Logger::CRITICAL;
$mailHandler = new NativeMailerHandler($to, $subject, $from, Logger::NOTICE);
$fingersCrossed = new FingersCrossedHandler($mailHandler, $activationLevel, $bufferSize, $bubble, $stopBuffering);

$logger = new Logger("will-experiments-buffered.email");
$logger->pushHandler($fingersCrossed);

$logger->debug('test.debug will not be in emails or buffers');

for ($i = 0; $i < ($bufferSize - 1); $i++) {
    $logger->notice('test.notice');
}

$logger->critical('test.critical');

for ($i = 0; $i < 5; $i++) {
    $logger->warning('test.warning');
}

$logger->info('test.info will not be in emails or buffers');

$logger->emergency('test.emergency');

// Wont see these next two, they're put in buffer, but no CRITICAL+ log triggers them to be sent.
$logger->notice('test.notice');
$logger->error('test.notice');

// =========================== EMAIL #1 ==========================================
// 1 CRITICAL + 24 NOTICE in a single email.
// ===============================================================================

// =========================== EMAIL #2 ==========================================
// 1 EMERGENCY + 5 WARNING + 1 CRITICAL + 17 NOTICE in an email
// ===============================================================================


// 1 DEBUG, 1 INFO, 1 NOTICE, 1 ERROR not logged.
