<!-- FOOTER -->
<footer style="background: linear-gradient(135deg, #0C3B2E 0%, #1a5a48 100%); color: white; padding: 3rem 5% 1.5rem; margin-top: 4rem;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <!-- Footer Main Content -->
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 3rem; padding-bottom: 2rem; border-bottom: 1px solid rgba(255, 255, 255, 0.2); margin-bottom: 2rem;">
            
            <!-- About Section -->
            <div>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; font-size: 1.3rem; font-weight: 700;">
                    <span>📚</span>
                    <span>PustakaOne</span>
                </div>
                <p style="font-size: 0.9rem; line-height: 1.7; opacity: 0.9; margin-bottom: 1.5rem;">
                    Your Gateway to Knowledge. Your trusted digital library platform providing seamless access to knowledge and literature.
                </p>
                <div style="display: flex; gap: 0.8rem;">
                    <a href="https://facebook.com" target="_blank" style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.background='#FFBA00'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)'">📘</a>
                    <a href="https://instagram.com" target="_blank" style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.background='#FFBA00'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)'">📷</a>
                    <a href="https://twitter.com" target="_blank" style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.background='#FFBA00'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)'">🐦</a>
                    <a href="https://linkedin.com" target="_blank" style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.2rem; transition: all 0.3s ease;" onmouseover="this.style.background='#FFBA00'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)'">💼</a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: #FFBA00;">Quick Links</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('about') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">About Us</a>
                    </li>
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('readspace') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">Browse Books</a>
                    </li>
                    @auth
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('reservation') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">My Reservations</a>
                    </li>
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('membership.index') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">Membership</a>
                    </li>
                    @else
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('login') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">Login</a>
                    </li>
                    <li style="margin-bottom: 0.8rem;">
                        <a href="{{ route('register') }}" style="color: white; text-decoration: none; font-size: 0.9rem; opacity: 0.9; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='#FFBA00'" onmouseout="this.style.opacity='0.9'; this.style.color='white'">Register</a>
                    </li>
                    @endauth
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: #FFBA00;">Contact</h4>
                <div style="font-size: 0.9rem; line-height: 1.8; opacity: 0.9;">
                    <p style="margin-bottom: 0.8rem;">📍 Jl. Taman Siswa No.02,<br>Semarang 50229, Indonesia</p>
                    <p style="margin-bottom: 0.8rem;">📞 <a href="tel:+622112345678" style="color: white; text-decoration: none;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='white'">+62 21 1234 5678</a></p>
                    <p style="margin-bottom: 0.8rem;">✉️ <a href="mailto:info@pustakaone.com" style="color: white; text-decoration: none;" onmouseover="this.style.color='#FFBA00'" onmouseout="this.style.color='white'">info@pustakaone.com</a></p>
                </div>
            </div>

            <!-- Operating Hours -->
            <div>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: #FFBA00;">Hours</h4>
                <div style="font-size: 0.9rem; line-height: 1.8; opacity: 0.9;">
                    <p style="margin-bottom: 0.5rem;">Mon - Fri: 08:00 - 20:00</p>
                    <p style="margin-bottom: 0.5rem;">Saturday: 10:00 - 16:00</p>
                    <p style="margin-bottom: 0.5rem;">Sunday: 10:00 - 16:00</p>
                    <p style="margin-bottom: 0.5rem;">Holidays: Closed</p>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div style="text-align: center; font-size: 0.9rem; opacity: 0.8;">
            <p>&copy; {{ date('Y') }} PustakaOne. All rights reserved. | Built with ❤️ for book lovers</p>
        </div>
    </div>
</footer>

<style>
@media (max-width: 768px) {
    footer > div > div:first-child {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
}
</style>