<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'enrollment process',
                'answer' => 'To enroll, log in to the student portal, go to Enrollment > Pre-registration, and follow the on-screen steps.',
                'created_at' => now(),
            ],
            [
                'question' => 'requirements for new students',
                'answer' => 'New students must submit Form 138, Certificate of Good Moral Character, Birth Certificate, and 2x2 ID pictures.',
                'created_at' => now(),
            ],
            [
                'question' => 'how to reset student portal password',
                'answer' => 'Visit the student portal login page and click “Forgot Password.” Enter your registered email to receive a reset link.',
                'created_at' => now(),
            ],
            [
                'question' => 'class schedule',
                'answer' => 'Class schedules are available in the student portal under Academics > Class Schedule.',
                'created_at' => now(),
            ],
            [
                'question' => 'grading system',
                'answer' => 'The university uses a grading scale from 1.00 (Excellent) to 5.00 (Failed). Minimum passing grade is 3.00.',
                'created_at' => now(),
            ],
            [
                'question' => 'how to request transcript of records',
                'answer' => 'To request your TOR, visit the Registrar’s Office or fill out the online request form on the official university website.',
                'created_at' => now(),
            ],
            [
                'question' => 'scholarship application',
                'answer' => 'Scholarship applications are handled by the Office of Student Affairs. Submit your requirements before the announced deadline.',
                'created_at' => now(),
            ],
            [
                'question' => 'how to change course or program',
                'answer' => 'To change your course, secure a shifting form from the Registrar, have it approved by your Dean, and submit it for processing.',
                'created_at' => now(),
            ],
            [
                'question' => 'how to access grades',
                'answer' => 'You can view your grades in the student portal under Academics > Grades once they are officially released.',
                'created_at' => now(),
            ],
            [
                'question' => 'graduation requirements',
                'answer' => 'To qualify for graduation, students must complete all academic requirements, clear all accounts, and apply for clearance.',
                'created_at' => now(),
            ],
        ];

        Faq::insert($faqs);

        $this->command->info(count($faqs).' FAQs added.');
    }
}
