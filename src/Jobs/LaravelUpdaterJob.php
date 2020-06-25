<?php

namespace Demafelix\LaravelUpdater\Jobs;

use Demafelix\LaravelUpdater\Helpers\LaravelUpdaterHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LaravelUpdaterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $command;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        exec($this->command, $output, $exitCode);
        if ($exitCode === 0) {
            LaravelUpdaterHelper::sendToSlack("Command `{$this->command}` finished successfully.");
        } else {
            LaravelUpdaterHelper::sendToSlack("Command `{$this->command}` failed:");
            $failure = implode("\n", $output);
            LaravelUpdaterHelper::sendToSlack(<<<EOF
```
{$failure}
```
EOF
);
        }
    }
}
