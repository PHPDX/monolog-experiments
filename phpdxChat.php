<?php

use Monolog\Handler\BufferHandler;
use Monolog\Logger;
use Nack\FileParser\FileParser;
use Nack\Monolog\Handler\GitterImHandler;

require 'vendor/autoload.php';

$fileParser = new FileParser();
$config = $fileParser->json(__DIR__ . '/config/config.json');

$gitterHandler = new GitterImHandler($config['gitterToken'], $config['gitterRoomId']);
$tailBufferHandler = new BufferHandler($gitterHandler);

$logger = new Logger("will-experiments-phpdx.chat");
$logger->pushHandler($tailBufferHandler);

$logger->debug('test.debug ignored.');
$logger->critical('test.critical in gitter.im', ['context' => 'here']);
$logger->notice('test.notice');
$logger->emergency('test.emergency');
$logger->error('test.error');
