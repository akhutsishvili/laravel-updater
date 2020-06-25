<?php

namespace Demafelix\LaravelUpdater\Helpers;

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

    public static function getCurrentCommit()
    {

    }
}