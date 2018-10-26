<?php

declare(strict_types=1);

namespace Shippeo\Monolog\Processor;

use Shippeo\Monolog\TestCase;

final class ApplicationNameProcessorTest extends TestCase
{
    public function testProcessor(): void
    {
        $processor = new ApplicationNameProcessor('Foo');
        $record = $processor($this->getRecord());

        $this->assertEquals('foo.test', $record['channel']);
    }
}
