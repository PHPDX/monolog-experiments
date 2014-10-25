<?php

namespace PhPdx\Monolog\Formatter;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;

/**
 * Formats incoming records into log lines augmented with a gitter emoji code.
 *
 * @author Will Vaughn <willieviseoae@gmail.com>
 */
class GitterFormatter extends LineFormatter
{
    /**
     * Formats a log record.
     *
     * @param  array $record A record to format
     * @return string The formatted record
     */
    public function format(array $record)
    {
        $emoji = $this->getLevelEmoji($record['level']);
        $output = parent::format($record);

        return $emoji . $output;
    }

    /**
     * Returns mapping of logger level to an associated emoji code.
     *
     * @return array
     */
    protected function getLevelEmojiMapping()
    {
        return [
            Logger::DEBUG => ':pencil2:',
            Logger::INFO => ':information_source:',
            Logger::NOTICE => ':white_check_mark:',
            Logger::WARNING => ':warning:',
            Logger::ERROR => ':interrobang:',
            Logger::CRITICAL => ':fire:',
            Logger::ALERT => ':loudspeaker:',
            Logger::EMERGENCY => ':boom:'
        ];
    }

    /**
     * Retrieves a Gitter Emoji code for the given log level.
     *
     * @param $level
     * @return string
     * @see http://www.emoji-cheat-sheet.com/
     */
    protected function getLevelEmoji($level)
    {
        $emojiConfig = $this->getLevelEmojiMapping();
        return $emojiConfig[$level];
    }
}
