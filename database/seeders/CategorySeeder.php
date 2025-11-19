<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use App\Models\TicketSubject;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            'System Access Issue' => [
                'Unable to Access Campus Portal',
                'Password Reset Request',
                'Two-Factor Authentication Issue',
                'Error While Logging In to the Student System',
            ],
            'Admissions' => [
                'Application for Admission Inquiry',
                'Status of Enrollment Application',
                'Request for Admission Requirements Assistance',
                'Updating Submitted Admission Documents',
            ],
            'Facility Maintenance Request' => [
                'Air Conditioning Issue in Room [Room Number]',
                'Broken Furniture in [Facility Name]',
                'Request for Electrical Maintenance',
                'Water Leak in [Building/Facility]',
                'Lighting Problem in [Location]',
            ],
            'Transcript of Records Request' => [
                'Request for Official Transcript of Records',
                'Inquiry About Transcript Processing Time',
                'Correction Needed in Transcript of Records',
                'Urgent Request for TOR for Job Application',
            ],
            'Scholarship Inquiry' => [
                'Application Status for [Scholarship Name]',
                'Scholarship Requirements Clarification',
                'Request for Scholarship Renewal',
                'Financial Aid Inquiry for the Upcoming Semester',
            ],
            'Event Participation Request' => [
                'Sign-Up for [Event Name]',
                'Request to Participate in [Event or Activity Name]',
                'Clarification on Event Participation Requirements',
                'Request for Event Registration Confirmation',
            ],
            'Tuition Fee Discrepancy' => [
                'Error in Tuition Fee Statement',
                'Overcharge on Tuition Fee',
                'Request for Tuition Fee Breakdown',
                'Discrepancy in Tuition Payment Record',
            ],
            'Uniform' => [
                'Request for Uniform Size Change',
                'Inquiry About Uniform Availability',
                'Order Replacement for Lost Uniform',
                'Request for Assistance with Uniform Fit Issues',
            ],
            'Capstone' => [
                'Approval Request for Capstone Project Title',
                'Inquiry About Capstone Proposal Requirements',
                'Request for Capstone Presentation Schedule',
                'Need Guidance on Capstone Documentation Format',
            ],
        ];

        foreach ($data as $categoryName => $subjects) {
            $category = TicketCategory::create([
                'name' => $categoryName,
            ]);

            foreach ($subjects as $subjectName) {
                TicketSubject::create([
                    'category_id' => $category->id,
                    'name' => $subjectName,
                ]);
            }
        }

        $this->command->info('Ticket categories and subjects have been seeded successfully.');
    }
}
