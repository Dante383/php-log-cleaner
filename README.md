# Log Cleaner 

![assets/log_cleaner.png](assets/log_cleaner.png)

Disclaimer: The ideal implementation would be to move date-checking logic outside of the File/Database providers and only fetch/remove inside of the providers.
However, this would severly hurt performance, introducing many unnecesary I/O operations in case of the File provider. Ideally, we would create a Log entity 
populated from providers via DTOs, then select logs for removal above the provider level. I say "ideally" in context of clean code standards - I believe current approach 
is the ideal one in performance context.

## Installation 

`composer require dante/log-cleaner`

## Usage 

`./vendor/dante/log-cleaner --source {source} {older-than}`

* {source} - "database" or "file"

* {older-than} - date in YYYY-MM-DD format

## Testing 

`./vendor/bin/phpunit tests`