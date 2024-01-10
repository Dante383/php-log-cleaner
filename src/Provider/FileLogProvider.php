<?php

namespace Dante\LogCleaner\Provider;
use Dante\LogCleaner\Interface\LogProviderInterface;

ini_set("auto_detect_line_endings", true);

class FileLogProvider implements LogProviderInterface
{
	public string $filepath = 'foobar.log';
	public string $marker = 'DELETE_MARKER';

	public function count (\DateTime $olderThan): int
	{
		return $this->handleLogs($this->filepath, $olderThan, $delete=false);
	}

	public function remove (\DateTime $olderThan): int
	{
		return $this->handleLogs($this->filepath, $olderThan, $delete=true);
	}

	private function handleLogs (string $filename, \DateTime $olderThan, bool $delete=false): int
	{
		$file = fopen($filename, 'r+');
		$count = 0;

		if ($file) 
		{
			while (($line = fgets($file)) !== false)
			{
				$date = $this->getLogDate($line);
				
				if ($date < $olderThan)
				{
					$count += 1;

					if ($delete)
					{
						$this->markLineForRemoval($file, $line);
					}
				}

			}

			if ($delete) {
				$this->removeMarkedLines($file);
			}
		}
		return $count;
	}

	private function getLogDate (string $log): \DateTime
	{
		$log = str_replace("\r", '', $log); // without this, despite auto_detect_line_endings, PHP fails to read the file on Linux
		return \DateTime::createFromFormat('Y-m-d', explode(':', $log)[0]);
	}

	private function markLineForRemoval ($file, string $line): void
	{
		$originalPosition = ftell($file);
		$lineLength = strlen($line);

	    // Move the file pointer to the beginning of the line
	    fseek($file, $originalPosition - $lineLength);
	    fwrite($file, $this->marker);
	    fseek($file, $originalPosition);
	}

	private function removeMarkedLines ($file): void
	{
		rewind($file);
        $output = fopen('php://temp', 'w+');

		while (($line = fgets($file)) !== false) {
			if (str_starts_with($line, $this->marker) === false) {
		    	fwrite($output, $line);
		    }
		}
		
		ftruncate($file, 0);
		fseek($output, 0);
		fseek($file, 0);
		stream_copy_to_stream($output, $file);

		fclose($output);
		fclose($file);
	}
}