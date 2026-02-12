<?php

declare(strict_types=1);

namespace Leek\CompactLogs;

use Illuminate\Log\Logger;

class CompactExceptionTap
{
    public function __invoke(Logger $logger): void
    {
        $formatter = new CompactExceptionFormatter(
            maxTraceDepth: (int) config('compact-logs.max_trace_depth', 3),
        );

        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($formatter);
        }
    }
}
