<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Staff List page') }}
        </h2>
    </x-slot>

    <div class="row"> <div class="col-12">
       @livewire('employeelist')
    </div> </div>
</x-app-layout>