<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Dante\LogCleaner\LogProviderFactory;
use Dante\LogCleaner\Interface\LogProviderInterface;
use Dante\LogCleaner\Exception\NotImplementedException;

final class LogProviderFactoryTest extends TestCase
{
    public function testReturnsInstanceOfLogInterface(): void
    {
        $interface = LogProviderFactory::createLogProvider('file');

        $this->assertInstanceOf(LogProviderInterface::class, $interface);
    }

    public function testThrowsNotImplementedException(): void
    {
        $this->expectException(NotImplementedException::class);

        LogProviderFactory::createLogProvider('lorem ipsum dor');
    }
}