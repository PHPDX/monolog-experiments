<?php

use Monolog\Handler\NativeMailerHandler;
use Monolog\Logger;
use Nack\Monolog\Handler\TailBufferHandler;

require 'vendor/autoload.php';

$to = "user@example.com";
$subject = "Buffered Email Test";
$from = "monolog.scratch@example.com";

$bufferCapacity = 25;
$mailHandler = new NativeMailerHandler($to, $subject, $from, Logger::NOTICE);
$tailBufferHandler = new TailBufferHandler($mailHandler, $bufferCapacity, Logger::NOTICE);

$logger = new Logger("will-experiments-buffered.email");
$logger->pushHandler($tailBufferHandler);


$logger->debug('test.debug will not be in emails or buffers');

for ($i = 0; $i < ($bufferCapacity - 1); $i++) {
    $logger->notice('test.notice');
}

$logger->critical('test.critical');

for ($i = 0; $i < 5; $i++) {
    $logger->warning('test.warning');
}

$logger->info('test.info will not be in emails or buffers');

$logger->emergency('test.emergency');

// Wont see these next two, they're put in buffer, but never flushed by a CRITICAL+
$logger->notice('test.notice');
$logger->error('test.notice');

// =========================== EMAIL #1 ==========================================
// 1 CRITICAL + 24 NOTICE in an email.
// DEBUG below the lowest buffered level, ignored.
// ===============================================================================

// =========================== EMAIL #2 ==========================================
// 1 EMERGENCY + 5 WARNING + 1 CRITICAL + 17 NOTICE in an email
// INFO below the lowest buffered level, ignored.
// ===============================================================================
