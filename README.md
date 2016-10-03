# SMS notification channel for Laravel 5.3

This package makes it easy to send notifications using [sms.ru](https://sms.ru/) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the configuration](#setting-up-the-configuration)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:

``` bash
composer require enniel/laravel-smsru-notification-channel
```

Next add the service provider to your `config/app.php`:

```php
...
'providers' => [
    ...
     NotificationChannels\SmsRu\SmsRuServiceProvider::class,
],
...
```



### Setting up the configuration

Add your API ID (secret key) and default sender name to your `config/services.php`:

```php
// config/services.php
...
'smsru' => [
    'api_id' => env('SMSRU_API_ID'),
    'sender' => 'John_Doe'
],
...
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\SmsRu\SmsRuChannel;
use NotificationChannels\SmsRu\SmsRuMessage;
use Illuminate\Notifications\Notification;

class ExampleNotification extends Notification
{
    public function via($notifiable)
    {
        return [SmsRuChannel::class];
    }

    public function toSmsRu($notifiable)
    {
        return SmsRuMessage::create('message text');
    }
}
```


In order to let your Notification know which phone number you are targeting, add the `routeNotificationForSmsRu` method to your Notifiable model.

### Available message methods

- `from()`: Sets the sender's name.
- `text()`: Sets a text of the notification message.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Evgeni Razumov](https://github.com/enniel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
