<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    public function definition()
    {
        $titles = [
            'Important Academic Calendar Update',
            'New Library Resources Available',
            'Campus Maintenance Schedule',
            'Scholarship Opportunities',
            'Career Fair Announcement',
            'Holiday Schedule',
            'Registration Deadline Reminder',
            'New Course Offerings',
            'Research Symposium',
            'Student Organization Meeting',
            'Graduation Requirements Update',
            'Internship Opportunities',
            'Faculty Development Program',
            'Campus Safety Guidelines',
            'Academic Excellence Awards',
        ];

        $priorities = ['low', 'medium', 'high'];

        $content = [
            'This is to inform all students about important updates regarding the academic calendar. Please make sure to check the new schedule.',
            'We are excited to announce new resources available in the library. Students can now access additional online journals and databases.',
            'There will be scheduled maintenance across campus during the upcoming weekend. Some facilities may be temporarily unavailable.',
            'Several scholarship opportunities are now open for application. Eligible students are encouraged to apply before the deadline.',
            'The annual career fair will be held next month. Many reputable companies will be participating. Prepare your resumes!',
            'Please be informed of the updated holiday schedule for the current semester. Classes will resume as per the academic calendar.',
            'This is a reminder about the upcoming registration deadline. Late registrations will incur additional fees.',
            'We are pleased to announce new course offerings for the next academic year. Check the course catalog for more details.',
            'The annual research symposium will showcase student and faculty research projects. All are welcome to attend.',
            'There will be a general meeting for all student organizations next week. Attendance is mandatory for organization leaders.',
        ];

        $admin = User::where('role', 'admin')->first();

        return [
            'title' => $this->faker->randomElement($titles),
            'content' => $this->faker->randomElement($content) . ' ' . $this->faker->paragraph(2),
            'priority' => $this->faker->randomElement($priorities),
            'created_by' => $admin ? $admin->id : User::factory()->admin(),
            'is_active' => $this->faker->boolean(85), // 85% active
            'publish_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 month', '+1 month'), // 70% have publish date
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function highPriority()
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => 'high',
            ];
        });
    }

    public function mediumPriority()
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => 'medium',
            ];
        });
    }

    public function lowPriority()
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => 'low',
            ];
        });
    }

    public function scheduled()
    {
        return $this->state(function (array $attributes) {
            return [
                'publish_at' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}
