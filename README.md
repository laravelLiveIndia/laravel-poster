# poster

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/laravellive/poster.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/laravellive/poster.svg?style=flat-square)](https://packagist.org/packages/laravellive/poster)

## Intro

This package is used to publish post or status to multiple platforms at once.
Best part is that you can also send image along with text.
Please contribute to this package to make it more better

## Install

`composer require laravellive/poster`

## Usage

After installing it, you need to configure each social platform keys and token to your `.env` file.
Each plaform have its different settings so you need to read carefully the documentations of each one.

This package uses Laravel Notification to send every post. So read every package documentation for more information
For Twitter : `https://github.com/laravel-notification-channels/twitter`
For Facebook : `https://github.com/laravel-notification-channels/facebook-poster`

## Sending Post

You just need to visit `/poster` url from your app, you will get an interface to write your content.

## Testing

Run the tests with:

```bash
vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email sarthak@bitfumes.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
