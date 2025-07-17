@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card" style="background: white; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08);">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h4 class="mb-0" style="font-weight: 600;">
                        <i class="fas fa-plus-circle me-2"></i>Create New Post
                    </h4>
                    <p class="mb-0 mt-2" style="opacity: 0.9; font-size: 14px;">Share your amazing story with the world</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="3" required 
                                      placeholder="Brief summary of your post...">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum 500 characters</div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10" required 
                                      placeholder="Write your post content here...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="featured_image" class="form-label">Featured Image</label>
                            <div class="custom-file-upload">
                                <input type="file" id="featured_image" name="featured_image" accept="image/*" 
                                       onchange="previewImage(this)">
                                <div class="file-upload-btn">
                                    <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                                    <div class="file-upload-text">
                                        <strong>Choose an image</strong><br>
                                        <small>or drag and drop here</small>
                                    </div>
                                </div>
                            </div>
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <img id="preview-img" src="" alt="Preview" class="img-fluid" 
                                     style="max-height: 200px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            </div>
                            @error('featured_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" 
                                       name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Publish immediately
                                </label>
                            </div>
                            <div class="form-text">Uncheck to save as draft</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary btn-lg me-md-2" 
                               style="border-radius: 8px; font-weight: 600; padding: 12px 30px;">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" 
                                    style="border-radius: 8px; font-weight: 600; padding: 12px 30px; min-width: 150px;">
                                <i class="fas fa-save me-2"></i>Create Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewImage(input) {
    const file = input.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const uploadBtn = document.querySelector('.file-upload-btn');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            uploadBtn.innerHTML = `
                <i class="fas fa-check-circle file-upload-icon" style="color: #28a745;"></i>
                <div class="file-upload-text">
                    <strong style="color: #28a745;">Image Selected</strong><br>
                    <small>${file.name}</small>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
}

// Drag and drop functionality
const fileUpload = document.querySelector('.custom-file-upload');
const fileInput = document.getElementById('featured_image');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileUpload.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    fileUpload.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    fileUpload.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    fileUpload.querySelector('.file-upload-btn').style.background = 'linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%)';
    fileUpload.querySelector('.file-upload-btn').style.borderColor = '#764ba2';
}

function unhighlight(e) {
    fileUpload.querySelector('.file-upload-btn').style.background = 'linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%)';
    fileUpload.querySelector('.file-upload-btn').style.borderColor = '#667eea';
}

fileUpload.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        fileInput.files = files;
        previewImage(fileInput);
    }
}
</script>
@endsection
