@php
use App\Models\SupplyChain;
@endphp

<x-filament::form wire:model.defer="supplyChain">

    <x-filament::input wire:model.defer="supplyChain.supplier_id" label="Supplier" :options="$suppliers" />

    <x-filament::input wire:model.defer="supplyChain.product_id" label="Product" :options="$products" />

    <x-filament::input wire:model.defer="supplyChain.quantity" label="Quantity" type="number" />

    <x-filament::select wire:model.defer="supplyChain.status" label="Status">
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
    </x-filament::select>

    <x-filament::button type="submit">Update Supply Chain</x-filament::button>

</x-filament::form>

<x-filament::notification wire:model.defer="success" type="success">
    Supply chain updated successfully!
</x-filament::notification>
