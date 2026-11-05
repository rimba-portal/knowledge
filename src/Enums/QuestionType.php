<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum QuestionType: string implements HasColor, HasLabel
{
    case SingleChoice = 'single_choice';
    case MultipleChoice = 'multiple_choice';
    case TrueFalse = 'true_false';

    public function getLabel(): string
    {
        return match ($this) {
            self::SingleChoice => 'Single choice',
            self::MultipleChoice => 'Multiple choice',
            self::TrueFalse => 'True / false',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::SingleChoice => 'info',
            self::MultipleChoice => 'warning',
            self::TrueFalse => 'gray',
        };
    }
}
