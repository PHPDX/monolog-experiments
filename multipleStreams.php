<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;

require 'vendor/autoload.php';

// Wrapping in a function to exhibit the IntrospectionProcessor
function traceMe()
{
    // So basic
    $stdoutHandler = new StreamHandler('php://stdout');
    $errorFileHandler = new StreamHandler(__DIR__ . '/multiple.streams.log', Logger::WARNING);

    $logger = new Logger('phpdx-experiments-multiple.streams');
    $logger->pushHandler($stdoutHandler);
    $logger->pushHandler($errorFileHandler);
    $logger->pushProcessor(new IntrospectionProcessor());

    $logger->debug('look context data', ['foo' => 'bar']);
    $logger->info('you will see this is stdout, but not the file');
    $logger->warning('warning goes to stdout and the file');
    $logger->error('error is handled by both handlers as well', ['serious' => 'error']);
}

traceMe();
