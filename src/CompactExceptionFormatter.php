<?php

declare(strict_types=1);

namespace Leek\CompactLogs;

use Monolog\Formatter\LineFormatter;
use Throwable;

class CompactExceptionFormatter extends LineFormatter
{
    public function __construct(
        private int $maxTraceDepth = 3,
        ?string $format = null,
        ?string $dateFormat = null,
        bool $allowInlineLineBreaks = true,
        bool $ignoreEmptyContextAndExtra = true,
    ) {
        parent::__construct($format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
    }

    protected function normalizeException(Throwable $e, int $depth = 0): string
    {
        $str = '[object] (' . $e::class . '(code: ' . $e->getCode() . '): ' . $e->getMessage()
            . ' at ' . $e->getFile() . ':' . $e->getLine() . ')';

        $trace = $e->getTraceAsString();
        $frames = explode("\n", $trace);
        $totalFrames = count($frames);

        if ($totalFrames > $this->maxTraceDepth) {
            $frames = array_slice($frames, 0, $this->maxTraceDepth);
            $remaining = $totalFrames - $this->maxTraceDepth;
            $frames[] = "... and {$remaining} more frames";
        }

        $str .= "\n[stacktrace]\n" . implode("\n", $frames);

        if ($previous = $e->getPrevious()) {
            $str .= "\n[previous] " . $this->normalizeException($previous, $depth + 1);
        }

        return $str;
    }
}
