<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use \Dante\LogCleaner\Commands\CleanCommand;

final class CleanCommandTest extends TestCase
{
    public function testParsesDate(): void
    {
        $application = new Application();
        $application->add(new CleanCommand());
        $command = $application->find('clean');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            '--source' => 'file',
            'older-than' => '2024-01-01'
        ]);

        $commandTester->assertCommandIsSuccessful();
    }

    public function testDetectsInvalidDate(): void
    {
        $application = new Application();
        $application->add(new CleanCommand());
        $command = $application->find('clean');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            '--source' => 'file',
            'older-than' => '2024-01-'
        ]);
        
        $this->assertEquals(1, $commandTester->getStatusCode());
    }

    public function testParsesSource(): void
    {
        $application = new Application();
        $application->add(new CleanCommand());
        $command = $application->find('clean');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            '--source' => $command->logSources[1],
            'older-than' => '2024-01-01'
        ]);

        $commandTester->assertCommandIsSuccessful();
    }

    public function testDetectsInvalidSource(): void
    {
        $application = new Application();
        $application->add(new CleanCommand());
        $command = $application->find('clean');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            '--source' => 'lorem ipsum',
            'older-than' => '2024-01-01'
        ]);

        $this->assertEquals(1, $commandTester->getStatusCode());
    }
}