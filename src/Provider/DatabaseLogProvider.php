<?php 

namespace Dante\LogCleaner\Provider;
use Dante\LogCleaner\Interface\LogProviderInterface;
use \Dante\LogCleaner\Exception\NotImplementedException;

class DatabaseLogProvider implements LogProviderInterface
{
	/* Compute amount of logs older than $olderThan
	*
	* @param \DateTime $olderThan
	* @return int 
	*/
	public function count (\DateTime $olderThan): int
	{
		throw new NotImplementedException('Database provider is not implemented.');
	}

	/* Remove logs older than $olderThan
	*
	* @param \DateTime $olderThan
	* @return int 
	*/
	public function remove (\DateTime $olderThan): int
	{
		throw new NotImplementedException('Database provider is not implemented.');
	}
}