@php
use App\Models\FashionProduct;
@endphp

<x-filament::page>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Fashion Products</h2>
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-col gap-4">
            @foreach ($fashionProducts as $product)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold">{{ $product->name }}</h3>
                    <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                    <p class="mt-2 text-gray-600">${{ $product->price }}</p>
                    <a href="{{ route('fashion.show', ['id' => $product->id]) }}" class="mt-4 btn btn-primary">View</a>
                </div>
            @endforeach
        </div>
    </x-slot>

    <x-slot name="footer">
        {{ $fashionProducts->links() }}
    </x-slot>
</x-filament::page>
