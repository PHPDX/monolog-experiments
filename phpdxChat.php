<?php

use Monolog\Handler\BufferHandler;
use Monolog\Logger;
use Nack\FileParser\FileParser;
use Nack\Monolog\Handler\GitterImHandler;
use Nack\Monolog\Handler\TailBufferHandler;

require 'vendor/autoload.php';

$fileParser = new FileParser();
$config = $fileParser->json(__DIR__ . '/config/config.json');

$gitterHandler = new GitterImHandler($config['gitterToken'], $config['gitterRoomId'], Logger::DEBUG);
$tailBufferHandler = new TailBufferHandler($gitterHandler, 5);

$logger = new Logger("will-experiments-phpdx.chat");
$logger->pushHandler($tailBufferHandler);

// These will get left out
$logger->debug('debug outside buffer capacity');
$logger->warning('warning outside buffer capacity');
$logger->info('info outside buffer capacity');

// These will make it
$logger->debug('debug in buffer', ['ctx' => 'minutia']);
$logger->info('info in buffer', ['ctx' => 'interesting']);
$logger->notice('notice in buffer', ['ctx' => 'significant']);
$logger->error('error in buffer', ['ctx' => 'error']);

// This critical triggers the tail buffer handler to flush.
// Buffer capacity is set purposefully low at 5 to demonstrate how buffer capacity works.
$logger->critical('A gitter.im critical monolog', ['ctx' => 'investigate']);

// The buffer has been reset, here we go for some more.
$logger->warning('warning in the second batch');
$logger->info('in the second batch');
$logger->emergency('emergency triggers another flush', ['ctx' => 'boom!']);
