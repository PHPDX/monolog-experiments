<?php
/**
 * This script is an example of using the monolog BufferHandler with the NativeMailerHandler to send one email which
 * captures all of the logs which ran during the execution of the script. Normal operation of the NativeMailerHandler
 * is to send one email per log. That could get pretty annoying. The buffer handler is set up here to wrap
 * the NativeMailerHandler, but it could be used to wrap any other HandlerInterface.
 *
 * When the php script has finished running, the buffer handler closes itself before destruction and sends
 * them as a batch to the underlying mail handler which uses the built in php mail() function to send a single email
 * of all logs above Logger::ERROR
 */

use Monolog\Handler\BufferHandler;
use Monolog\Handler\NativeMailerHandler;
use Monolog\Logger;

require 'vendor/autoload.php';

$to = "user@domain.com";
$subject = "Buffered Email Test";
$from = "monolog.scratch@example.com";

// NativeMailerHandler, set to only care about ERROR+ logs from this script.
$mailHandler = new NativeMailerHandler($to, $subject, $from, Logger::ERROR);

// BufferHandler wraps the NativeMailerHandler
// Is set up with a bufferLimit of 0, which means no limit.
// And is set up to buffer all log levels DEBUG+
$bufferHandler = new BufferHandler($mailHandler, 0, Logger::DEBUG);

// Give the buffer handler to the logger.
$logger = new Logger("will-experiments-buffered.email");
$logger->pushHandler($bufferHandler);

$logger->debug("You won't get this in the email");
$logger->info("Won't get this either");
$logger->notice("Or this, but you will get the next 3 in a single email.");
$logger->error("error, coming in a single buffered email");
$logger->critical("critical, coming in a single buffered email");
$logger->emergency("emergency, coming in a single buffered email");
