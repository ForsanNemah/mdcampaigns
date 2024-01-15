<x-filament-panels::page.simple
style="margin-top:30px">
    <x-slot name="header">
       {{$this->getLabel()}}
    </x-slot>
    <x-filament::section>
        <x-filament::section aside>
            <x-slot name="heading">
                <x-filament::avatar
                    src="https://filamentphp.com/dan.jpg"
                    alt='{{auth()->user()->getFilamentName() }}'
                    size="w-12 h-12"
                />
            </x-slot>
            <x-slot name="headerEnd">
                {{auth()->user()->getFilamentName() }}
                <br>
                {{auth()->user()->email }}            </x-slot>
            <x-filament-panels::form wire:submit="save">
                {{ $this->form }}
                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
            </x-filament-panels::form>

        </x-filament::section>


    </x-filament::section>

</x-filament-panels::page.simple>
