<?php

declare(strict_types=1);

namespace Pandawa\Sentry;

use Sentry\Tracing\SamplingContext;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class TracesSampler
{
    public static function sampling(SamplingContext $context): float
    {
        if (static::isForbidden($context->getTransactionContext()->getData()['url'] ?? null)) {
            return 0;
        }

        return config('sentry.traces_sample_rate', 0);
    }

    private static function isForbidden(?string $path): bool
    {
        foreach ((array) config('services.sentry.exclude_routes', ['ping']) as $forbidden) {
            if (preg_match('/' . addcslashes($forbidden, '/') . '/', $path)) {
                return true;
            }
        }

        return false;
    }
}
