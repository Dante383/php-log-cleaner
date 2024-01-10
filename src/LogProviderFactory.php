<?php 

namespace Dante\LogCleaner; 
use Dante\LogCleaner\Exception\NotImplementedException;
use Dante\LogCleaner\Provider\FileLogProvider;
use Dante\LogCleaner\Provider\DatabaseLogProvider;
use Dante\LogCleaner\Interface\LogProviderInterface;

class LogProviderFactory
{
	/* Create log provider based on selected source
	*
	* @param string $source 
	* @return LogProviderInterface
	*/
	public static function createLogProvider(string $source): LogProviderInterface
	{
		if ($source === 'file')
		{
			return new FileLogProvider();
		} elseif ($source === 'database')
		{
			return new DatabaseLogProvider();
		} 

		throw new NotImplementedException(sprintf('Source %s is not implemented.', $source));
	}
}