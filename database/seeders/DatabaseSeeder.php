<?php

namespace Database\Seeders;

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
        // User Profile
        $user = User::updateOrCreate(
            ['email' => 'o.egberamen@alumni.uniben.edu'],
            [
                'name' => 'Osasere Egberamen',
                'degree' => 'Computer Science',
                'graduation_year' => '2014',
                'job_title' => 'Senior Product Designer',
                'company' => 'Paystack',
                'location' => 'Lagos, Nigeria',
                'linkedin_url' => 'linkedin.com/in/osasere',
                'alumni_id' => 'UNB-2014-8921',
                'membership_type' => 'Premium Life Member',
                'connections_count' => 540,
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        // News
        \App\Models\News::create([
            'title' => 'New ICT Hub Commissioned at Ugbowo Campus',
            'category' => 'CAMPUS UPDATE',
            'image_url' => null,
        ]);
        \App\Models\News::create([
            'title' => 'Faculty of Science Wins Global Research Grant',
            'category' => 'RESEARCH',
            'image_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        ]);

        // Events
        \App\Models\Event::create([
            'title' => 'Annual Alumni Dinner 2024',
            'event_month' => 'OCT',
            'event_day' => '24',
            'location_type' => 'Physical',
            'location_name' => 'Lagos Continental Hotel',
            'description' => 'Join us for a spectacular evening of networking and celebration.',
        ]);
        \App\Models\Event::create([
            'title' => 'Tech Founders Mixer',
            'event_month' => 'NOV',
            'event_day' => '12',
            'location_type' => 'Virtual',
            'location_name' => 'Virtual Event',
            'description' => 'A special mixer for tech entrepreneurs.',
        ]);

        // Job Postings
        \App\Models\JobPosting::create([
            'title' => 'Senior Product Designer',
            'company' => 'Flutterwave',
            'location' => 'Lagos, Nigeria',
            'type' => 'Full-time',
            'salary_range' => '₦1.2M - 1.8M',
            'logo_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDCrBDht2_yfdzjjkm0WZ0HtoIlJTAsBX1HZ3ju-xQA-6PxPY8mVTtzfRGN8DcDvGuEQGGXiYNggay0vZYjymF_QslAGBeul-uk6psV4hSHR_CH-kexkWLHZsD0JIkQZeNZ54tMLDBMKF6Ob_SEL7xqHOb0dpbS8mclxeDtuayd7m7kbsB9Vme1PJhh4eceQyad5kCI2dZhAajOT4sKZSPD405X8DgFyfeu79T_g2d0ef6UfnbUS9xTr6ntHDN9VcvgAdAl_6MWXfDK',
        ]);
        \App\Models\JobPosting::create([
            'title' => 'Software Engineer II',
            'company' => 'Microsoft',
            'location' => 'Remote',
            'type' => 'Contract',
            'salary_range' => null,
            'logo_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBfzFaz_RNaf0vDdiYWWcDBShdyIklZhJpZlUQMtEHE9JkCL_7UzrvtJqcLYs6o5UmysoozSAoachnCm-5dtuWL4Me0FNyc6-Guk62ICKjfrwM2RLUQNXBT4ARNwwGArZ6n_XVJc4mIG9CxDLw77L8Fhy2uLwbBh0CXtHxBX1bG3roaYgKng4QvyQD492gIsU65lQSGKMHh-Mmccf3woBhzKgYaA5m8rwR8ThG2xpiw_Y9Do9jPE8hVPRR88CE4P7E0VzmNGBNtbt_G',
        ]);
        \App\Models\JobPosting::create([
            'title' => 'Operations Manager',
            'company' => 'Dangote Group',
            'location' => 'Benin City, Nigeria',
            'type' => 'Full-time',
            'salary_range' => null,
            'logo_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB-0qkfnhiX-4VTLDlKmdWZWxxN7W8SIdHa6ODFG3r7-Yd1esZmMIpXnOMrYK32SiEQxeMM_cWyug4kS6wCEmV3as3ICzYZ-lumjUQXsPztIlVDDhzjAHxXyx7xfteyZUnJHx3MwLgnK1WluU3vhxSififq1As98SlJKFsN-4Lgrbag9si23HJmuMgpyFudA9ZnqU7z84jxBuYGrlGAvmLfh7oUE6_dsXtKF6BuPOi05YiV1Yg7ye0seARHHktmjFimKvhKTEA6MvOU',
        ]);

        // Products (Shop)
        \App\Models\Product::create([
            'title' => 'Premium Alumni Leather Jacket',
            'price' => 45000,
            'category' => 'Apparel',
            'badge' => 'Limited',
            'is_spotlight' => true,
        ]);
        \App\Models\Product::create([
            'title' => 'Classic Polo Shirt',
            'price' => 12500,
            'category' => 'Apparel',
        ]);
        \App\Models\Product::create([
            'title' => 'UNIBEN Coffee Mug',
            'price' => 4500,
            'category' => 'Accessories',
            'badge' => 'Best Seller',
        ]);
        \App\Models\Product::create([
            'title' => 'Leather Wallet',
            'price' => 15000,
            'category' => 'Accessories',
            'badge' => 'New',
        ]);

        // Payments
        \App\Models\Payment::create([
            'user_id' => $user->id,
            'reference' => 'TXN-A8G9-2023',
            'description' => 'Annual Alumni Dues 2023',
            'amount' => 15000,
            'status' => 'Paid'
        ]);
        \App\Models\Payment::create([
            'user_id' => $user->id,
            'reference' => 'TXN-Z5Q1-2024',
            'description' => 'UNIBEN Leather Jacket (Shop)',
            'amount' => 45000,
            'status' => 'Paid'
        ]);

        // Specific User Fix
        User::updateOrCreate(
            ['email' => '9jabaymall@gmail.com'],
            [
                'name' => 'Ajayi O. Martins',
                'password' => \Illuminate\Support\Facades\Hash::make('Seeme123#'),
                'degree' => 'Management Science',
                'graduation_year' => '2016',
                'job_title' => 'Software Engineer',
                'company' => 'UNIBEN',
                'location' => 'Benin City, Nigeria',
                'membership_type' => 'Premium Life Member',
                'connections_count' => 120,
            ]
        );
    }
}
