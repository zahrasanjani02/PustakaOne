<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'The Snowball: Warren Buffett and the Business of Life',
                'author' => 'Alice Schroeder',
                'isbn' => '9780553805093',
                'publisher' => 'Bantam Books',
                'published_year' => '2008', 
                'category' => 'Biography',
                'description' => 'Born in Nebraska in 1930, Warren Buffett demonstrated keen business abilities at a young age. He formed Buffett Partnership Ltd in 1956 and his firm eventually acquired a textile manufacturing firm called Berkshire Hathaway.',
                'total_copies' => 5,
                'available_copies' => 5,
                'language' => 'English', 
                'location' => 'A-101', 
                'cover_image' => null,
            ],
            [
                'title' => 'Gandhi: An Autobiography - The Story of My Experiments with Truth',
                'author' => 'Mahatma Gandhi',
                'isbn' => '9780807059098',
                'publisher' => 'Beacon Press',
                'published_year' => '1957', 
                'category' => 'Biography',
                'description' => 'Born and raised in a Hindu merchant caste family in coastal Gujarat, India, and trained in law at the Inner Temple, London, Gandhi first employed nonviolent civil disobedience as an expatriate lawyer in South Africa.',
                'total_copies' => 4,
                'available_copies' => 3,
                'language' => 'English',
                'location' => 'A-102',
                'cover_image' => null,
            ],
            [
                'title' => 'Charlotte\'s Web',
                'author' => 'E. B. White',
                'isbn' => '9780064400558',
                'publisher' => 'Harper Collins',
                'published_year' => '1952', 
                'category' => 'Children',
                'description' => 'Charlotte\'s Web is a children\'s novel by American author E. B. White and illustrated by Garth Williams. It was published on October 15, 1952, by Harper & Brothers. The novel tells the story of a livestock pig named Wilbur.',
                'total_copies' => 8,
                'available_copies' => 6,
                'language' => 'English',
                'location' => 'B-201',
                'cover_image' => null,
            ],
            [
                'title' => 'The Dhoni Touch: Unravelling the Enigma',
                'author' => 'Bharat Sundaresan',
                'isbn' => '9789386224897',
                'publisher' => 'Penguin Random House',
                'published_year' => '2020', 
                'category' => 'Sports',
                'description' => 'For over a decade, Mahendra Singh Dhoni has captivated the world of cricket and over a billion Indians with his incredible ingenuity as captain, his wicketkeeping skills and his brilliance.',
                'total_copies' => 3,
                'available_copies' => 2,
                'language' => 'English',
                'location' => 'C-301',
                'cover_image' => null,
            ],
            [
                'title' => 'Sky Runner: Finding Strength, Happiness, and Balance',
                'author' => 'Emelie Forsberg',
                'isbn' => '9781937715502',
                'publisher' => 'VeloPress',
                'published_year' => '2016', 
                'category' => 'Sports',
                'description' => 'Emelie Forsberg is a renowned Sky runner recognised worldwide for her incredible strength, endurance and passion for movement in the mountains.',
                'total_copies' => 2,
                'available_copies' => 2,
                'language' => 'English',
                'location' => 'C-302',
                'cover_image' => null,
            ],
            [
                'title' => 'Long Walk to Freedom',
                'author' => 'Nelson Mandela',
                'isbn' => '9780316548182',
                'publisher' => 'Little Brown & Co',
                'published_year' => '1994', 
                'category' => 'Biography',
                'description' => 'Nelson Rolihlahla Mandela (18 July 1918 – 5 December 2013) was a South African politician and activist who served as the first president of South Africa from 1994 to 1999.',
                'total_copies' => 6,
                'available_copies' => 4,
                'language' => 'English',
                'location' => 'A-103',
                'cover_image' => null,
            ],
            [
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'publisher' => 'Prentice Hall',
                'published_year' => '2008', 
                'category' => 'Technology',
                'description' => 'Even bad code can function. But if code is not clean, it can bring a development organization to its knees. Every year, countless hours and significant resources are lost because of poorly written code.',
                'total_copies' => 7,
                'available_copies' => 5,
                'language' => 'English',
                'location' => 'D-401',
                'cover_image' => null,
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '9780735211292',
                'publisher' => 'Avery',
                'published_year' => '2018',
                'category' => 'Self-Help',
                'description' => 'No matter your goals, Atomic Habits offers a proven framework for improving every day. James Clear, one of the world\'s leading experts on habit formation, reveals practical strategies.',
                'total_copies' => 10,
                'available_copies' => 7,
                'language' => 'English',
                'location' => 'E-501',
                'cover_image' => null,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}