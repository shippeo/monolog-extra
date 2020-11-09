<?php

declare(strict_types=1);

namespace Shippeo\Monolog\Formatter;

use Gelf\Message;

final class GelfMessageFormatter extends \Monolog\Formatter\GelfMessageFormatter
{
    /** @var string  */
    private $graylogToken;

    public function __construct(
        string $token,
        ?string $systemName = null,
        ?string $extraPrefix = null,
        string $contextPrefix = 'ctxt_'
    ) {
        parent::__construct($systemName, $extraPrefix, $contextPrefix);

        $this->graylogToken = $token;
    }

    /**
     * {@inheritdoc}
     *
     * @param array<mixed> $record
     */
    public function format(array $record): Message
    {
        $record['extra']['X-OVH-TOKEN'] = $this->graylogToken;

        $this->setDatetime($record);
        $this->setController($record);

        return parent::format($record);
    }

    /**
     * Set correctly datetime.
     *
     * @param array<mixed> $record
     */
    private function setDatetime(array &$record): void
    {
        $datetime = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        if (\array_key_exists('datetime', $record) && $record['datetime'] instanceof \DateTime) {
            $datetime = $record['datetime']->setTimezone(new \DateTimeZone('UTC'));
        }

        $record['datetime'] = $datetime;
    }

    /**
     * Set correctly controller.
     *
     * @param array<mixed> $record
     */
    private function setController(array &$record): void
    {
        if (\array_key_exists('context', $record) && \array_key_exists('controller', $record['context'])) {
            $record['context']['controller'] = $this->removeFqcnPrefix($record['context']['controller']);
        }
    }

    /**
     * Cannot be replaced by using ClassName() as it can contain informations after controller FQCN.
     */
    private function removeFqcnPrefix(string $controller): string
    {
        $controller = explode('\\', $controller);

        return array_pop($controller);
    }
}
