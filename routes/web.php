<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    $news = \App\Models\News::latest()->take(3)->get();
    $events = \App\Models\Event::latest()->take(3)->get();
    $executives = \App\Models\User::whereIn('role', ['chairman', 'vice_chairman', 'secretary', 'legal', 'welfare', 'pro', 'pro_ii'])
        ->orderByRaw("FIELD(role, 'chairman', 'vice_chairman', 'secretary', 'legal', 'welfare', 'pro', 'pro_ii')")
        ->get();
    $gallery = \App\Models\Gallery::latest()->take(5)->get();
    $jobs = \App\Models\JobPosting::where('status', 'approved')->latest()->take(5)->get();
    $products = \App\Models\Product::inRandomOrder()->take(5)->get();
    $cooperative = \App\Models\CooperativeSetting::first();
    return view('home', compact('news', 'events', 'executives', 'gallery', 'jobs', 'products', 'cooperative'));
})->name('home');

Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
Route::get('/membership', function () {
    return view('membership');
})->name('membership');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
    Route::get('/signup/verify', [AuthController::class, 'showVerifyOtp'])->name('signup.verify');
    Route::post('/signup/verify', [AuthController::class, 'verifyOtp'])->name('signup.verify.post');
    Route::post('/signup/resend-otp', [AuthController::class, 'resendOtp'])->name('signup.resend_otp');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password.post');
});

Route::get('/gallery', function () {
    $images = \App\Models\Gallery::latest()->get();
    return view('gallery', compact('images'));
})->name('gallery');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        $news = \App\Models\News::latest()->take(3)->get();
        $events = \App\Models\Event::latest()->take(2)->get();
        $jobs = \App\Models\JobPosting::latest()->take(2)->get();
        
        // Personality of the week: Random active user with bio and avatar
        $personality = \App\Models\User::whereNotNull('bio')
            ->whereNotNull('avatar_url')
            ->inRandomOrder()
            ->first();
            
        // Birthday Celebrants of the week
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        
        $celebrants = \App\Models\User::whereNotNull('date_of_birth')
            ->whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN ? AND ?", [
                $startOfWeek->format('m-d'),
                $endOfWeek->format('m-d')
            ])
            ->get();

        $projects = \App\Models\DonationProject::where('is_active', true)->latest()->take(2)->get();
        return view('dashboard', compact('news', 'events', 'jobs', 'personality', 'celebrants', 'projects'));
    })->name('dashboard');
    
    Route::get('/profile', function () {
        $user = auth()->user();
        
        $connectionsCount = \App\Models\Connection::where(function($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('connected_user_id', $user->id);
        })->where('status', 'accepted')->count();
        
        $eventsCount = \App\Models\Payment::where('user_id', $user->id)
            ->where(function($q) {
                $q->where('description', 'like', '%Event%')
                  ->orWhere('description', 'like', '%Ticket%');
            })
            ->where('status', 'Paid')
            ->count();
            
        $minGradYear = $user->degrees()->min('graduation_year') ?? $user->graduation_year ?? date('Y');
        $yearsActive = max(1, date('Y') - (int)$minGradYear);
        
        return view('profile', compact('connectionsCount', 'eventsCount', 'yearsActive', 'user'));
    })->name('profile');

    Route::get('/profile/edit', function () {
        return view('profile-edit');
    })->name('profile.edit');

    Route::post('/profile/edit', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        
        $request->validate([
            'title' => 'required|string|max:10',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'job_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'matric_number' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'bio' => 'nullable|string',
            'linkedin_url' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:5120',
            'degrees' => 'nullable|array',
        ]);

        $data = $request->except(['_token', 'avatar', 'degrees']);
        $user->fill($data);
        
        // Update composite name for legacy support
        $user->name = trim("{$user->first_name} {$user->middle_name} {$user->last_name}");

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $fileName = 'avatars/' . uniqid() . '.webp';
            $path = storage_path('app/public/' . $fileName);
            @mkdir(dirname($path), 0755, true);
            
            $imgString = file_get_contents($image->getRealPath());
            $imgResource = imagecreatefromstring($imgString);
            if ($imgResource !== false) {
                // Ensure truecolor
                if (!imageistruecolor($imgResource)) {
                    $trueColor = imagecreatetruecolor(imagesx($imgResource), imagesy($imgResource));
                    imagecopy($trueColor, $imgResource, 0, 0, 0, 0, imagesx($imgResource), imagesy($imgResource));
                    imagedestroy($imgResource);
                    $imgResource = $trueColor;
                }
                imagewebp($imgResource, $path, 80);
                imagedestroy($imgResource);
                $user->avatar_url = 'storage/' . $fileName;
            }
        }
        $user->save();

        // Handle degrees
        if ($request->has('degrees') && is_array($request->degrees)) {
            $user->degrees()->delete(); // Clear existing
            foreach ($request->degrees as $deg) {
                if (!empty($deg['degree_type']) && !empty($deg['course'])) {
                    $user->degrees()->create([
                        'degree_type' => $deg['degree_type'],
                        'course' => $deg['course'],
                        'department' => $deg['department'] ?? '',
                        'graduation_year' => $deg['graduation_year'] ?? '',
                    ]);
                }
            }
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    })->name('profile.update');

    Route::post('/profile/notifications', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        $user->receive_notifications = $request->has('receive_notifications');
        $user->save();
        return back()->with('success', 'Notification preferences updated!');
    })->name('profile.notifications');

    Route::post('/profile/password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully.');
    })->name('profile.password');

    Route::get('/events', function () {
        $events = \App\Models\Event::latest()->get();
        return view('events', compact('events'));
    })->name('events');

    Route::get('/directory', function (\Illuminate\Http\Request $request) {
        $query = \App\Models\User::where('id', '!=', auth()->id());
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('degree', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('job_title', 'like', "%{$search}%");
            });
        }
        $users = $query->get();
        
        // Payment logic to check if they have fully paid dues for the year
        $currentYear = date('Y');
        $duesPaidThisYear = \App\Models\Payment::where('user_id', auth()->id())
            ->where('description', 'like', '%Dues%')
            ->whereYear('created_at', $currentYear)
            ->whereIn('status', ['Paid', 'successful', 'success', 'completed'])
            ->sum('amount');
        $totalDues = 25000;
        $isFullyPaid = $duesPaidThisYear >= $totalDues;

        // Get Connections for Auth user
        $myConnections = \App\Models\Connection::where('user_id', auth()->id())->get()->keyBy('connected_user_id');
        $theirConnections = \App\Models\Connection::where('connected_user_id', auth()->id())->get()->keyBy('user_id');

        return view('directory', compact('users', 'isFullyPaid', 'myConnections', 'theirConnections', 'request'));
    })->name('directory');

    Route::post('/directory/connect', function (\Illuminate\Http\Request $request) {
        $request->validate(['user_id' => 'required|exists:users,id']);
        
        $targetUser = \App\Models\User::find($request->user_id);
        $authUser = auth()->user();

        $connection = \App\Models\Connection::firstOrCreate([
            'user_id' => $authUser->id,
            'connected_user_id' => $targetUser->id
        ], [
            'status' => 'pending'
        ]);

        // If it was just created, notify the target user
        if ($connection->wasRecentlyCreated) {
            $targetUser->notify(new \App\Notifications\ConnectionRequest($authUser));
        }
        
        $reverseConnection = \App\Models\Connection::where('user_id', $targetUser->id)
            ->where('connected_user_id', $authUser->id)
            ->first();
            
        if ($reverseConnection && $reverseConnection->status !== 'accepted') {
            $reverseConnection->update(['status' => 'accepted']);
            $connection->update(['status' => 'accepted']);

            // Notify the user who originally sent the request that it's been accepted
            $targetUser->notify(new \App\Notifications\ConnectionAccepted($authUser));
        }
        
        return back()->with('success', 'Connection process initiated!');
    })->name('directory.connect');


    Route::get('/payments', function () {
        $payments = \App\Models\Payment::where('user_id', auth()->id())->latest()->take(5)->get();
        
        $currentYear = date('Y');
        // Calculate total dues paid in the current year
        $duesPaidThisYear = \App\Models\Payment::where('user_id', auth()->id())
            ->where('description', 'like', '%Dues%')
            ->whereYear('created_at', $currentYear)
            ->whereIn('status', ['Paid', 'successful', 'success', 'completed'])
            ->sum('amount');
            
        $totalDues = 25000;
        $remainingDues = max(0, $totalDues - $duesPaidThisYear);

        return view('payments', compact('payments', 'currentYear', 'duesPaidThisYear', 'totalDues', 'remainingDues'));
    })->name('payments');

    Route::post('/payment/record', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'amount' => 'required|numeric',
            'reference' => 'required|string',
            'description' => 'required|string',
        ]);

        \App\Models\Payment::create([
            'user_id' => auth()->id(),
            'reference' => $request->reference,
            'description' => $request->description,
            'amount' => $request->amount,
            'status' => 'Paid'
        ]);

        // If it's a donation, update raising amount on the project if applicable
        if (str_contains(strtolower($request->description), 'donation') || str_contains(strtolower($request->description), 'project')) {
            $parts = explode(':', $request->description);
            if (count($parts) > 1) {
                $projectTitle = trim($parts[1]);
                $project = \App\Models\DonationProject::where('title', $projectTitle)->first();
                if ($project) {
                    $project->increment('raised_amount', $request->amount);
                }
            }
        }

        return response()->json(['success' => true]);
    })->name('payment.record');

    Route::get('/transactions', function () {
        $payments = \App\Models\Payment::where('user_id', auth()->id())->latest()->get();
        return view('transactions', compact('payments'));
    })->name('transactions');

    Route::get('/shop/all', function () {
        $products = \App\Models\Product::all();
        return view('shop-all', compact('products'));
    })->name('shop.all');

    Route::get('/shop', function () {
        $products = \App\Models\Product::all();
        return view('shop', compact('products'));
    })->name('shop');

    Route::post('/shop/checkout', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'amount' => 'required|numeric',
            'reference' => 'required|string',
            'items' => 'required|string',
            'delivery_mode' => 'required|string',
            'delivery_address' => 'nullable|string',
            'delivery_phone' => 'nullable|string'
        ]);

        $description = 'Shop Purchase: ' . $request->items . ' | Delivery: ' . $request->delivery_mode;
        if ($request->delivery_mode == 'home' && $request->delivery_address) {
            $description .= ' (' . $request->delivery_address . ') Phone: ' . $request->delivery_phone;
        }

        \App\Models\Payment::create([
            'user_id' => auth()->id(),
            'reference' => $request->reference,
            'description' => substr($description, 0, 255),
            'amount' => $request->amount,
            'status' => 'Paid'
        ]);

        \App\Models\Order::create([
            'user_id' => auth()->id(),
            'items' => $request->items,
            'total_amount' => $request->amount,
            'reference' => $request->reference,
            'delivery_mode' => $request->delivery_mode,
            'delivery_address' => $request->delivery_address,
            'delivery_phone' => $request->delivery_phone,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true]);
    })->name('shop.checkout');

    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications()->latest()->paginate(15);
        auth()->user()->unreadNotifications->markAsRead();
        return view('notifications', compact('notifications'));
    })->name('notifications');

    Route::get('/donate', function () {
        $recentDonors = \App\Models\Payment::with('user')
            ->where(function($q) {
                $q->where('description', 'like', '%Donation%')
                  ->orWhere('description', 'like', '%Project%');
            })
            ->whereIn('status', ['Paid', 'successful', 'success', 'completed'])
            ->latest()
            ->take(5)
            ->get();
            
        $projects = \App\Models\DonationProject::where('is_active', true)->latest()->get();
            
        return view('donate', compact('recentDonors', 'projects'));
    })->name('donate');

    // Events Detail Route
    Route::get('/events-detail/{event}', function (\App\Models\Event $event) {
        return view('event-detail', compact('event'));
    })->name('events.detail');

    Route::post('/events-detail/{event}/rsvp', function (\Illuminate\Http\Request $request, \App\Models\Event $event) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $reservation = \App\Models\EventReservation::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'amount' => $event->fee ?? 0,
            'status' => 'confirmed',
            'payment_method' => $event->fee > 0 ? 'payment_gateway' : 'free',
        ]);

        if ($event->fee > 0) {
            \App\Models\Payment::create([
                'user_id' => auth()->id(),
                'reference' => $request->payment_reference ?? ('EVT_' . time() . '_' . $reservation->id),
                'description' => 'Event Ticket: ' . $event->title,
                'amount' => $event->fee,
                'status' => 'Paid'
            ]);
        }

        \Illuminate\Support\Facades\Mail::to($request->email)->send(new \App\Mail\EventReservationMail($reservation, $event));

        return redirect()->route('events.detail', $event->id)->with('success', 'Your seat has been reserved successfully! An email confirmation has been sent to you.');
    })->name('events.rsvp');

    // Jobs Routes
    Route::get('/jobs/create', function () {
        return view('job-create');
    })->name('jobs.create');

    Route::post('/jobs/store', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'salary_range' => 'nullable|string|max:255',
            'environment' => 'required|string',
            'logo_url' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
        ]);

        $data = $request->except(['logo_url', '_token']);
        
        if ($request->hasFile('logo_url')) {
            $path = $request->file('logo_url')->store('job-logos', 'public');
            $data['logo_url'] = '/storage/' . $path;
        }

        $data['is_current_employee'] = $request->has('is_current_employee');
        $data['user_id'] = auth()->id();
        
        $isAdmin = auth()->user() && in_array(auth()->user()->role, ['admin', 'chairman']);
        $data['status'] = $isAdmin ? 'approved' : 'pending';

        $job = \App\Models\JobPosting::create($data);

        if (!$isAdmin) {
            $admins = \App\Models\User::whereIn('role', ['admin', 'chairman'])->get();
            foreach($admins as $admin) {
                \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\JobPendingApprovalMail($job));
            }
            return redirect()->route('jobs')->with('success', 'Job submitted successfully and is waiting for admin approval!');
        } else {
            $users = \App\Models\User::all();
            foreach($users as $user) {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\JobPostedMail($job));
            }
            return redirect()->route('jobs')->with('success', 'Job posted successfully and notification sent to all users!');
        }
    })->name('jobs.store');

    Route::get('/jobs', function () {
        $jobs = \App\Models\JobPosting::where('status', 'approved')->latest()->get();
        return view('jobs', compact('jobs'));
    })->name('jobs');

    Route::get('/jobs/{job}', function (\App\Models\JobPosting $job) {
        return view('job-details', compact('job'));
    })->name('jobs.show');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
});

Route::prefix('admin')->middleware(['web', 'admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    
    // Users
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    
    // Executives
    Route::get('/executives', [\App\Http\Controllers\AdminController::class, 'executives'])->name('admin.executives');
    Route::get('/executives/create', [\App\Http\Controllers\AdminController::class, 'createExecutive'])->name('admin.executives.create');
    Route::post('/executives/create', [\App\Http\Controllers\AdminController::class, 'storeExecutive'])->name('admin.executives.store');
    
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/events', [\App\Http\Controllers\AdminController::class, 'events'])->name('admin.events');
    Route::get('/events/create', [\App\Http\Controllers\AdminController::class, 'createEvent'])->name('admin.events.create');
    Route::post('/events/create', [\App\Http\Controllers\AdminController::class, 'storeEvent'])->name('admin.events.store');
    Route::get('/events/{event}/edit', [\App\Http\Controllers\AdminController::class, 'editEvent'])->name('admin.events.edit');
    Route::post('/events/{event}/edit', [\App\Http\Controllers\AdminController::class, 'updateEvent'])->name('admin.events.update');
    Route::delete('/events/{event}', [\App\Http\Controllers\AdminController::class, 'deleteEvent'])->name('admin.events.delete');
    Route::get('/events/{event}/reservations', [\App\Http\Controllers\AdminController::class, 'eventReservations'])->name('admin.events.reservations');
    
    Route::get('/reservations', [\App\Http\Controllers\AdminController::class, 'allReservations'])->name('admin.reservations');

    Route::get('/jobs', [\App\Http\Controllers\AdminController::class, 'jobs'])->name('admin.jobs');
    Route::get('/jobs/create', [\App\Http\Controllers\AdminController::class, 'createJob'])->name('admin.jobs.create');
    Route::post('/jobs/{job}/approve', [\App\Http\Controllers\AdminController::class, 'approveJob'])->name('admin.jobs.approve');
    Route::post('/jobs/{job}/reject', [\App\Http\Controllers\AdminController::class, 'rejectJob'])->name('admin.jobs.reject');
    Route::delete('/jobs/{job}', [\App\Http\Controllers\AdminController::class, 'deleteJob'])->name('admin.jobs.delete');
    // News
    Route::get('/news', [\App\Http\Controllers\AdminController::class, 'news'])->name('admin.news');
    Route::get('/news/create', [\App\Http\Controllers\AdminController::class, 'createNews'])->name('admin.news.create');
    Route::post('/news/create', [\App\Http\Controllers\AdminController::class, 'storeNews'])->name('admin.news.store');
    Route::get('/news/{news}/edit', [\App\Http\Controllers\AdminController::class, 'editNews'])->name('admin.news.edit');
    Route::post('/news/{news}/edit', [\App\Http\Controllers\AdminController::class, 'updateNews'])->name('admin.news.update');
    Route::delete('/news/{news}', [\App\Http\Controllers\AdminController::class, 'deleteNews'])->name('admin.news.delete');

    Route::get('/products', [\App\Http\Controllers\AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [\App\Http\Controllers\AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products/store', [\App\Http\Controllers\AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [\App\Http\Controllers\AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::post('/products/{product}/edit', [\App\Http\Controllers\AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{product}', [\App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('admin.products.delete');

    Route::get('/orders', [\App\Http\Controllers\AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');

    Route::get('/payments', [\App\Http\Controllers\AdminController::class, 'payments'])->name('admin.payments');

    Route::get('/donations', [\App\Http\Controllers\AdminController::class, 'donationProjects'])->name('admin.donations');
    Route::get('/donations/create', [\App\Http\Controllers\AdminController::class, 'createDonationProject'])->name('admin.donations.create');
    Route::post('/donations/create', [\App\Http\Controllers\AdminController::class, 'storeDonationProject'])->name('admin.donations.store');
    Route::get('/donations/{project}/edit', [\App\Http\Controllers\AdminController::class, 'editDonationProject'])->name('admin.donations.edit');
    Route::post('/donations/{project}/edit', [\App\Http\Controllers\AdminController::class, 'updateDonationProject'])->name('admin.donations.update');
    Route::delete('/donations/{project}', [\App\Http\Controllers\AdminController::class, 'deleteDonationProject'])->name('admin.donations.delete');

    Route::get('/gallery', [\App\Http\Controllers\AdminController::class, 'gallery'])->name('admin.gallery');
    Route::post('/gallery', [\App\Http\Controllers\AdminController::class, 'storeGallery'])->name('admin.gallery.store');
    Route::delete('/gallery/{image}', [\App\Http\Controllers\AdminController::class, 'deleteGallery'])->name('admin.gallery.delete');

    Route::get('/cooperative', [\App\Http\Controllers\AdminController::class, 'cooperative'])->name('admin.cooperative');
    Route::post('/cooperative', [\App\Http\Controllers\AdminController::class, 'updateCooperative'])->name('admin.cooperative.update');
    Route::post('/cooperative/gallery-delete', [\App\Http\Controllers\AdminController::class, 'deleteCooperativeGalleryImage'])->name('admin.cooperative.gallery.delete');
    Route::get('/cooperative/applications', [\App\Http\Controllers\AdminController::class, 'cooperativeApplications'])->name('admin.cooperative.applications');
    Route::post('/cooperative/applications/{application}/status', [\App\Http\Controllers\AdminController::class, 'updateApplicationStatus'])->name('admin.cooperative.applications.status');

    // Birthday Emails
    Route::post('/users/{user}/birthday-email', [\App\Http\Controllers\AdminController::class, 'sendBirthdayEmail'])->name('admin.users.birthday-email');
    Route::post('/users/birthday-emails/send-all', [\App\Http\Controllers\AdminController::class, 'sendAllBirthdayEmails'])->name('admin.users.birthday-emails-all');

    // Email Broadcasts
    Route::get('/broadcasts', [\App\Http\Controllers\AdminController::class, 'broadcasts'])->name('admin.broadcasts');
    Route::get('/broadcasts/create', [\App\Http\Controllers\AdminController::class, 'createBroadcast'])->name('admin.broadcasts.create');
    Route::post('/broadcasts/send', [\App\Http\Controllers\AdminController::class, 'sendBroadcast'])->name('admin.broadcasts.send');
});

Route::get('/cooperative', function() {
    $setting = \App\Models\CooperativeSetting::first();
    return view('cooperative', compact('setting'));
})->name('cooperative');

// Cooperative Application (Public form submission)
Route::post('/cooperative/apply', function(\Illuminate\Http\Request $request) {
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'occupation' => 'nullable|string|max:255',
        'matric_number' => 'nullable|string|max:50',
        'graduation_year' => 'nullable|string|max:10',
        'address' => 'nullable|string',
        'reason' => 'nullable|string',
    ]);

    \App\Models\CooperativeApplication::create($request->all());

    return redirect()->route('cooperative')->with('success', 'Your application has been submitted successfully! Our cooperative secretary will contact you soon.');
})->name('cooperative.apply');
