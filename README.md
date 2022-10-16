# small-logger

Small logger is a simple php logger you can easily extends for your own need.

Bascliy, it implements possibility to log to :
- Standard output
- File (With log rotates)
- Http service such as logstash

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
- driver : the output writer

For example, we want to write to logstash. We will use the http type with the driver factory. To get the best appropriate driver for your project, use the driver factory :

```php
$output = (new \Sebk\SmallLogger\Output\DriverFactory)->get('http');
```

New we have the driver, we can create our switcher :

```php
class httpSwitcher implements \Sebk\SmallLogger\Contracts\SwitchLogicInterface
{

    protected \Sebk\SmallLogger\Contracts\StreamInterface $stream;
    
    public function __construct(\Sebk\SmallLogger\Output\Config\HttpConfig $config)
    {
        $this->stream = new \Sebk\SmallLogger\Stream\Stream(
            new \Sebk\SmallLogger\Formatter\JsonFormatter(), 
            (new \Sebk\SmallLogger\Output\DriverFactory)->get('http')
        );
    }
    
    public function getStream(\Sebk\SmallLogger\Contracts\LogInterface $log, array $data = []) : \Sebk\SmallLogger\Contracts\StreamInterface
    {
        $this->stream->write($log);
    }
}
```

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