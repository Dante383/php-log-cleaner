<?php 

namespace Dante\LogCleaner\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Completion\CompletionInput;
use Dante\LogCleaner\LogProviderFactory;

#[AsCommand(
	name: 'clean',
	description: 'Clean logs older than given date.'
)]
class CleanCommand extends Command 
{
	private array $logSources = ['database', 'file'];

	public function __construct ()
	{
		$this->logProviderFactory = new LogProviderFactory();
		parent::__construct();
	}

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

		$source = $input->getOption('source');

		if (!in_array($source, $this->logSources))
		{
			$io->error(sprintf('Invalid log source! Available sources: %s', implode('|', $this->logSources)));
		}

		$olderThan = \DateTime::createFromFormat('Y-m-d', $input->getArgument('older-than'));
		if (!$olderThan)
		{
			$io->error('Invalid date! Use YYYY-MM-DD format.');
		}

		$logProvider = $this->logProviderFactory->createLogProvider($source);

		$io->writeln(sprintf('Fetching logs older than %s from %s..', $olderThan->format('Y-m-d'), $source));

		$logCount = $logProvider->count($olderThan);

		if ($io->confirm(sprintf('Fetched %s logs. Do you wish to remove them?', $logCount)))
		{
			
		}
	
		return 0;
	}

	/**
	 * Configure arguments and parameters
	 * 
	 * @return void
	 */
	protected function configure(): void
	{
		$this
			->addArgument(
				$name = 'older-than',
				$mode = InputArgument::REQUIRED,
				$description = 'Remove logs older than. YYYY-MM-DD'
			);

		$this
			->addOption(
				$name = 'source',
				$shortcut = 's',
				$mode = InputArgument::OPTIONAL, 
				$description = implode('|', $this->logSources), 
				$default = 'file', 
				$suggestedValues = $this->logSources
			);
	}
}