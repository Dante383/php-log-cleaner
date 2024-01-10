# Log Cleaner 

![assets/log_cleaner.png](assets/log_cleaner.png)

## Installation 

`composer require dante/log-cleaner`

## Usage 

`./vendor/bin/log-cleaner --source {source} {older-than}`

* {source} - "database" or "file"

* {older-than} - date in YYYY-MM-DD format

## Testing 

`./vendor/bin/phpunit tests`