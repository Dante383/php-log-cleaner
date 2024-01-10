<?php

namespace Dante\LogCleaner\Provider;
use Dante\LogCleaner\Interface\LogProviderInterface;

class FileLogProvider implements LogProviderInterface
{
	public function count (\DateTime $olderThan): int
	{
		return 14;
	}

	public function remove (\DateTime $olderThan)
	{
		
	}
}