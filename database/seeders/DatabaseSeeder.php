<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@seineriverskidsteering.test'],
            [
                'name' => 'Admin',
                'password' => 'password',
            ]
        );

        SiteSetting::firstOrCreate([], [
            'business_name' => 'Seine River Skidsteering',
            'tagline' => 'Snow. Grading. Clearing. Site Work.',
            'about_text' => 'Seine River Skidsteering provides reliable, hard-working skid steer services for residential and commercial properties. From winter snow removal to land clearing and site prep, we show up on time and get the job done right.',
            'phone' => '(204) 555-0142',
            'email' => 'info@seineriverskidsteering.com',
            'service_area' => 'Serving Winnipeg & the Seine River Valley',
            'hours' => 'Mon-Sat, 7am-7pm',
        ]);

        collect([
            [
                'title' => 'Snow Removal',
                'slug' => 'snow',
                'icon' => 'snow',
                'summary' => 'Reliable residential and commercial snow clearing, all winter long.',
                'description' => 'Driveways, lots, and access roads cleared fast so you can get on with your day. Seasonal contracts and one-off calls both welcome.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Grading',
                'slug' => 'grading',
                'icon' => 'grading',
                'summary' => 'Precise leveling and grading for driveways, yards, and pads.',
                'description' => 'From rough grading to fine finish work, we prep the ground right the first time — for new builds, drainage fixes, or yard leveling.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Land Clearing',
                'slug' => 'clearing',
                'icon' => 'clearing',
                'summary' => 'Brush, tree, and debris clearing to open up your property.',
                'description' => 'We clear overgrown lots, fence lines, and building sites, hauling away debris so the land is ready for what\'s next.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Site Work',
                'slug' => 'site-work',
                'icon' => 'sitework',
                'summary' => 'General site prep and excavation support for builders and homeowners.',
                'description' => 'Trenching, backfill, material moving, and general site prep — we work alongside contractors and homeowners to keep projects on schedule.',
                'sort_order' => 4,
            ],
        ])->each(fn (array $service) => Service::firstOrCreate(['slug' => $service['slug']], $service));

        collect([
            [
                'customer_name' => 'Mike T.',
                'location' => 'Winnipeg, MB',
                'rating' => 5,
                'quote' => 'Showed up early after a big snowfall and had our lot cleared before opening. Been using them all season.',
                'sort_order' => 1,
            ],
            [
                'customer_name' => 'Sarah D.',
                'location' => 'St. Adolphe, MB',
                'rating' => 5,
                'quote' => 'Graded our whole yard after a drainage issue — professional, fast, and reasonably priced.',
                'sort_order' => 2,
            ],
            [
                'customer_name' => 'Dan R.',
                'location' => 'Niverville, MB',
                'rating' => 5,
                'quote' => 'Cleared two acres of overgrown brush for our new build. Hauled everything away, left the site spotless.',
                'sort_order' => 3,
            ],
        ])->each(fn (array $t) => Testimonial::firstOrCreate(
            ['customer_name' => $t['customer_name'], 'quote' => $t['quote']],
            $t
        ));
    }
}