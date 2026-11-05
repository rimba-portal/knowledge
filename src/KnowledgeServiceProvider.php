<?php

declare(strict_types=1);

namespace Rimba\Knowledge;

use Rimba\Base\Services\BitesServiceProvider;
use Rimba\Knowledge\Console\Commands\BuildMesPayloadCommand;
use Rimba\Knowledge\Contracts\CurrentStaffResolver;
use Rimba\Knowledge\Contracts\DocumentRevisionApprovalGateway;
use Rimba\Knowledge\Services\ConfiguredCurrentStaffResolver;
use Rimba\Knowledge\Services\EventDrivenPintaApprovalGateway;
use Rimba\Knowledge\Services\MesProjectionService;
use Rimba\Knowledge\Services\ScoreCalculator;

final class KnowledgeServiceProvider extends BitesServiceProvider
{
    protected string $configFile = __DIR__.'/../config/bites.php';

    protected string $viewsPath = __DIR__.'/../resources/views';

    protected string $iconsPath = __DIR__.'/../resources/svg';

    protected function registerPackage(): void
    {
        $this->app->singleton(CurrentStaffResolver::class, ConfiguredCurrentStaffResolver::class);
        $this->app->singleton(DocumentRevisionApprovalGateway::class, EventDrivenPintaApprovalGateway::class);
        $this->app->singleton(MesProjectionService::class);
        $this->app->singleton(ScoreCalculator::class);
    }

    protected function bootPackage(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([BuildMesPayloadCommand::class]);
        }
    }
}
