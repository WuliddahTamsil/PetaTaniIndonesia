@extends('layouts.app') // Assuming a layout file exists

@section('content')
<div class="container">
    <h1>Your Products</h1>

    <a href="{{ route('seller.products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    {{-- TODO: Display a table or list of products here --}}
    
    @if ($products->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Seller</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            @if ($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: auto;">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ Str::limit($product->description, 50) }}</td> {{-- Show a limited description --}}
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>{{ $product->seller_name ?? 'N/A' }}</td>
                        <td>{{ $product->market_location ?? 'N/A' }}</td>
                        <td>
                            {{-- Action buttons (Edit, Delete) - currently commented out --}}
                            {{-- <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form> --}}
                            Actions TBD
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You haven't added any products yet.</p>
    @endif
</div>
@endsection 