@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card" style="background: white; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08);">
                <div class="card-header text-center" style="background: linear-gradient(135d, #27ae60 0%, #2ecc71 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h4 class="mb-0" style="font-weight: 600;">
                        <i class="fas fa-plus-circle me-2"></i>Create New Category
                    </h4>
                    <p class="mb-0 mt-2" style="opacity: 0.9; font-size: 14px;">Organize your content better</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum 1000 characters</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-lg me-md-2" 
                               style="border-radius: 8px; font-weight: 600; padding: 12px 30px;">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" 
                                    style="border-radius: 8px; font-weight: 600; padding: 12px 30px; min-width: 180px;">
                                <i class="fas fa-save me-2"></i>Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
