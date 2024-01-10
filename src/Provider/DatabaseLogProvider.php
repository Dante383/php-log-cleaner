<?php 

namespace Dante\LogCleaner\Provider;
use Dante\LogCleaner\Interface\LogProviderInterface;
use \Dante\LogCleaner\Exception\NotImplementedException;

class DatabaseLogProvider implements LogProviderInterface
{
	public function count (\DateTime $olderThan): int
	{
		throw new NotImplementedException('Database provider is not implemented.');
	}

	public function remove (\DateTime $olderThan): int
	{
		throw new NotImplementedException('Database provider is not implemented.');
	}
}