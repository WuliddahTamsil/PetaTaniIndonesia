@extends('layouts.app') // Assuming a layout file exists

@section('content')
<div class="container">
    <h1>Add New Product</h1>

    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image">
             <small class="form-text text-muted">Optional</small>
        </div>

         {{-- Seller Name and Market Location will likely be automatically associated with the logged-in seller, 
             but adding placeholders for now based on previous schema --}}
        <div class="mb-3">
            <label for="seller_name" class="form-label">Seller Name</label>
            <input type="text" class="form-control" id="seller_name" name="seller_name" placeholder="Will be automatically set by user" disabled>
        </div>

        <div class="mb-3">
            <label for="market_location" class="form-label">Market Location</label>
            <input type="text" class="form-control" id="market_location" name="market_location" placeholder="Will be automatically set by user" disabled>
        </div>

        <button type="submit" class="btn btn-success">Save Product</button>
    </form>
</div>
@endsection 