<?php 

namespace Dante\LogCleaner\Provider;
use Dante\LogCleaner\Interface\LogProviderInterface;

class DatabaseLogProvider implements LogProviderInterface
{
	public function count (\DateTime $olderThan): int
	{
		return 16;
	}
	
	public function remove (\DateTime $olderThan)
	{
		
	}
}