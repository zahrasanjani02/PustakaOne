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

    /* ===== MAIN LAYOUT ===== */
    .main-container {
        display: grid;
        grid-template-columns: 1fr;
        min-height: calc(100vh - 70px);
    }

    /* ===== CONTENT ===== */
    .content {
        padding: 2rem;
        overflow-y: auto;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    /* ===== ADMIN STATS (hanya untuk admin) ===== */
    .admin-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .content-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0C3B2E;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .btn-add-book {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(109, 151, 115, 0.3);
    }

    .filter-dropdown {
        padding: 0.65rem 1.2rem;
        background: white;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #6D9773;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-dropdown:hover {
        border-color: #6D9773;
        box-shadow: 0 2px 8px rgba(109, 151, 115, 0.15);
    }

    /* ===== BOOKS GRID ===== */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .book-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .book-cover {
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, #0C3B2E, #6D9773);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        overflow: hidden;
        position: relative;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-info {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .book-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.6em;
    }

    .book-author {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.8rem;
    }

    .book-description {
        font-size: 0.85rem;
        color: #888;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }

    .book-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.85rem;
    }

    .book-category {
        background: #E8F5E9;
        color: #2E7D32;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .book-stock {
        color: #666;
    }

    .book-stock.available {
        color: #2E7D32;
        font-weight: 600;
    }

    .book-stock.limited {
        color: #F57C00;
        font-weight: 600;
    }

    .book-stock.unavailable {
        color: #C62828;
        font-weight: 600;
    }

    .book-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.8rem;
        margin-top: auto;
    }

    /* ADMIN ACTIONS */
    .admin-book-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-edit, .btn-delete {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        border: none;
    }

    .btn-edit {
        background: #FFF3E0;
        color: #F57C00;
    }

    .btn-edit:hover {
        background: #FFE0B2;
    }

    .btn-delete {
        background: #FFEBEE;
        color: #C62828;
    }

    .btn-delete:hover {
        background: #FFCDD2;
    }

    /* MEMBER ACTIONS */
    .btn-read-more {
        background: linear-gradient(135deg, #BB8A52, #6D9773);
        color: white;
        border: none;
        padding: 0.65rem 1.2rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        flex: 1;
        text-decoration: none;
        text-align: center;
    }

    .btn-read-more:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(109, 151, 115, 0.3);
    }

    .book-actions-icons {
        display: flex;
        gap: 0.8rem;
    }

    .action-icon {
        width: 36px;
        height: 36px;
        border: 2px solid #E0E0E0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
        background: white;
    }

    .action-icon:hover {
        border-color: #6D9773;
        background: #F0F2F5;
    }

    .action-icon.favorited {
        background: #FFE8E8;
        border-color: #FF4444;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #666;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0C3B2E;
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        font-size: 1rem;
        color: #888;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        list-style: none;
    }

    .pagination li {
        margin: 0;
    }

    .pagination a,
    .pagination span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0.5rem 1rem;
        background: white;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        color: #6D9773;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        border-color: #6D9773;
        background: #F0F2F5;
    }

    .pagination .active span {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border-color: #6D9773;
    }

    .pagination .disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        .admin-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .content {
            padding: 1rem;
        }

        .content-title {
            font-size: 1.4rem;
        }

        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .admin-stats {
            grid-template-columns: 1fr;
        }

        .navbar {
            gap: 1rem;
        }

        .search-box {
            max-width: 250px;
            margin: 0;
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

<!-- MAIN CONTAINER -->
<div class="main-container">
    <!-- CONTENT -->
    <main class="content">
        @auth
            @if(auth()->user()->role === 'admin')
                {{-- ADMIN VIEW --}}
                
                {{-- Admin Statistics --}}
                <div class="admin-stats">
                    <div class="stat-card">
                        <div class="stat-icon">📚</div>
                        <div class="stat-value">{{ $stats['totalBooks'] ?? 0 }}</div>
                        <div class="stat-label">Total Books</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-value">{{ $stats['totalAvailable'] ?? 0 }}</div>
                        <div class="stat-label">Available Copies</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📖</div>
                        <div class="stat-value">{{ $stats['totalBorrowed'] ?? 0 }}</div>
                        <div class="stat-label">Currently Borrowed</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⚠️</div>
                        <div class="stat-value">{{ $stats['lowStock'] ?? 0 }}</div>
                        <div class="stat-label">Low Stock</div>
                    </div>
                </div>

                <div class="content-header">
                    <h1 class="content-title">Book Management</h1>
                    <div class="header-actions">
                        <button class="btn-add-book" onclick="alert('Add Book Modal - Coming Soon!')">
                            ➕ Add New Book
                        </button>
                        <form action="{{ route('readspace') }}" method="GET" style="display: inline;">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="category" class="filter-dropdown" onchange="this.form.submit()">
                                <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                {{-- Admin Book List --}}
                @if($books->count() > 0)
                <div class="books-grid">
                    @foreach($books as $book)
                    <div class="book-card">
                        <div class="book-cover">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                            @else
                                {{ $book->getCategoryEmoji() }}
                            @endif
                        </div>
                        <div class="book-info">
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author">{{ $book->author }}</div>
                            
                            <div class="book-meta">
                                <span class="book-category">{{ $book->category ?? 'General' }}</span>
                                <span class="book-stock {{ $book->available_copies > 3 ? 'available' : ($book->available_copies > 0 ? 'limited' : 'unavailable') }}">
                                    Stock: {{ $book->available_copies }}/{{ $book->total_copies }}
                                </span>
                            </div>
                            
                            <div class="book-description">{{ $book->description }}</div>
                            
                            <div class="book-actions">
                                <div class="admin-book-actions">
                                    <a href="{{ route('readspace.show', $book->id) }}" class="btn-read-more" style="flex: none; padding: 0.5rem 1rem; border-radius: 6px;">View</a>
                                    <button class="btn-edit" onclick="editBook({{ $book->id }})">✏️ Edit</button>
                                    <button class="btn-delete" onclick="deleteBook({{ $book->id }}, '{{ $book->title }}')">🗑️ Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">📚</div>
                    <div class="empty-state-title">No Books Found</div>
                    <div class="empty-state-text">Start by adding your first book to the library.</div>
                </div>
                @endif

            @else
                {{-- MEMBER VIEW --}}
                
                <div class="content-header">
                    <h1 class="content-title">Books Gallery</h1>
                    <form action="{{ route('readspace') }}" method="GET">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="category" class="filter-dropdown" onchange="this.form.submit()">
                            <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                {{-- Member Book Grid --}}
                @if($books->count() > 0)
                <div class="books-grid">
                    @foreach($books as $book)
                    <div class="book-card">
                        <div class="book-cover">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                            @else
                                {{ $book->getCategoryEmoji() }}
                            @endif
                        </div>
                        <div class="book-info">
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author">{{ $book->author }}</div>
                            
                            <div class="book-meta">
                                <span class="book-category">{{ $book->category ?? 'General' }}</span>
                                <span class="book-stock {{ $book->available_copies > 3 ? 'available' : ($book->available_copies > 0 ? 'limited' : 'unavailable') }}">
                                    {{ $book->available_copies > 0 ? $book->available_copies . ' available' : 'Not available' }}
                                </span>
                            </div>
                            
                            <div class="book-description">{{ $book->description }}</div>
                            
                            <div class="book-actions">
                                <a href="{{ route('readspace.show', $book->id) }}" class="btn-read-more">Read More</a>
                                <div class="book-actions-icons">
                                    <div class="action-icon favorite-btn {{ $book->isFavoritedBy(auth()->id()) ? 'favorited' : '' }}" 
                                         data-book-id="{{ $book->id }}"
                                         onclick="toggleFavorite({{ $book->id }})">
                                        ❤️
                                    </div>
                                    <div class="action-icon" onclick="shareBook({{ $book->id }}, '{{ $book->title }}')">📤</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">📚</div>
                    <div class="empty-state-title">No Books Found</div>
                    <div class="empty-state-text">
                        @if(request('search') || request('category'))
                            Try adjusting your search or filter to find what you're looking for.
                        @else
                            There are no books in the library yet.
                        @endif
                    </div>
                </div>
                @endif
            @endif
        @else
            {{-- GUEST VIEW (belum login) - sama seperti member tapi tanpa favorite --}}
            <div class="content-header">
                <h1 class="content-title">Books Gallery</h1>
                <form action="{{ route('readspace') }}" method="GET">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="category" class="filter-dropdown" onchange="this.form.submit()">
                        <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($books->count() > 0)
            <div class="books-grid">
                @foreach($books as $book)
                <div class="book-card">
                    <div class="book-cover">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                        @else
                            {{ $book->getCategoryEmoji() }}
                        @endif
                    </div>
                    <div class="book-info">
                        <div class="book-title">{{ $book->title }}</div>
                        <div class="book-author">{{ $book->author }}</div>
                        
                        <div class="book-meta">
                            <span class="book-category">{{ $book->category ?? 'General' }}</span>
                            <span class="book-stock {{ $book->available_copies > 3 ? 'available' : ($book->available_copies > 0 ? 'limited' : 'unavailable') }}">
                                {{ $book->available_copies > 0 ? $book->available_copies . ' available' : 'Not available' }}
                            </span>
                        </div>
                        
                        <div class="book-description">{{ $book->description }}</div>
                        
                        <div class="book-actions">
                            <a href="{{ route('readspace.show', $book->id) }}" class="btn-read-more">Read More</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <div class="empty-state-icon">📚</div>
                <div class="empty-state-title">No Books Found</div>
                <div class="empty-state-text">There are no books available at the moment.</div>
            </div>
            @endif
        @endauth

        <!-- Pagination -->
        @if($books->count() > 0)
        <div class="pagination-wrapper">
            {{ $books->links() }}
        </div>
        @endif
    </main>
</div>

<script>
// ===== MEMBER FUNCTIONS =====
@auth
@if(auth()->user()->role === 'member')
// Toggle Favorite Function
function toggleFavorite(bookId) {
    const btn = document.querySelector(`.favorite-btn[data-book-id="${bookId}"]`);
    
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

// Share Book Function
function shareBook(bookId, bookTitle) {
    const url = `${window.location.origin}/readspace/book/${bookId}`;
    
    if (navigator.share) {
        navigator.share({
            title: bookTitle,
            text: `Check out this book: ${bookTitle}`,
            url: url
        }).catch(err => console.log('Error sharing:', err));
    } else {
        navigator.clipboard.writeText(url).then(() => {
            showToast('Link buku berhasil disalin!');
        });
    }
}
@endif

// ===== ADMIN FUNCTIONS =====
@if(auth()->user()->role === 'admin')
function editBook(bookId) {
    // TODO: Implement edit modal atau redirect ke edit page
    alert('Edit Book ID: ' + bookId + '\n\nFeature coming soon!');
}

function deleteBook(bookId, bookTitle) {
    if (!confirm(`Are you sure you want to delete "${bookTitle}"?`)) {
        return;
    }

    fetch(`/admin/books/${bookId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Book deleted successfully', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || 'Failed to delete book', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the book.');
    });
}
@endif
@endauth

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