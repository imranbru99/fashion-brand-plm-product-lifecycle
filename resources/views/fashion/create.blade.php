@php
use App\Models\FashionProduct;
@endphp

<x-filament::form wire:model.defer="formData">

    <x-filament::form.group>
        <x-filament::form.label for="name">Name</x-filament::form.label>
        <x-filament::form.input type="text" id="name" name="name" wire:model="formData.name" required />
    </x-filament::form.group>

    <x-filament::form.group>
        <x-filament::form.label for="description">Description</x-filament::form.label>
        <x-filament::form.textarea id="description" name="description" wire:model="formData.description" required />
    </x-filament::form.group>

    <x-filament::form.group>
        <x-filament::form.label for="price">Price</x-filament::form.label>
        <x-filament::form.input type="number" id="price" name="price" wire:model="formData.price" required />
    </x-filament::form.group>

    <x-filament::form.actions>
        <x-filament::button type="submit">Create Product</x-filament::button>
    </x-filament::form.actions>
</x-filament::form>
