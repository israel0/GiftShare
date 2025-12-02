@extends('layouts.app')

@section('title', 'Create New Listing')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Give Away an Item</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="5"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category *</label>
                        <select class="form-select @error('category_id') is-invalid @enderror"
                                id="category_id"
                                name="category_id"
                                required>
                            <option value="">Select a category</option>
                            @foreach(App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- City -->
                    <div class="mb-3">
                        <label for="city" class="form-label">City *</label>
                        <input type="text"
                               class="form-control @error('city') is-invalid @enderror"
                               id="city"
                               name="city"
                               value="{{ old('city') }}"
                               required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Weight -->
                        <div class="col-md-6 mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number"
                                   step="0.01"
                                   class="form-control @error('weight') is-invalid @enderror"
                                   id="weight"
                                   name="weight"
                                   value="{{ old('weight') }}">
                            <div class="form-text">Optional</div>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dimensions -->
                        <div class="col-md-6 mb-3">
                            <label for="dimensions" class="form-label">Dimensions</label>
                            <input type="text"
                                   class="form-control @error('dimensions') is-invalid @enderror"
                                   id="dimensions"
                                   name="dimensions"
                                   value="{{ old('dimensions') }}"
                                   placeholder="e.g., 60x30x30 inches">
                            <div class="form-text">Optional</div>
                            @error('dimensions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Photos -->
                    <div class="mb-4">
                        <label for="photos" class="form-label">Photos</label>
                        <input type="file"
                               class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror"
                               id="photos"
                               name="photos[]"
                               multiple
                               accept="image/*">
                        <div class="form-text">
                            Upload up to 5 photos. First photo will be used as the main image. Max 5MB each.
                        </div>
                        @error('photos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('photos.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Create Listing
                        </button>
                        <a href="{{ route('listings.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
