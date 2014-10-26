<?php

use Monolog\Handler\BufferHandler;
use Monolog\Logger;
use Nack\FileParser\FileParser;
use Nack\Monolog\Handler\GitterImHandler;
use Nack\Monolog\Handler\TailBufferHandler;

require 'vendor/autoload.php';

$fileParser = new FileParser();
$config = $fileParser->json(__DIR__ . '/config/config.json');

$bufferCapacity = 25;
$gitterHandler = new GitterImHandler($config['gitterToken'], $config['gitterRoomId'], Logger::DEBUG);
$tailBufferHandler = new TailBufferHandler($gitterHandler, $bufferCapacity);

$logger = new Logger("will-experiments-phpdx.chat");
$logger->pushHandler($tailBufferHandler);

for ($i = 0; $i < ($bufferCapacity - 1); $i++) {
    $logger->debug('test.debug');
}

// This is going to make a message of the critical log +24 debugs.
$logger->critical('test.critical');

for ($i = 0; $i < 5; $i++) {
    $logger->notice('test.notice');
}

// This is going to make a message of this emergency, 5 notices, a critical, and 17 debugs.
$logger->emergency('test.emergency');

// Make sense?
