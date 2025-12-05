<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function index()
    {
        // Public About Us page
        // Di production, data ini akan diambil dari database
        // Untuk sekarang kita hardcode dulu
        
        $data = [
            'library_name' => 'PustakaOne Digital Library',
            'tagline' => 'Your Gateway to Knowledge',
            'established_year' => 2020,
            'short_description' => 'PustakaOne is a modern digital library platform dedicated to providing seamless access to knowledge and literature. Founded in 2020, we strive to bridge the gap between traditional library services and cutting-edge technology.',
            'full_description' => 'Our mission is to revolutionize how people access and engage with books and educational resources. With over 50,000 titles and growing, we serve a community of passionate readers and learners. We believe in the power of knowledge to transform lives.',
            
            'statistics' => [
                'total_books' => 50000,
                'active_members' => 12500,
                'books_borrowed' => 250000,
                'years_of_service' => 4,
            ],
            
            'mission' => 'To democratize access to knowledge and foster a love of reading by providing innovative library services that meet the evolving needs of our diverse community.',
            
            'vision' => 'To be the leading digital library platform that inspires lifelong learning and connects people with the transformative power of literature.',
            
            'values' => [
                [
                    'icon' => '📚',
                    'title' => 'Knowledge Access',
                    'description' => 'We believe everyone deserves equal access to quality information and educational resources, regardless of their background or location.'
                ],
                [
                    'icon' => '🚀',
                    'title' => 'Innovation',
                    'description' => 'We continuously embrace new technologies and methods to enhance the library experience and stay ahead of changing user needs.'
                ],
                [
                    'icon' => '🤝',
                    'title' => 'Community Focus',
                    'description' => 'We foster a vibrant community of readers and learners, creating spaces for connection, collaboration, and shared discovery.'
                ],
                [
                    'icon' => '✨',
                    'title' => 'Excellence',
                    'description' => 'We are committed to providing exceptional service, carefully curated collections, and reliable support to every member.'
                ],
                [
                    'icon' => '🌱',
                    'title' => 'Sustainability',
                    'description' => 'We promote sustainable practices through digital solutions, reducing environmental impact while expanding access to resources.'
                ],
            ],
            
            'contact' => [
                'address' => 'Jl. Pendidikan No. 123, Jakarta 12345, Indonesia',
                'phone' => '+62 21 1234 5678',
                'whatsapp' => '+62 812 3456 7890',
                'email' => 'info@pustakaone.com',
                'support_email' => 'support@pustakaone.com',
            ],
            
            'operating_hours' => [
                'weekdays' => 'Monday - Friday: 08:00 - 20:00',
                'saturday' => 'Saturday: 09:00 - 17:00',
                'sunday' => 'Sunday: 10:00 - 16:00',
                'holidays' => 'Public Holidays: Closed',
            ],
            
            'social_media' => [
                'facebook' => 'https://facebook.com/pustakaone',
                'instagram' => 'https://instagram.com/pustakaone',
                'twitter' => 'https://twitter.com/pustakaone',
                'linkedin' => 'https://linkedin.com/company/pustakaone',
            ],
        ];
        
        return view('About.about', compact('data'));
    }
    
    public function edit()
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        // Same data as index untuk form editing
        $data = [
            'library_name' => 'PustakaOne Digital Library',
            'tagline' => 'Your Gateway to Knowledge',
            'established_year' => 2020,
            // ... (sama seperti di atas)
        ];
        
        return view('About.edit', compact('data'));
    }
}