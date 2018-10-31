<?php

declare(strict_types=1);

namespace Shippeo\Monolog\Processor;

use function mb_strtolower;

final class ApplicationNameProcessor
{
    /** @var string */
    private $applicationName;

    public function __construct(string $applicationName)
    {
        $this->applicationName = $applicationName;
    }

    public function __invoke(array $record): array
    {
        $record['channel'] = sprintf('%s.%s', mb_strtolower($this->applicationName), $record['channel']);

        return $record;
    }
}
