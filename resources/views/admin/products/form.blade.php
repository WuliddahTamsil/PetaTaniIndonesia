@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" step="0.01" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    @if(isset($product) && $product->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($product->image) }}" alt="Current Image" style="max-width: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" {{ !isset($product) ? 'required' : '' }}>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="seller_name" class="form-label">Seller Name</label>
                    <input type="text" class="form-control @error('seller_name') is-invalid @enderror" id="seller_name" name="seller_name" value="{{ old('seller_name', $product->seller_name ?? '') }}" required>
                    @error('seller_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="market_location" class="form-label">Market Location</label>
                    <input type="text" class="form-control @error('market_location') is-invalid @enderror" id="market_location" name="market_location" value="{{ old('market_location', $product->market_location ?? '') }}" required>
                    @error('market_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to List</a>
                    <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update Product' : 'Create Product' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 