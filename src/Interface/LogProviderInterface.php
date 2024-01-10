<?php 

namespace Dante\LogCleaner\Interface;

interface LogProviderInterface 
{
	/* Compute amount of logs older than $olderThan
	*
	* @param \DateTime $olderThan
	* @return int 
	*/
	public function count (\DateTime $olderThan): int;
	
	/* Remove logs older than $olderThan
	*
	* @param \DateTime $olderThan
	* @return int 
	*/
	public function remove (\DateTime $olderThan): int;
}