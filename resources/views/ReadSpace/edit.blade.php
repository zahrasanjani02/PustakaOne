@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #F5F7FA;
    }

    /* ===== DETAIL CONTAINER ===== */
    .detail-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 2rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #6D9773;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .back-button:hover {
        color: #0C3B2E;
        transform: translateX(-5px);
    }

    .book-detail-card {
        background: white;
        border-radius: 16px;
        padding: 3rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 3rem;
    }

    /* ===== IMAGE UPLOAD SECTION ===== */
    .book-cover-large {
        width: 100%;
        height: 500px;
        background: linear-gradient(135deg, #0C3B2E, #6D9773);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 6rem;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        position: relative;
        margin-bottom: 1rem;
    }

    .book-cover-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .file-upload-wrapper {
        text-align: center;
    }

    .custom-file-upload {
        display: inline-block;
        padding: 0.5rem 1rem;
        cursor: pointer;
        background: #E8F5E9;
        color: #0C3B2E;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s;
        border: 1px dashed #0C3B2E;
        width: 100%;
    }

    .custom-file-upload:hover {
        background: #C8E6C9;
    }

    input[type="file"] {
        display: none;
    }

    /* ===== FORM INPUTS STYLING ===== */
    .book-detail-info {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .edit-input {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s;
        color: #333;
    }

    .edit-input:focus {
        border-color: #6D9773;
        outline: none;
        box-shadow: 0 0 0 4px rgba(109, 151, 115, 0.1);
    }

    /* Title Input Style */
    .input-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0C3B2E;
        padding: 0.5rem;
        margin-bottom: 0.5rem;
    }

    /* Author Input Style */
    .input-author {
        font-size: 1.1rem;
        color: #666;
        font-weight: 500;
        padding: 0.5rem;
    }

    .book-detail-meta {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        padding: 1.5rem;
        background: #F8F9FA;
        border-radius: 12px;
        border: 1px solid #EEEEEE;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .meta-label {
        font-size: 0.85rem;
        color: #888;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .book-detail-description-section {
        margin-top: 1rem;
    }

    .description-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.8rem;
    }

    .edit-textarea {
        width: 100%;
        min-height: 200px;
        padding: 1rem;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        color: #555;
        line-height: 1.6;
        resize: vertical;
    }

    .edit-textarea:focus {
        border-color: #6D9773;
        outline: none;
    }

    /* ===== ACTIONS ===== */
    .book-actions-detail {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #EEE;
    }

    .btn-save {
        flex: 2;
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(109, 151, 115, 0.3);
    }

    .btn-cancel {
        flex: 1;
        background: white;
        color: #C62828;
        border: 2px solid #FFEBEE;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-cancel:hover {
        background: #FFEBEE;
        border-color: #C62828;
    }

    .error-msg {
        color: #C62828;
        font-size: 0.8rem;
        margin-top: 0.2rem;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .book-detail-card {
            grid-template-columns: 1fr;
            padding: 1.5rem;
            gap: 2rem;
        }
        .book-cover-large {
            height: 350px;
        }
        .book-detail-meta {
            grid-template-columns: 1fr;
        }
    }
</style>

<x-navbar/>

<div class="detail-container">
    {{-- ALERT ERROR JIKA ADA --}}
    @if ($errors->any())
        <div style="background: #FFEBEE; color: #C62828; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #FFCDD2;">
            <strong>Whoops! Something went wrong.</strong>
            <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('readspace.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="book-detail-card">
            <!-- LEFT COLUMN: COVER IMAGE -->
            <div>
                <div class="book-cover-large" id="coverPreviewContainer">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" id="coverPreview">
                    @else
                        <span id="emojiPreview">{{ $book->getCategoryEmoji() }}</span>
                        <img src="" alt="Preview" id="coverPreview" style="display: none;">
                    @endif
                </div>
                
                <div class="file-upload-wrapper">
                    <label for="cover_image" class="custom-file-upload">
                        📸 Change Cover Image
                    </label>
                    <input type="file" id="cover_image" name="cover_image" accept="image/*" onchange="previewImage(event)">
                </div>
            </div>

            <!-- RIGHT COLUMN: INFO INPUTS -->
            <div class="book-detail-info">
                
                <!-- Title & Author -->
                <div>
                    <label class="meta-label">Book Title</label>
                    <input type="text" name="title" class="edit-input input-title" value="{{ old('title', $book->title) }}" placeholder="Enter book title">
                    
                    <label class="meta-label" style="margin-top: 1rem; display:block;">Author</label>
                    <input type="text" name="author" class="edit-input input-author" value="{{ old('author', $book->author) }}" placeholder="Enter author name">
                </div>

                <!-- Meta Information Grid -->
                <div class="book-detail-meta">
                    <div class="meta-item">
                        <span class="meta-label">Category</span>
                        <select name="category" class="edit-input">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $book->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="meta-item">
                        <span class="meta-label">Total Copies (Stock)</span>
                        <input type="number" name="total_copies" class="edit-input" value="{{ old('total_copies', $book->total_copies) }}" min="1">
                        <small style="color: #888;">Currently Available: {{ $book->available_copies }}</small>
                    </div>

                    <div class="meta-item">
                        <span class="meta-label">ISBN</span>
                        <input type="text" name="isbn" class="edit-input" value="{{ old('isbn', $book->isbn) }}" placeholder="N/A">
                    </div>

                    <div class="meta-item">
                        <span class="meta-label">Publisher</span>
                        <input type="text" name="publisher" class="edit-input" value="{{ old('publisher', $book->publisher) }}" placeholder="N/A">
                    </div>

                    <div class="meta-item">
                        <span class="meta-label">Published Year</span>
                        <input type="number" name="published_year" class="edit-input" value="{{ old('published_year', $book->published_year) }}" placeholder="YYYY">
                    </div>

                    <div class="meta-item">
                        <span class="meta-label">Language</span>
                        <input type="text" name="language" class="edit-input" value="{{ old('language', $book->language) }}" placeholder="English, Indonesia, etc">
                    </div>

                    <div class="meta-item" style="grid-column: span 2;">
                        <span class="meta-label">Shelf Location</span>
                        <input type="text" name="location" class="edit-input" value="{{ old('location', $book->location) }}" placeholder="e.g. Rack A-12">
                    </div>
                </div>

                <!-- Description -->
                <div class="book-detail-description-section">
                    <h3 class="description-title">Description</h3>
                    <textarea name="description" class="edit-textarea" placeholder="Enter book synopsis...">{{ old('description', $book->description) }}</textarea>
                </div>

                <!-- Actions -->
                <div class="book-actions-detail">
                    <a href="{{ route('readspace') }}" class="btn-cancel">
                        Cancel
                    </a>
                    <button type="submit" class="btn-save">
                        💾 Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Script sederhana untuk preview gambar saat user upload file baru
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('coverPreview');
        const emoji = document.getElementById('emojiPreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if(emoji) emoji.style.display = 'none';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<x-footer/>
@endsection