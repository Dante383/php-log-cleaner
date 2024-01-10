<?php 

namespace Dante\LogCleaner\Interface;

interface LogProviderInterface 
{
	public function count (\DateTime $olderThan): int;
	public function remove (\DateTime $olderThan);
}