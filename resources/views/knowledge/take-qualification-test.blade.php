<x-filament-panels::page>
    @if (! $this->attempt)
        <x-filament::button wire:click="begin">Start quiz</x-filament::button>
    @elseif ($this->attempt->status->value === 'in_progress')
        <form wire:submit="submit" class="space-y-8">
            @foreach ($this->attempt->answers as $answer)
                <fieldset class="rounded-xl border p-4">
                    <legend class="font-semibold">{{ $loop->iteration }}. {{ $answer->question_text }}</legend>
                    <div class="mt-3 space-y-2">
                        @foreach ($answer->options_snapshot as $option)
                            <label class="flex gap-2">
                                @if ($answer->question_type === 'multiple_choice')
                                    <input type="checkbox" wire:model="responses.{{ $answer->question_uuid }}.{{ $option['id'] }}" />
                                @else
                                    <input type="radio" value="{{ $option['id'] }}" wire:model="responses.{{ $answer->question_uuid }}" />
                                @endif
                                <span>{{ $option['answer'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            @endforeach
            <x-filament::button type="submit">Submit quiz</x-filament::button>
        </form>
    @else
        <div class="rounded-xl border p-6">
            <p class="text-lg font-semibold">Score: {{ number_format((float) $this->attempt->score, 2) }}%</p>
            <p>{{ $this->attempt->passed ? 'Passed' : 'Not passed' }}</p>
        </div>
    @endif
</x-filament-panels::page>
