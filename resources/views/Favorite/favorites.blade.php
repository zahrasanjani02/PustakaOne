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
        color: #333;
    }

    .content {
        padding: 2rem 5%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #666;
        font-size: 0.95rem;
    }

    /* Stats Card */
    .stats-card {
        background: linear-gradient(135deg, #FFBA00, #BB8A52);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(187, 138, 82, 0.3);
    }

    .stats-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stats-icon {
        font-size: 3rem;
    }

    .stats-info h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.3rem;
    }

    .stats-info p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Books Grid */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .book-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
    }

    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .book-cover {
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, #0C3B2E, #6D9773);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        position: relative;
    }

    .favorite-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: #FFBA00;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .book-info {
        padding: 1.5rem;
    }

    .book-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .book-author {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.8rem;
    }

    .book-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 1rem;
    }

    .book-actions {
        display: flex;
        gap: 0.8rem;
    }

    .btn-view {
        flex: 1;
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 0.7rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        text-align: center;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(12, 59, 46, 0.2);
    }

    .btn-remove {
        background: #E74C3C;
        color: white;
        border: none;
        padding: 0.7rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-remove:hover {
        background: #C0392B;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .empty-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #666;
        margin-bottom: 2rem;
    }

    .btn-browse {
        background: linear-gradient(135deg, #BB8A52, #FFBA00);
        color: white;
        border: none;
        padding: 0.9rem 2rem;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        display: inline-block;
    }

    .btn-browse:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(187, 138, 82, 0.4);
    }

    /* Toast Notification */
    .toast {
        position: fixed;
        top: 100px;
        right: 2rem;
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        display: none;
        align-items: center;
        gap: 1rem;
        z-index: 1000;
        animation: slideIn 0.3s ease;
    }

    .toast.show {
        display: flex;
    }

    .toast.success {
        border-left: 4px solid #6D9773;
    }

    .toast.error {
        border-left: 4px solid #E74C3C;
    }

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

    /* Responsive */
    @media (max-width: 768px) {
        .content {
            padding: 1rem;
        }

        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        .book-cover {
            height: 200px;
            font-size: 3rem;
        }

        .stats-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
    }
</style>

<!-- NAVBAR -->
<x-navbar />

<!-- CONTENT -->
<div class="content">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">My Favorites</h1>
        <p class="page-subtitle">Your collection of favorite books</p>
    </div>

    <!-- Stats Card -->
    <div class="stats-card">
        <div class="stats-content">
            <div class="stats-info">
                <h3>{{ $stats['totalFavorites'] }}</h3>
                <p>Favorite Books</p>
            </div>
            <div class="stats-icon">❤️</div>
        </div>
    </div>

    @if($favorites->count() > 0)
        <!-- Books Grid -->
        <div class="books-grid">
            @foreach($favorites as $favorite)
            <div class="book-card">
                <div class="book-cover">
                    <span class="favorite-badge">❤️</span>
                    📖
                </div>
                <div class="book-info">
                    <h3 class="book-title">{{ $favorite->book->title }}</h3>
                    <p class="book-author">by {{ $favorite->book->author }}</p>
                    <div class="book-meta">
                        <span>📚 {{ $favorite->book->category }}</span>
                        <span>📅 {{ $favorite->book->published_year }}</span>
                    </div>
                    <div class="book-actions">
                        <a href="{{ route('readspace') }}" class="btn-view">View Details</a>
                        <button class="btn-remove" onclick="removeFavorite({{ $favorite->id }}, '{{ $favorite->book->title }}')">🗑️</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 3rem;">
            {{ $favorites->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">❤️</div>
            <h2 class="empty-title">No Favorites Yet</h2>
            <p class="empty-text">Start adding books to your favorites to see them here!</p>
            <a href="{{ route('readspace') }}" class="btn-browse">Browse Books</a>
        </div>
    @endif
</div>

<!-- FOOTER -->
<x-footer />

<!-- Toast Notification -->
<div id="toast" class="toast">
    <span id="toastIcon">✓</span>
    <span id="toastMessage">Success!</span>
</div>

<script>
function removeFavorite(favoriteId, bookTitle) {
    if (!confirm(`Remove "${bookTitle}" from favorites?`)) {
        return;
    }

    fetch(`/favorites/${favoriteId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            // Reload page after 1 second
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.', 'error');
    });
}

function showToast(message, type) {
    const toast = document.getElementById('toast');
    const toastIcon = document.getElementById('toastIcon');
    const toastMessage = document.getElementById('toastMessage');
    
    toastIcon.textContent = type === 'success' ? '✓' : '✗';
    toastMessage.textContent = message;
    toast.className = `toast ${type} show`;
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}
</script>

@endsection