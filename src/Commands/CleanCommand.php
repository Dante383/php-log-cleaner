<?php 

namespace Dante\LogCleaner\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
	name: 'clean',
	description: 'Clean logs older than given date.'
)]
class CleanCommand extends Command 
{
	/**
	 * Command handler
	 * 
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int 0 in case of success, status code otherwise
	 */
	protected function execute (InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);

		$io->success('beep');

		return 0;
	}
}