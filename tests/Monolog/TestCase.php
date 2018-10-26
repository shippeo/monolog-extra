<?php

declare(strict_types=1);

namespace Shippeo\Monolog;

use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function getRecord($level = Logger::WARNING, $message = 'test', $context = []): array
    {
        return [
            'message' => $message,
            'context' => $context,
            'level' => $level,
            'level_name' => Logger::getLevelName($level),
            'channel' => 'test',
            'datetime' => \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true))),
            'extra' => [],
        ];
    }

    protected function getMultipleRecords(): array
    {
        return [
            $this->getRecord(Logger::DEBUG, 'debug message 1'),
            $this->getRecord(Logger::DEBUG, 'debug message 2'),
            $this->getRecord(Logger::INFO, 'information'),
            $this->getRecord(Logger::WARNING, 'warning'),
            $this->getRecord(Logger::ERROR, 'error'),
        ];
    }

    protected function getIdentityFormatter(): FormatterInterface
    {
        $formatter = $this->getMock(FormatterInterface::class);
        $formatter->expects($this->any())
            ->method('format')
            ->will(
                $this->returnCallback(
                    function ($record) {
                        return $record['message'];
                    }
                )
            )
        ;

        return $formatter;
    }
}
