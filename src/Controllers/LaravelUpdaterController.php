<?php

namespace Demafelix\LaravelUpdater\Controllers;

use App\Http\Controllers\Controller;
use Demafelix\LaravelUpdater\Helpers\LaravelUpdaterHelper;
use Demafelix\LaravelUpdater\Jobs\LaravelUpdaterJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaravelUpdaterController extends Controller
{
    /**
     * Returns git information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (!config('laravel-updater.show_info')) {
            abort(404);
        }
        return LaravelUpdaterHelper::sendResponse(200, null, LaravelUpdaterHelper::getGitInfo());
    }

    public function update(Request $request)
    {
        // Validate commands
        $validator = Validator::make($request->all(), [
            'commands' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return LaravelUpdaterHelper::sendResponse(422, 'Please specify commands to run.');
        }

        // Get commands
        $commands = explode(',', $request->get('commands'));

        // Validate if a command string is valid
        foreach ($commands as $command) {
            if (!array_key_exists($command, config('laravel-updater.commands'))) {
                return LaravelUpdaterHelper::sendResponse(400, 'Invalid command: ' . $command);
            }
        }

        // Run commands
        // Yes, this is intentionally a separate loop.
        $root = base_path();
        $env = app()->environment();
        foreach ($commands as $command) {
            LaravelUpdaterJob::dispatch('cd ' . $root . ' && ' . config('laravel-updater.commands.' . $command));
            LaravelUpdaterHelper::sendToSlack("Command `{$command}` queued on `{$env}`.");
        }
    }
}
