<?php

use Monolog\Handler\BufferHandler;
use Monolog\Logger;
use Nack\FileParser\FileParser;
use Nack\Monolog\Handler\GitterImHandler;

require 'vendor/autoload.php';

$fileParser = new FileParser();
$config = $fileParser->json(__DIR__ . '/config/config.json');

$gitterHandler = new GitterImHandler($config['gitterToken'], $config['gitterRoomId'], Logger::DEBUG);
$bufferHandler = new BufferHandler($gitterHandler);

$logger = new Logger("will-experiments-phpdx.chat");
$logger->pushHandler($bufferHandler);

$logger->debug('A gitter.im debug monolog', ['ctx' => 'minutia']);
$logger->info('A gitter.im info monolog', ['ctx' => 'interesting']);
$logger->notice('A gitter.im notice monolog', ['ctx' => 'significant']);
$logger->warning('A gitter.im warning monolog', ['ctx' => 'disruptive']);
$logger->error('A gitter.im error monolog', ['ctx' => 'error']);
$logger->critical('A gitter.im critical monolog', ['ctx' => 'investigate']);
$logger->alert('A gitter.im alert monolog', ['ctx' => 'take action']);
$logger->emergency('A gitter.im emergency monolog', ['ctx' => 'boom!']);
