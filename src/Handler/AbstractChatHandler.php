<?php

namespace PhPdx\Monolog\Handler;

use Monolog\Handler\AbstractProcessingHandler;

/**
 * Base class for handlers which send notifications to chat rooms.
 *
 * @author Will Vaughn <willieviseoae@gmail.com>
 */
abstract class AbstractChatHandler extends AbstractProcessingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handleBatch(array $records)
    {
        $messages = array();

        foreach ($records as $record) {
            if ($record['level'] < $this->level) {
                continue;
            }
            $messages[] = $this->processRecord($record);
        }

        if (!empty($messages)) {
            $this->send((string) $this->getFormatter()->formatBatch($messages));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->send((string) $record['formatted']);
    }

    /**
     * Send a log to chat with the given content
     *
     * @param string $content
     */
    abstract protected function send($content);
}
