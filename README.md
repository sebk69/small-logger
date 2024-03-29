# small-logger

Small logger is a simple php logger you can easily extends for your own need.

Basically, it implements possibility to log to :
Standard output
File (With log rotates)
Http service such as logstash

It it easy to implement your own Formatter or Output writer.

SwitchLogicInterface allow you to implements your own logic to manage multiple log streams.

It also possible to add shortcut to logger for easier use by final developer.

# Migrated

This lib has been migrated to [framagit](https://framagit.org/small) project.

A new composer package is available at https://packagist.org/packages/small/small-logger

Future commits will be done on framagit.

## Install

```bash
composer require sebk/small-logger
```

## Log to standard output

First define the switch loggic :
```php
\Sebk\SmallLogger\Logger::setSwitchLogic(new \Sebk\SmallLogger\SwitchLogic\DefaultSwitchLogic());
```

Then, you are abble to log :
```php
\Sebk\SmallLogger\Logger::log(new \Sebk\SmallLogger\Log\BasicLog(
    new \DateTime(),
    \Sebk\SmallLogger\Contracts\LogInterface::ERR_LEVEL_INFO,
    'This is an info log'
));
```

## Log to file

You can log to a single file :
```php
\Sebk\SmallLogger\Logger::setSwitchLogic(new \Sebk\SmallLogger\SwitchLogic\DefaultFileSwitchLogic('/var/log/my-log.log'));
```

Or redirect errors to another file :
```php
\Sebk\SmallLogger\Logger::setSwitchLogic(new \Sebk\SmallLogger\SwitchLogic\DefaultFileSwitchLogic('/var/log/my-log.log', '/var/log/my-error-log.log'));
```

In the second case, errors are redirected to the second file.

Then this call will write in '/var/log/my-log.log' :
```php
\Sebk\SmallLogger\Logger::log(new \Sebk\SmallLogger\Log\BasicLog(
    new \DateTime(),
    \Sebk\SmallLogger\Contracts\LogInterface::ERR_LEVEL_INFO,
    'This is an info log'
));
```

And this call will write in '/var/log/my-error-log.log' :
```php
\Sebk\SmallLogger\Logger::log(new \Sebk\SmallLogger\Log\BasicLog(
    new \DateTime(),
    \Sebk\SmallLogger\Contracts\LogInterface::ERR_LEVEL_ERROR,
    'This is an info log'
));
```

## Customizing logs

You can easy customize the behaviour of logs by writing your own classes implementing interfaces :
- switch : the switch logic
- formatter : log class diggest to log format
- output : the output writer

For example, we want to write to logstash. We will use the http type with the output factory. To get the best appropriate output for your project, use the output factory :

```php
$output = (new \Sebk\SmallLogger\Output\OutputFactory())->get('http', new \Sebk\SmallLogger\Output\Config\HttpConfig('localhost', 8080, false));
```

New we have the output, we can create our switcher :

```php

namespace App\Logs;

class HttpSwitcherLogic implements \Sebk\SmallLogger\Contracts\SwitchLogicInterface
{

    protected \Sebk\SmallLogger\Contracts\StreamInterface $stream;
    
    public function __construct(\Sebk\SmallLogger\Output\Config\HttpConfig $config)
    {
        $this->stream = new \Sebk\SmallLogger\Stream\Stream(
            new \Sebk\SmallLogger\Formatter\JsonFormatter(), 
            (new \Sebk\SmallLogger\Output\OutputFactory())->get('http', $config)
        );
    }
    
    public function getStream(\Sebk\SmallLogger\Contracts\LogInterface $log, array $data = []) : \Sebk\SmallLogger\Contracts\StreamInterface
    {
        $this->stream;
    }
    
}
```

In the getStream method, you can put your logic to manage more than one stream depends on $log itself or additional $data.

For example, you can set up a stream for error level and a stream for critical level.

If you want, the $data array may inject information to switch in complex architectures.

Now define your switch in logger and log :

```php
\Sebk\SmallLogger\Logger::setSwitchLogic(new HttpSwitcher(
    new \Sebk\SmallLogger\Output\Config\HttpConfig(
        'logstash.my-domain.com',
        8080,
        true
    )
));
\Sebk\SmallLogger\Logger::log(new \Sebk\SmallLogger\Log\BasicLog(
    new \DateTime(),
    \Sebk\SmallLogger\Contracts\LogInterface::ERR_LEVEL_ERROR,
    'This an error'
));
```

## Unit tests

To run unit tests, you are require to build unit-test container :
```php
$ sudo apt-get update && apt-get install docker docker-compose
$ docker-compose up -d --build
```

Then the container will build environement for testing and launch tests.

If you want to develop and add unit tests, turn off the **BUILD** environement var in docker-compose.yml by setting it to **0** :
```
...
    environment:
      - BUILD=1 # If set to 0, the unit test are not launched and container will sleep to let you run all tests commands you want when you develop tests
...
```
