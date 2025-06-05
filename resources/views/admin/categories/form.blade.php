@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>{{ isset($category) ? 'Edit Category' : 'Add New Category' }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $category->slug ?? '') }}" required>
                    <small class="form-text text-muted">Leave empty to auto-generate from name</small>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to List</a>
                    <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update Category' : 'Create Category' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        if (!document.getElementById('slug').value) {
            let slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9-]/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            document.getElementById('slug').value = slug;
        }
    });
</script>
@endpush
@endsection 