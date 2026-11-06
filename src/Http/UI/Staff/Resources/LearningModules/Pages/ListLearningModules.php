<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Rimba\Knowledge\Enums\ModuleDomain;
use Rimba\Knowledge\Http\UI\Staff\Resources\LearningModules\LearningModuleResource;
use Rimba\Knowledge\Models\LearningModule;

class ListLearningModules extends ListRecords
{
    protected static string $resource = LearningModuleResource::class;

    protected int|string|array $columnSpan = 'full';

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        $moduleDomainCounts = $this->getModuleDomainCounts();

        foreach (ModuleDomain::orderedCases() as $moduleDomain) {
            if (($moduleDomainCounts[$moduleDomain->value] ?? 0) > 0) {
                return $moduleDomain->value;
            }
        }

        return 'all';
    }

    public function getTabs(): array
    {
        $moduleDomainCounts = $this->getModuleDomainCounts();
        $total = $moduleDomainCounts->sum();

        $tabs = [
            'all' => Tab::make('All')
                ->icon('heroicon-o-rectangle-stack')
                ->badge($total > 0 ? $total : null)
                ->badgeColor('primary')
                ->modifyQueryUsing(
                    fn (Builder $query): Builder => $this
                        ->availableModules($query),
                ),
        ];

        foreach (ModuleDomain::orderedCases() as $moduleDomain) {
            $count = (int) ($moduleDomainCounts[$moduleDomain->value] ?? 0);

            if ($count === 0) {
                continue;
            }

            $tabs[$moduleDomain->value] = Tab::make(
                $moduleDomain->getLabel(),
            )
                ->icon($moduleDomain->getIcon())
                ->badge($count)
                ->badgeColor($moduleDomain->getColor())
                ->modifyQueryUsing(
                    fn (Builder $query): Builder => $this
                        ->availableModules($query)
                        ->where(
                            $query->qualifyColumn('code'),
                            'like',
                            $moduleDomain->getCodePattern(),
                        ),
                );
        }

        return $tabs;
    }

    private function availableModules(Builder $query): Builder
    {
        return $query->where(
            $query->qualifyColumn('status'),
            'active',
        );
    }

    /**
     * @return Collection<string, int>
     */
    private function getModuleDomainCounts(): Collection
    {
        return collect(ModuleDomain::orderedCases())
            ->mapWithKeys(
                fn (ModuleDomain $domain): array => [
                    $domain->value => LearningModule::query()
                        ->where('status', 'active')
                        ->where(
                            'code',
                            'like',
                            $domain->getCodePattern(),
                        )
                        ->count(),
                ],
            );
    }
}
