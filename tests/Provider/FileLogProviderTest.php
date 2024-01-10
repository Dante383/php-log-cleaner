<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Dante\LogCleaner\Provider\FileLogProvider;
use Dante\LogCleaner\Interface\LogProviderInterface;
use Dante\LogCleaner\Exception\NotImplementedException;
use org\bovigo\vfs\vfsStream;

final class FileLogProviderTest extends TestCase
{
    public function testParsesDate(): void
    {
        $provider = new FileLogProvider();

        $date = \DateTime::createFromFormat('Y-m-d', '2020-02-02');

        $this->assertEquals($date, $provider->getLogDate('2020-02-02: dsr'));
    }

    public function testMarksLineForRemoval(): void
    {
        $resource = fopen('php://temp', 'r+'); // quickier than mocking the filesystem 
        $line1 = '2020-01-01: foo1' . PHP_EOL;
        $line2 = '2020-02-02: foo2' . PHP_EOL;
        fwrite($resource, $line1);
        fwrite($resource, $line2);
        fseek($resource, strlen($line1));

        $provider = new FileLogProvider();
        $provider->markLineForRemoval($resource, $line1);
        rewind($resource);
        $this->assertEquals(substr_replace($line1, $provider->marker, 0, strlen($provider->marker)), fgets($resource));
        $this->assertEquals($line2, fgets($resource));
    }

    public function testRemovesMarkedLines(): void
    {
        $provider = new FileLogProvider();
        $resource = fopen('php://temp', 'r+');
        fwrite($resource, $provider->marker . 'foo' . PHP_EOL);
        fwrite($resource, $provider->marker . 'foo1' . PHP_EOL);
        fwrite($resource, 'bar' . PHP_EOL);

        $provider->removeMarkedLines($resource);
        rewind($resource);
        $this->assertEquals('bar' . PHP_EOL, fgets($resource));
    }

    public function testCountsLogs(): void
    {
        $provider = new FileLogProvider();

        $root = vfsStream::setup('root');
        $resource = vfsStream::newFile('foolog.log');
        $root->addChild($resource);
        $resource->write('2020-01-01: foo' . PHP_EOL);
        $resource->write('2020-04-04: bar' . PHP_EOL);
        $resource->write('2024-04-04: bar' . PHP_EOL);
        
        $count = $provider->handleLogs(
            vfsStream::url('root/foolog.log'), 
            $olderThan=\DateTime::createFromFormat('Y-m-d', '2022-01-01'),
            $delete=False
        );

        $this->assertEquals(2, $count);
    }

    public function testDeletesLogs(): void
    {
        $provider = new FileLogProvider();

        $root = vfsStream::setup('root');
        $resource = vfsStream::newFile('foolog.log');
        $root->addChild($resource);
        $resource->write('2020-01-01: foo' . PHP_EOL);
        $resource->write('2020-04-04: bar' . PHP_EOL);
        $resource->write('2024-04-04: bar' . PHP_EOL);
        
        $count = $provider->handleLogs(
            vfsStream::url('root/foolog.log'), 
            $olderThan=\DateTime::createFromFormat('Y-m-d', '2022-01-01'),
            $delete=True
        );

        $resource->seek(0, SEEK_SET);
        $this->assertEquals('2024-04-04: bar' . PHP_EOL, $resource->readUntilEnd());
    }
}