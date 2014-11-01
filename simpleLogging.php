<?php

use Monolog\Logger;

require 'vendor/autoload.php';

// Defaults to using the StreamHandler to php://stderr and a LineFormatter.
$logger = new Monolog\Logger('channel');

$logger->debug('debug test');
$logger->addDebug('addDebug test');
$logger->log(100, 'log 100 debug test');

$logger->info('info test');
$logger->addInfo('addInfo test');
$logger->log(Logger::INFO, 'log with info constant');

$logger->warning('warning test');
$logger->warn('warn test');
$logger->addWarning('addWarning test');
$logger->log('warning', 'log with "warning" as string');
