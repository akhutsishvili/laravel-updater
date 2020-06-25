<?php

namespace Demafelix\LaravelUpdater\Helpers;

use Illuminate\Support\Facades\Http;

class LaravelUpdaterHelper
{
    public static function sendResponse($status = 200, $message = null, $data = [])
    {
        return response()->json(
            [
                'message' => $message,
                'data' => $data
            ],
            $status
        );
    }

    public static function getGitInfo()
    {
        // Prepare the data
        $data = [];

        // Get current branch
        $data['branch'] = trim(ltrim(exec('git branch | grep \* '), '* '));

        // Get current commit
        $commit = explode("\n", shell_exec('git log -n 1'));
        $data['current'] = [
            'hash' => trim(str_replace("commit ", "", $commit[0])),
            'date' => trim(str_replace("Date:", "", $commit[2])),
            'author' => trim(str_replace("Author:", "", $commit[1])),
            'message' => trim($commit[4])
        ];

        // Return
        return $data;
    }

    public static function sendToSlack($message)
    {
        $name = config('app.name');
        return Http::post(config('laravel-updater.slack_url'), [
            'text' => "[{$name}] {$message}"
        ]);
    }
}