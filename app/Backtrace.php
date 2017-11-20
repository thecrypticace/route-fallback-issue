<?php

namespace App;

class Backtrace
{
    public static $highlights = [
        [
            "pattern" => "*EncryptCookies*",
            "template" => "<strong class='trace-highlight' style='color: orange;'>%s</strong>",
        ],
        [
            "pattern" => "*runRoute",
            "template" => "<strong class='trace-highlight' style='color: limegreen;'>%s</strong>",
        ],
    ];

    public static function toHere()
    {
        $trace = collect(debug_backtrace());

        // Hide Backtrace::toHere() from the stacktrace
        $trace->shift();

        $lines = $trace->map(function ($frame, $index) {
            return \vsprintf("%d. %s::%s", [
                $index,
                $frame["class"] ?? "-",
                $frame["function"] ?? "-",
            ]);
        });

        // Highlight specific frames
        $lines = $lines->map(function ($frame) {
            foreach (static::$highlights as $highlight) {
                if (str_is($highlight["pattern"], $frame)) {
                    $frame = vsprintf($highlight["template"], $frame);
                }
            }

            return $frame;
        });

        return $lines->implode("\n");
    }
}
