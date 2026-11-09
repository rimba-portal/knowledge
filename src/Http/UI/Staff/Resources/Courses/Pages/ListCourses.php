<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Http\UI\Staff\Resources\Courses\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Rimba\Knowledge\Enums\CourseType;
use Rimba\Knowledge\Http\UI\Staff\Resources\Courses\CourseResource;
use Rimba\Knowledge\Models\Course;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected int|string|array $columnSpan = 'full';

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        $courseTypeCounts = $this->getCourseTypeCounts();

        foreach (CourseType::orderedCases() as $courseType) {
            if (($courseTypeCounts[$courseType->value] ?? 0) > 0) {
                return $courseType->value;
            }
        }

        return 'all';
    }

    public function getTabs(): array
    {
        $courseTypeCounts = $this->getCourseTypeCounts();
        $total = $courseTypeCounts->sum();

        $tabs = [
            'all' => Tab::make('All')
                ->icon('heroicon-o-rectangle-stack')
                ->badge($total > 0 ? $total : null)
                ->badgeColor('primary')
                ->modifyQueryUsing(
                    fn (Builder $query): Builder => $this->activeCourses(
                        $query,
                    ),
                ),
        ];

        foreach (CourseType::orderedCases() as $courseType) {
            $count = (int) ($courseTypeCounts[$courseType->value] ?? 0);

            /*
             * Avoid showing tabs which have no courses.
             */
            if ($count === 0) {
                continue;
            }

            $tabs[$courseType->value] = Tab::make($courseType->getLabel())
                ->icon($courseType->getIcon())
                ->badge($count)
                ->badgeColor($courseType->getColor())
                ->modifyQueryUsing(
                    fn (Builder $query): Builder => $this
                        ->activeCourses($query)
                        ->where(
                            $query->qualifyColumn('code'),
                            'like',
                            $courseType->getCodePattern(),
                        ),
                );
        }

        return $tabs;
    }

    private function activeCourses(Builder $query): Builder
    {
        return $query->where(
            $query->qualifyColumn('status'),
            'active',
        );
    }

    private function getCourseTypeCounts(): Collection
    {
        return collect(CourseType::orderedCases())
            ->mapWithKeys(
                fn (CourseType $type): array => [
                    $type->value => Course::query()
                        ->where('status', 'active')
                        ->where(
                            'code',
                            'like',
                            $type->getCodePattern(),
                        )
                        ->count(),
                ],
            );
    }
}
