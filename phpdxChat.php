<?php

use Monolog\Handler\BufferHandler;
use Monolog\Logger;
use Nack\FileParser\FileParser;
use Nack\Monolog\Handler\GitterImHandler;

require 'vendor/autoload.php';

$fileParser = new FileParser();
$config = $fileParser->json(__DIR__ . '/config/config.json');

$gitterHandler = new GitterImHandler($config['gitterToken'], $config['gitterRoomId']);
$bufferHandler = new BufferHandler($gitterHandler);

$logger = new Logger("phpdx-experiments-phpdx.chat");
$logger->pushHandler($bufferHandler);

$logger->debug('test.debug ignored.');
$logger->critical('test.critical in gitter.im', ['context' => 'here']);
$logger->notice('test.notice');
$logger->emergency('test.emergency in gitter.im');
$logger->error('test.error');
