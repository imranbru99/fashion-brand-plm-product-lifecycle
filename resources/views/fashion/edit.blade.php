@php
use App\Models\FashionProduct;
@endphp

<x-filament::form wire:model.defer="fashionProduct">

    <x-filament::form.group>
        <x-slot name="label">Name</x-slot>
        <x-slot name="description">The name of the fashion product.</x-slot>
        <x-filament::input type="text" wire:model="fashionProduct.name" />
    </x-filament::form.group>

    <x-filament::form.group>
        <x-slot name="label">Description</x-slot>
        <x-slot name="description">A brief description of the fashion product.</x-slot>
        <x-filament::textarea wire:model="fashionProduct.description" />
    </x-filament::form.group>

    <x-filament::form.group>
        <x-slot name="label">Price</x-slot>
        <x-slot name="description">The price of the fashion product.</x-slot>
        <x-filament::input type="number" wire:model="fashionProduct.price" />
    </x-filament::form.group>

    <x-filament::form.actions>
        <x-filament::button type="submit">
            {{ __('Update') }}
        </x-filament::button>
    </x-filament::form.actions>
</x-filament::form>
