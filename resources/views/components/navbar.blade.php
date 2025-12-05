<style>
    .navbar {
        background: linear-gradient(135deg, #0C3B2E 0%, #1a5a48 100%);
        box-shadow: 0 2px 12px rgba(12, 59, 46, 0.15);
        padding: 1.2rem 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
        gap: 2rem;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
    }

    .navbar-brand span:first-child {
        font-size: 1.5rem;
    }

    .navbar-brand .logo-text {
        font-weight: 700;
        font-size: 1.3rem;
        color: white;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: white;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        overflow: hidden;
        flex: 1;
        max-width: 450px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .search-box input {
        border: none;
        padding: 0.7rem 1rem;
        width: 100%;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
    }

    .search-box button {
        background: linear-gradient(135deg, #6D9773, #0C3B2E);
        color: white;
        border: none;
        padding: 0.7rem 1rem;
        cursor: pointer;
        font-weight: 600;
    }

    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .notification-icon {
        position: relative;
        font-size: 1.3rem;
        color: white;
        cursor: pointer;
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #FFBA00;
        color: #0C3B2E;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        cursor: pointer;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
    }

    .user-profile:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #BB8A52, #FFBA00);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: bold;
        color: #0C3B2E;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
    }

    .user-role {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
    }
</style>

<!-- NAVBAR -->
<div class="navbar">
    <a href="{{ route('dashboard') }}" class="navbar-brand">
        <span>📚</span>
        <span class="logo-text">PustakaOne</span>
    </a>

    @auth
    <!-- Menu untuk semua role -->
    <div style="display: flex; gap: 3rem; list-style: none;">
        <a href="{{ route('about') }}" 
           style="text-decoration: none; 
                  color: {{ request()->routeIs('about') ? '#FFBA00' : '#FFFFFF' }}; 
                  font-weight: {{ request()->routeIs('about') ? '600' : '500' }}; 
                  font-size: 0.95rem; 
                  transition: all 0.3s ease;
                  {{ request()->routeIs('about') ? 'border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;' : '' }}" 
           onmouseover="if(!this.classList.contains('active')) this.style.color='#FFBA00'" 
           onmouseout="if(!this.classList.contains('active')) this.style.color='#FFFFFF'">
           About Us
        </a>
        
        <a href="{{ route('readspace') }}" 
           style="text-decoration: none; 
                  color: {{ request()->routeIs('readspace*') ? '#FFBA00' : '#FFFFFF' }}; 
                  font-weight: {{ request()->routeIs('readspace*') ? '600' : '500' }}; 
                  font-size: 0.95rem; 
                  transition: all 0.3s ease;
                  {{ request()->routeIs('readspace*') ? 'border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;' : '' }}" 
           onmouseover="if(!this.classList.contains('active')) this.style.color='#FFBA00'" 
           onmouseout="if(!this.classList.contains('active')) this.style.color='#FFFFFF'">
           ReadSpace
        </a>
        
        <a href="{{ route('reservation') }}" 
           style="text-decoration: none; 
                  color: {{ request()->routeIs('reservation') ? '#FFBA00' : '#FFFFFF' }}; 
                  font-weight: {{ request()->routeIs('reservation') ? '600' : '500' }}; 
                  font-size: 0.95rem; 
                  transition: all 0.3s ease;
                  {{ request()->routeIs('reservation') ? 'border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;' : '' }}" 
           onmouseover="if(!this.classList.contains('active')) this.style.color='#FFBA00'" 
           onmouseout="if(!this.classList.contains('active')) this.style.color='#FFFFFF'">
           Reservation
        </a>
        
        <a href="{{ route('finedesk') }}" 
           style="text-decoration: none; 
                  color: {{ request()->routeIs('finedesk') ? '#FFBA00' : '#FFFFFF' }}; 
                  font-weight: {{ request()->routeIs('finedesk') ? '600' : '500' }}; 
                  font-size: 0.95rem; 
                  transition: all 0.3s ease;
                  {{ request()->routeIs('finedesk') ? 'border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;' : '' }}" 
           onmouseover="if(!this.classList.contains('active')) this.style.color='#FFBA00'" 
           onmouseout="if(!this.classList.contains('active')) this.style.color='#FFFFFF'">
           FineDesk
        </a>
        
        <a href="{{ route('membership') }}" 
           style="text-decoration: none; 
                  color: {{ request()->routeIs('membership') ? '#FFBA00' : '#FFFFFF' }}; 
                  font-weight: {{ request()->routeIs('membership') ? '600' : '500' }}; 
                  font-size: 0.95rem; 
                  transition: all 0.3s ease;
                  {{ request()->routeIs('membership') ? 'border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;' : '' }}" 
           onmouseover="if(!this.classList.contains('active')) this.style.color='#FFBA00'" 
           onmouseout="if(!this.classList.contains('active')) this.style.color='#FFFFFF'">
           Membership
        </a>
    </div>
    @else
    <!-- Menu untuk GUEST (belum login) -->
    <div style="display: flex; gap: 3rem; list-style: none;">
        <a href="{{ route('about') }}" 
           style="text-decoration: none; 
                  color: {{ request()->routeIs('about') ? '#FFBA00' : '#FFFFFF' }}; 
                  font-weight: {{ request()->routeIs('about') ? '600' : '500' }}; 
                  font-size: 0.95rem; 
                  {{ request()->routeIs('about') ? 'border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;' : '' }}">
           About Us
        </a>
        <a href="{{ route('readspace') }}" 
           style="text-decoration: none; 
                  color: {{ request()->routeIs('readspace*') ? '#FFBA00' : '#FFFFFF' }}; 
                  font-weight: {{ request()->routeIs('readspace*') ? '600' : '500' }}; 
                  font-size: 0.95rem; 
                  {{ request()->routeIs('readspace*') ? 'border-bottom: 2px solid #FFBA00; padding-bottom: 0.25rem;' : '' }}">
           ReadSpace
        </a>
    </div>
    @endauth

    <form action="{{ route('readspace') }}" method="GET" class="search-box">
        <input type="text" name="search" placeholder="Cari buku, penulis, atau ISBN..." value="{{ request('search') }}">
        <button type="submit">🔍</button>
    </form>

    <div class="navbar-actions">
        @auth
        <div class="notification-icon">
            🔔
            <span class="notification-badge">5</span>
        </div>
        
        <div class="user-profile" onclick="toggleUserMenu()">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
            <span style="color: white; font-size: 0.7rem;">▼</span>
        </div>

        <!-- Dropdown Menu -->
        <div id="userMenu" style="display: none; position: absolute; top: 70px; right: 5%; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 200px; z-index: 1000;">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" style="display: block; padding: 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                    <span style="margin-right: 0.5rem;">👤</span> My Profile
                </a>
                <a href="{{ route('dashboard') }}" style="display: block; padding: 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                    <span style="margin-right: 0.5rem;">⚙️</span> Admin Dashboard
                </a>
            @else
                <a href="{{ route('dashboard') }}" style="display: block; padding: 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                    <span style="margin-right: 0.5rem;">👤</span> My Profile
                </a>
                <a href="{{ route('reservation') }}" style="display: block; padding: 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                    <span style="margin-right: 0.5rem;">📚</span> My Borrowings
                </a>
                <a href="{{ route('favorites') }}" style="display: block; padding: 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
        <span style="margin-right: 0.5rem;">❤️</span> My Favorites
    </a>

            @endif
            
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; text-align: left; padding: 1rem; background: none; border: none; color: #C62828; cursor: pointer; font-family: 'Poppins', sans-serif; font-weight: 500;">
                    <span style="margin-right: 0.5rem;">🚪</span> Logout
                </button>
            </form>
        </div>
        @else
        <a href="{{ route('login') }}" style="color: white; text-decoration: none; font-weight: 600; padding: 0.5rem 1rem; background: rgba(255, 255, 255, 0.1); border-radius: 8px;">Login</a>
        @endauth
    </div>
</div>

<script>
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(event) {
    const menu = document.getElementById('userMenu');
    const profile = document.querySelector('.user-profile');
    
    if (profile && !profile.contains(event.target)) {
        menu.style.display = 'none';
    }
});
</script>