# demafelix/laravel-updater

A simple endpoint and middleware combo package for receiving Git push events.

> Note that there are better ways to deploy, especially in production, using CI/CD. This is a stopgap solution for quick/minor projects. Use with caution.

**Throw me some sats**: [bc1quhgxucxrsz6k50yhylv4zgs6vkxe5gplmnwu06](bitcoin:bc1quhgxucxrsz6k50yhylv4zgs6vkxe5gplmnwu06)

# Requirements

* PHP 7.2 and above
* `exec()` and `shell_exec()` enabled
    * Be careful of the custom commands you declare.
    * Additionally, it is **recommended** that your web server user is unprivileged.
* Laravel 7.x and above (composer constraint: `~7`)

# Installation

Install the package on your package root:

```bash
composer require demafelix/laravel-updater
```

Then publish the configuration file:

```bash
php artisan vendor:publish --tag=config
```

Additionally, you may specify a Slack webhook URL by adding the following option in your `.env` file:

```
SLACK_HOOK_URL=<Your Webhook URL Here>
```

# Customizing Actions

By default, all actions run in your project root (a `cd` command to your `base_path()` is always prefixed to a command). You can add a command to the `commands` array in the configuration file.

By default, these are the available commands:

```php
<?php

return [
    'commands' => [
            'git-pull' => '/usr/bin/git pull',
            'migrate' => '/usr/bin/php artisan migrate',
            'seed' => '/usr/bin/php artisan seed',
            'composer-install' => '/usr/local/bin/composer install',
            'composer-dump' => '/usr/local/bin/composer dump-autoload -o',
            'npm-install' => '/usr/bin/npm install',
            'npm-compile' => '/usr/bin/npm run production'
        ],
]
```

To run these commands, simply point your Webhook URL to the `route` value in your configuration. You may view the other options in the published configuration file.

Commands must be sent as a comma-separated list, like so:

```
POST http://your-url.com/updater?commands=git-pull,migrate,seed
```

The commands will be executed in order according to the position it's declared in.

You can set the secret tokens in the configuration file as well, all requests go through the `laravel-updater` middleware, which is automatically registered by the package's service provider.

**Keep your secret tokens a secret.** They're called *secret* tokens for a reason.

# License

This library is licensed under the MIT Open Source License.
