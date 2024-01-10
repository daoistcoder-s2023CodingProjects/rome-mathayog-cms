<x-filament-widgets::widget>
    <x-filament::section>
        <form wire:submit="create" class="flex flex-col">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-3 ml-auto">
                {{ __('filament-panels::resources/pages/create-record.form.actions.create.label') }}
            </x-filament::button>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
