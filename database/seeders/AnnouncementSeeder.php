<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        // Create regular announcements
        $announcements = Announcement::factory()
            ->count(25)
            ->create();

        // Create some high priority announcements
        $highPriority = Announcement::factory()
            ->highPriority()
            ->count(5)
            ->create();

        // Create some scheduled announcements
        $scheduled = Announcement::factory()
            ->scheduled()
            ->count(8)
            ->create();

        // Create some inactive announcements
        $inactive = Announcement::factory()
            ->inactive()
            ->count(3)
            ->create();

        $totalAnnouncements = Announcement::count();
        $this->command->info('Announcements created successfully!');
        $this->command->info('Total announcements: ' . $totalAnnouncements);

        // Display announcement statistics
        $this->displayAnnouncementStats();
    }

    private function displayAnnouncementStats()
    {
        $stats = [
            'High Priority' => Announcement::where('priority', 'high')->count(),
            'Medium Priority' => Announcement::where('priority', 'medium')->count(),
            'Low Priority' => Announcement::where('priority', 'low')->count(),
            'Active' => Announcement::where('is_active', true)->count(),
            'Inactive' => Announcement::where('is_active', false)->count(),
            'Scheduled' => Announcement::whereNotNull('publish_at')->where('publish_at', '>', now())->count(),
        ];

        $this->command->info('Announcement Statistics:');
        foreach ($stats as $type => $count) {
            $this->command->info("  {$type}: {$count}");
        }
    }
}
