<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    public function run()
    {
        $campaigns = [
            [
                'title' => 'Emergency Medical Aid for Gaza',
                'description' => 'Support immediate medical assistance and supplies for hospitals in Gaza. Every donation helps provide critical care to those in need.',
                'image_url' => 'https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?auto=format&fit=crop&q=80',
                'goal' => 100000.00,
                'current' => 35000.00,
                'gofundme_url' => 'https://example.com/medical-aid',
            ],
            [
                'title' => 'Food and Water Relief',
                'description' => 'Help deliver essential food and clean water supplies to Palestinian families. Your support ensures basic necessities reach those most affected.',
                'image_url' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&q=80',
                'goal' => 50000.00,
                'current' => 15000.00,
                'gofundme_url' => 'https://example.com/food-relief',
            ],
            [
                'title' => 'Children\'s Education Support',
                'description' => 'Support education initiatives for Palestinian children. Help provide school supplies, resources, and safe learning environments.',
                'image_url' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80',
                'goal' => 75000.00,
                'current' => 25000.00,
                'gofundme_url' => 'https://example.com/education',
            ],
        ];

        foreach ($campaigns as $campaign) {
            Campaign::create($campaign);
        }
    }
}
