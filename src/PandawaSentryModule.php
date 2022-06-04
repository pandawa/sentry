<?php

declare(strict_types=1);

namespace Pandawa\Sentry;

use Pandawa\Component\Module\AbstractModule;
use Sentry\State\HubInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class PandawaSentryModule extends AbstractModule
{
    protected function build(): void
    {
        if (null !== $hub = $this->getHub()) {
            $hub->getClient()->getOptions()->setTracesSampler(
                config('services.sentry.traces_sampler', [TracesSampler::class, 'sampling'])
            );
        }
    }

    private function getHub(): ?HubInterface
    {
        return $this->app->get(HubInterface::class);
    }
}
