# LimeSurvey-Adapter

LimeSurvey-Adapter is a PHP class for interacting with LimeSurvey.

## Current Features
* Get basic and detailed list of surveys
* Check if a survey has been completed based on some condition

## Installing

```php
require 'vendor/autoload.php';
require 'path/to/LimeSurveyAdapter.php';
```

## Using

### Creating LimeSurveyAdapter

```php
$lsa = new LimeSurveyAdapter([
    'database_type' => 'mysql',
    'database_name' => 'limesurvey',
    'server' => '127.0.0.1',
    'username' => 'admin',
    'password' => 'passwd'
], 'lime_');
```

### Getting List of Surveys

```php
print_r($lsa->getSurveyList());
```

Returns an array of surveys:

```
Array
(
    [0] => Array
        (
            [sid] => 156797
            [surveyls_title] => Test
        )
)
```

### Checking Survey Completion

```php
var_dump($lsa->isCompleted('547917', ['547917X12X378' => 'asdf']));
```

Returns if survey has been completed based upon some condition.

```
bool(true)
```
