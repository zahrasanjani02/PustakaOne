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
    }

    .book-cover-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-detail-info {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .book-detail-title {
        font-size: 2rem;
        font-weight: 700;
        color: #0C3B2E;
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }

    .book-detail-author {
        font-size: 1.2rem;
        color: #666;
        font-weight: 500;
    }

    .book-detail-meta {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        padding: 1.5rem;
        background: #F8F9FA;
        border-radius: 12px;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .meta-label {
        font-size: 0.85rem;
        color: #888;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .meta-value {
        font-size: 1rem;
        color: #333;
        font-weight: 600;
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

    .book-detail-description {
        font-size: 1rem;
        color: #555;
        line-height: 1.8;
    }

    .book-actions-detail {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .btn-borrow {
        flex: 1;
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .btn-borrow:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(109, 151, 115, 0.3);
    }

    .btn-borrow:disabled {
        background: linear-gradient(135deg, #ccc, #999);
        cursor: not-allowed;
        transform: none;
    }

    .btn-favorite-detail {
        width: 60px;
        height: 60px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.5rem;
        background: white;
    }

    .btn-favorite-detail:hover {
        border-color: #FF4444;
        background: #FFE8E8;
    }

    .btn-favorite-detail.favorited {
        background: #FFE8E8;
        border-color: #FF4444;
    }

    .availability-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .availability-badge.available {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .availability-badge.limited {
        background: #FFF3E0;
        color: #F57C00;
    }

    .availability-badge.unavailable {
        background: #FFEBEE;
        color: #C62828;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .book-detail-card {
            grid-template-columns: 1fr;
            padding: 1.5rem;
            gap: 2rem;
        }

        .book-cover-large {
            height: 400px;
        }

        .book-detail-title {
            font-size: 1.5rem;
        }

        .book-detail-meta {
            grid-template-columns: 1fr;
        }

        .detail-container {
            padding: 1rem;
        }
    }
</style>

<!-- NAVBAR -->
<x-navbar/>

<script>
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

// Close menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('userMenu');
    const profile = document.querySelector('.user-profile');
    
    if (profile && !profile.contains(event.target)) {
        menu.style.display = 'none';
    }
});
</script>

<!-- DETAIL CONTAINER -->
<div class="detail-container">
    <a href="{{ route('readspace') }}" class="back-button">
        ← Back to ReadSpace
    </a>

    <div class="book-detail-card">
        <!-- Book Cover -->
        <div class="book-cover-large">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
            @else
                {{ $book->getCategoryEmoji() }}
            @endif
        </div>

        <!-- Book Info -->
        <div class="book-detail-info">
            <div>
                <h1 class="book-detail-title">{{ $book->title }}</h1>
                <p class="book-detail-author">by {{ $book->author }}</p>
            </div>

            <!-- Availability Badge -->
            <div>
                @if($book->available_copies > 3)
                    <span class="availability-badge available">
                        ✓ Available ({{ $book->available_copies }} copies)
                    </span>
                @elseif($book->available_copies > 0)
                    <span class="availability-badge limited">
                        ⚠ Limited ({{ $book->available_copies }} copies left)
                    </span>
                @else
                    <span class="availability-badge unavailable">
                        ✗ Currently Unavailable
                    </span>
                @endif
            </div>

            <!-- Book Meta Information -->
            <div class="book-detail-meta">
                <div class="meta-item">
                    <span class="meta-label">ISBN</span>
                    <span class="meta-value">{{ $book->isbn ?? 'N/A' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Publisher</span>
                    <span class="meta-value">{{ $book->publisher ?? 'N/A' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Published Year</span>
                    <span class="meta-value">{{ $book->published_year ?? 'N/A' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Category</span>
                    <span class="meta-value">{{ $book->category ?? 'General' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Language</span>
                    <span class="meta-value">{{ $book->language ?? 'N/A' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Location</span>
                    <span class="meta-value">{{ $book->location ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Description -->
            <div class="book-detail-description-section">
                <h3 class="description-title">About This Book</h3>
                <p class="book-detail-description">
                    {{ $book->description ?? 'No description available for this book.' }}
                </p>
            </div>

            <!-- Actions -->
            <div class="book-actions-detail">
                @auth
                    <button 
                        class="btn-borrow" 
                        onclick="borrowBook({{ $book->id }})"
                        {{ $book->available_copies == 0 ? 'disabled' : '' }}>
                        {{ $book->available_copies > 0 ? '📖 Borrow This Book' : '✗ Not Available' }}
                    </button>
                    <div 
                        class="btn-favorite-detail {{ $book->isFavoritedBy(auth()->id()) ? 'favorited' : '' }}" 
                        data-book-id="{{ $book->id }}"
                        onclick="toggleFavorite({{ $book->id }})">
                        ❤️
                    </div>
                @else
                    <button class="btn-borrow" onclick="window.location.href='{{ route('login') }}'">
                        🔒 Login to Borrow
                    </button>
                @endauth
            </div>
        </div>
    </div>
</div>

<script>
// Toggle Favorite Function
function toggleFavorite(bookId) {
    @guest
        alert('Silakan login terlebih dahulu untuk menambahkan favorit');
        window.location.href = '{{ route("login") }}';
        return;
    @endguest

    const btn = document.querySelector(`.btn-favorite-detail[data-book-id="${bookId}"]`);
    
    fetch(`/readspace/favorite/${bookId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.isFavorited) {
                btn.classList.add('favorited');
            } else {
                btn.classList.remove('favorited');
            }
            
            showToast(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

// Borrow Book Function
function borrowBook(bookId) {
    if (!confirm('Are you sure you want to borrow this book?')) {
        return;
    }

    fetch(`/readspace/borrow/${bookId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            
            // Redirect ke halaman reservation atau reload
            setTimeout(() => {
                window.location.href = '{{ route("reservation") }}';
            }, 1500);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

// Toast Notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const bgColor = type === 'success' ? '#0C3B2E' : type === 'error' ? '#C62828' : '#0C3B2E';
    
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(400px);
        opacity: 0;
    }
}
</style>

<x-footer/>

@endsection