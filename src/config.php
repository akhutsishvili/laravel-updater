<?php

return [
    /**
     * Commands to run
     */
    'commands' => [
        'git-pull' => '/usr/bin/git pull',
        'migrate' => '/usr/bin/php artisan migrate',
        'seed' => '/usr/bin/php artisan seed',
        'composer-install' => '/usr/local/bin/composer install',
        'composer-dump' => '/usr/local/bin/composer dump-autoload -o',
        'npm-install' => '/usr/bin/npm install',
        'npm-compile' => '/usr/bin/npm run production'
    ],

    /**
     * Notifications
     */
    'slack_url' => env('SLACK_HOOK_URL', ''),

    /**
     * The route to use
     */
    'route' => '/updater',

    /**
     * Show git info route (GET on /updater)
     */
    'show_info' => true,

    /**
     * Token to watch for the updater key
     */
    'header_name' => 'X-Gitlab-Token',

    /**
     * The updater key
     */
    'updater_key' => env('UPDATER_KEY', '')
];