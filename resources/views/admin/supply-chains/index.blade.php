@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>Supply Chains</h1>
        <a href="{{ route('admin.supply-chains.create') }}" class="btn btn-primary mb-3">Create New Supply Chain</a>

        @if ($supplyChains->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplyChains as $supplyChain)
                        <tr>
                            <td>{{ $supplyChain->supplier->name }}</td>
                            <td>{{ $supplyChain->product->name }}</td>
                            <td>{{ $supplyChain->quantity }}</td>
                            <td>{{ $supplyChain->status }}</td>
                            <td>
                                <a href="{{ route('admin.supply-chains.edit', $supplyChain) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.supply-chains.destroy', $supplyChain) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No supply chains found.</p>
        @endif
    </div>
@endsection
