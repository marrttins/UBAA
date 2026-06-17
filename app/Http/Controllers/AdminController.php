<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobPosting;
use App\Models\Event;
use App\Models\News;
use App\Models\Product;
use App\Models\Payment;
use App\Models\EmailBroadcast;
use App\Models\CooperativeApplication;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'jobs' => JobPosting::count(),
            'events' => Event::count(),
            'news' => News::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (in_array($user->role, ['admin', 'chairman', 'secretary', 'pro'])) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have administrative privileges.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function users()
    {
        $users = User::where('role', 'user')->latest()->paginate(15);
        
        // Find today's birthday celebrants
        $todayCelebrants = User::whereNotNull('date_of_birth')
            ->whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') = ?", [now()->format('m-d')])
            ->get();
        
        // Also get this week's celebrants
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $weekCelebrants = User::whereNotNull('date_of_birth')
            ->whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN ? AND ?", [
                $startOfWeek->format('m-d'),
                $endOfWeek->format('m-d')
            ])
            ->get();
        
        return view('admin.users.index', compact('users', 'todayCelebrants', 'weekCelebrants'));
    }

    public function sendBirthdayEmail(User $user)
    {
        // Send birthday email to the user
        Mail::to($user->email)->send(new \App\Mail\BirthdayGreetingMail($user));
        
        return redirect()->route('admin.users')->with('success', 'Birthday greeting email sent to ' . $user->name . ' successfully!');
    }

    public function sendAllBirthdayEmails()
    {
        $todayCelebrants = User::whereNotNull('date_of_birth')
            ->whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') = ?", [now()->format('m-d')])
            ->get();

        $count = 0;
        foreach ($todayCelebrants as $celebrant) {
            Mail::to($celebrant->email)->send(new \App\Mail\BirthdayGreetingMail($celebrant));
            $count++;
        }

        return redirect()->route('admin.users')->with('success', "Birthday greeting emails sent to {$count} celebrant(s) successfully!");
    }

    // === Email Broadcast ===
    public function broadcasts()
    {
        $broadcasts = EmailBroadcast::with('sender')->latest()->paginate(15);
        return view('admin.broadcasts.index', compact('broadcasts'));
    }

    public function createBroadcast()
    {
        $users = User::orderBy('name')->get();
        return view('admin.broadcasts.create', compact('users'));
    }

    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'recipient_type' => 'required|in:all,selected',
            'recipient_ids' => 'required_if:recipient_type,selected|array',
        ]);

        if ($request->recipient_type === 'all') {
            $recipients = User::all();
        } else {
            $recipients = User::whereIn('id', $request->recipient_ids ?? [])->get();
        }

        $count = 0;
        foreach ($recipients as $user) {
            Mail::to($user->email)->send(new \App\Mail\BroadcastMail(
                $request->subject,
                $request->message,
                $user->first_name ?? $user->name
            ));
            $count++;
        }

        EmailBroadcast::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'recipient_type' => $request->recipient_type,
            'recipient_ids' => $request->recipient_type === 'selected' ? $request->recipient_ids : null,
            'total_sent' => $count,
            'sent_by' => auth()->id(),
            'sent_at' => now(),
        ]);

        return redirect()->route('admin.broadcasts')->with('success', "Broadcast email sent to {$count} recipient(s) successfully!");
    }

    // === Cooperative Applications ===
    public function cooperativeApplications()
    {
        $applications = CooperativeApplication::latest()->paginate(15);
        return view('admin.cooperative.applications', compact('applications'));
    }

    public function updateApplicationStatus(Request $request, CooperativeApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.cooperative.applications')->with('success', 'Application status updated successfully.');
    }

    public function executives()
    {
        $users = User::where('role', '!=', 'user')->latest()->paginate(15);
        return view('admin.executives.index', compact('users'));
    }

    public function createExecutive()
    {
        $regularUsers = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.executives.create', compact('regularUsers'));
    }

    public function storeExecutive(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string',
            'custom_role' => 'required_if:role,custom|nullable|string|min:3|max:255',
        ]);

        $user = User::findOrFail($request->user_id);
        
        $role = $request->role;
        if ($role === 'custom') {
            $role = \Illuminate\Support\Str::slug($request->custom_role, '_');
        }

        $user->update([
            'role' => $role,
        ]);

        return redirect()->route('admin.executives')->with('success', 'Executive role assigned successfully');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|string|max:255',
            'title' => 'nullable|string|max:20',
            'middle_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'matric_number' => 'nullable|string|max:50',
            'degree' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|integer|min:1900|max:'.(date('Y') + 1),
            'job_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'alumni_id' => 'nullable|string|max:50',
            'membership_type' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
            'linkedin_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
        ]);

        $data = $request->all();
        $data['name'] = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name);
        
        $user->update($data);

        $redirectRoute = $user->role === 'user' ? 'admin.users' : 'admin.executives';
        return redirect()->route($redirectRoute)->with('success', 'User details updated successfully');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors(['error' => 'You cannot delete your own account.']);
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User account deleted successfully.');
    }

    public function events()
    {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function createEvent()
    {
        return view('admin.events.create');
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location_type' => 'nullable|string|max:50',
            'location_name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:50',
            'fee' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|string|max:255',
        ]);

        $imageUrl = $request->image_url;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/events'), $imageName);
            $imageUrl = 'uploads/events/' . $imageName;
        }

        $date = \Carbon\Carbon::parse($request->event_date);

        Event::create([
            'title' => $request->title,
            'event_date' => $request->event_date,
            'event_month' => strtoupper($date->format('M')),
            'event_day' => $date->format('d'),
            'location_type' => $request->location_type ?? 'Physical',
            'location_name' => $request->location_name,
            'description' => $request->description,
            'category' => $request->category,
            'fee' => $request->fee,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('admin.events')->with('success', 'Event created successfully');
    }

    public function editEvent(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function updateEvent(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location_type' => 'nullable|string|max:50',
            'location_name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:50',
            'fee' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|string|max:255',
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/events'), $imageName);
            $data['image_url'] = 'uploads/events/' . $imageName;
        }

        $date = \Carbon\Carbon::parse($request->event_date);
        $data['event_month'] = strtoupper($date->format('M'));
        $data['event_day'] = $date->format('d');

        $event->update($data);

        return redirect()->route('admin.events')->with('success', 'Event updated successfully');
    }

    public function deleteEvent(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events')->with('success', 'Event deleted successfully');
    }

    public function eventReservations(Event $event)
    {
        $reservations = \App\Models\EventReservation::where('event_id', $event->id)->latest()->paginate(20);
        return view('admin.events.reservations', compact('event', 'reservations'));
    }

    public function allReservations()
    {
        $events = \App\Models\Event::withCount('reservations')->latest()->paginate(20);
        return view('admin.events.all-reservations', compact('events'));
    }
    
    public function news()
    {
        $news = News::latest()->paginate(15);
        return view('admin.news.index', compact('news'));
    }

    public function createNews()
    {
        return view('admin.news.create');
    }

    public function storeNews(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
            'content' => 'required|string',
            'summary' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|string|max:255',
        ]);

        $slug = \Illuminate\Support\Str::slug($request->title);
        // Check if slug exists
        if (News::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $imageUrl = $request->image_url;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/news'), $imageName);
            $imageUrl = 'uploads/news/' . $imageName;
        }

        News::create([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'summary' => $request->summary,
            'author' => $request->author,
            'image_url' => $imageUrl,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.news')->with('success', 'News article created successfully');
    }

    public function editNews(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function updateNews(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
            'content' => 'required|string',
            'summary' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|string|max:255',
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/news'), $imageName);
            $data['image_url'] = 'uploads/news/' . $imageName;
        }

        if ($news->title !== $request->title) {
            $slug = \Illuminate\Support\Str::slug($request->title);
            if (News::where('slug', $slug)->where('id', '!=', $news->id)->exists()) {
                $slug .= '-' . time();
            }
            $data['slug'] = $slug;
        }

        $news->update($data);

        return redirect()->route('admin.news')->with('success', 'News article updated successfully');
    }

    public function deleteNews(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news')->with('success', 'News article deleted successfully');
    }

    public function jobs()
    {
        $jobs = JobPosting::latest()->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function createJob()
    {
        return view('admin.jobs.create');
    }

    public function approveJob(JobPosting $job)
    {
        $job->update(['status' => 'approved']);
        
        $users = \App\Models\User::all();
        foreach($users as $user) {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\JobPostedMail($job));
        }

        return redirect()->route('admin.jobs')->with('success', 'Job approved successfully and users notified.');
    }

    public function rejectJob(JobPosting $job)
    {
        $job->update(['status' => 'rejected']);
        return redirect()->route('admin.jobs')->with('success', 'Job rejected successfully.');
    }

    public function deleteJob(JobPosting $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs')->with('success', 'Job posting deleted successfully.');
    }

    public function products()
    {
        $products = \App\Models\Product::latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'original_price' => 'nullable|numeric',
            'category' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'badge' => 'nullable|string|max:255',
            'sizes' => 'nullable|array',
            'delivery_fee' => 'nullable|numeric',
        ]);

        $data = $request->except(['image', 'sizes']);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        if ($request->has('sizes')) {
            $data['sizes'] = implode(',', $request->sizes);
        }

        $data['is_spotlight'] = $request->has('is_spotlight');

        \App\Models\Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Product created successfully.');
    }

    public function editProduct(\App\Models\Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, \App\Models\Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'original_price' => 'nullable|numeric',
            'category' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'badge' => 'nullable|string|max:255',
            'sizes' => 'nullable|array',
            'delivery_fee' => 'nullable|numeric',
        ]);

        $data = $request->except(['image', 'sizes']);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        if ($request->has('sizes')) {
            $data['sizes'] = implode(',', $request->sizes);
        } else {
            $data['sizes'] = null;
        }

        $data['is_spotlight'] = $request->has('is_spotlight');

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(\App\Models\Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }

    public function orders()
    {
        $orders = \App\Models\Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, \App\Models\Order $order)
    {
        $request->validate(['status' => 'required|string']);
        $order->update(['status' => $request->status]);
        return redirect()->route('admin.orders')->with('success', 'Order status updated to ' . $request->status);
    }

    public function payments(Request $request)
    {
        $query = \App\Models\Payment::with('user');
        $type = $request->query('type');

        if ($type == 'dues') {
            $query->where('description', 'like', '%Dues%');
        } elseif ($type == 'shop') {
            $query->where('description', 'like', '%Shop%');
        } elseif ($type == 'donation') {
            $query->where(function($q) {
                $q->where('description', 'like', '%Donation%')
                  ->orWhere('description', 'like', '%Project%');
            });
        }

        $payments = $query->latest()->paginate(25);
        
        $totalRevenue = \App\Models\Payment::whereIn('status', ['Paid', 'successful', 'success', 'completed'])->sum('amount');
        $duesRevenue = \App\Models\Payment::whereIn('status', ['Paid', 'successful', 'success', 'completed'])->where('description', 'like', '%Dues%')->sum('amount');
        $shopRevenue = \App\Models\Payment::whereIn('status', ['Paid', 'successful', 'success', 'completed'])->where('description', 'like', '%Shop%')->sum('amount');
        $donationRevenue = \App\Models\Payment::whereIn('status', ['Paid', 'successful', 'success', 'completed'])->where(function($q) {
                $q->where('description', 'like', '%Donation%')
                  ->orWhere('description', 'like', '%Project%');
            })->sum('amount');

        $paymentSetting = \App\Models\PaymentSetting::first();

        return view('admin.payments.index', compact('payments', 'totalRevenue', 'duesRevenue', 'shopRevenue', 'donationRevenue', 'type', 'paymentSetting'));
    }

    public function donationProjects()
    {
        $projects = \App\Models\DonationProject::latest()->get();
        return view('admin.donations.index', compact('projects'));
    }

    public function createDonationProject()
    {
        return view('admin.donations.create');
    }

    public function storeDonationProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric',
            'icon' => 'nullable|string',
        ]);

        \App\Models\DonationProject::create($request->all());

        return redirect()->route('admin.donations')->with('success', 'Project created successfully.');
    }

    public function editDonationProject(\App\Models\DonationProject $project)
    {
        return view('admin.donations.edit', compact('project'));
    }

    public function updateDonationProject(Request $request, \App\Models\DonationProject $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric',
            'icon' => 'nullable|string',
        ]);

        $project->update($request->all());

        return redirect()->route('admin.donations')->with('success', 'Project updated successfully.');
    }

    public function deleteDonationProject(\App\Models\DonationProject $project)
    {
        $project->delete();
        return redirect()->route('admin.donations')->with('success', 'Project deleted successfully.');
    }

    public function gallery()
    {
        $images = \App\Models\Gallery::latest()->get();
        return view('admin.gallery.index', compact('images'));
    }

    public function storeGallery(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
            'category' => 'nullable|string',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('gallery', 'public');
                $url = 'storage/' . $path;
                
                \App\Models\Gallery::create([
                    'image_url' => $url,
                    'caption' => $request->caption,
                    'category' => $request->category,
                ]);
            }
        }

        return redirect()->route('admin.gallery')->with('success', 'Images uploaded successfully.');
    }

    public function deleteGallery(\App\Models\Gallery $image)
    {
        // Delete file from storage
        \Storage::delete(str_replace('storage/', 'public/', $image->image_url));
        $image->delete();
        return redirect()->route('admin.gallery')->with('success', 'Image deleted successfully.');
    }

    public function cooperative()
    {
        $setting = \App\Models\CooperativeSetting::first() ?? new \App\Models\CooperativeSetting();
        $applications = CooperativeApplication::latest()->take(5)->get();
        $totalApplications = CooperativeApplication::count();
        return view('admin.cooperative.index', compact('setting', 'applications', 'totalApplications'));
    }

    public function updateCooperative(Request $request)
    {
        $setting = \App\Models\CooperativeSetting::first() ?? new \App\Models\CooperativeSetting();
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'heading' => 'nullable|string|max:255',
            'description' => 'required|string',
            'benefits' => 'nullable|string',
            'outlines' => 'nullable|string',
            'video_url' => 'nullable|string',
            'application_link' => 'nullable|string',
            'cta_text' => 'nullable|string|max:255',
            'stats_members' => 'nullable|string|max:50',
            'stats_investments' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cooperative', 'public');
            $data['image_url'] = 'storage/' . $path;
        }

        // Handle multiple gallery images
        if ($request->hasFile('gallery_images')) {
            $existingImages = $setting->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('cooperative/gallery', 'public');
                $existingImages[] = 'storage/' . $path;
            }
            $data['gallery_images'] = $existingImages;
        }

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('cooperative/videos', 'public');
            $data['video_url'] = 'storage/' . $path;
        } else {
            $data['video_url'] = $request->video_url; // Could be youtube link
        }

        $setting->fill($data)->save();

        return redirect()->route('admin.cooperative')->with('success', 'Cooperative settings updated successfully.');
    }

    public function deleteCooperativeGalleryImage(Request $request)
    {
        $setting = \App\Models\CooperativeSetting::first();
        if (!$setting) return back();

        $imageToDelete = $request->image;
        $images = $setting->gallery_images ?? [];
        $images = array_values(array_filter($images, fn($img) => $img !== $imageToDelete));
        
        // Delete file from storage
        \Storage::delete(str_replace('storage/', 'public/', $imageToDelete));
        
        $setting->update(['gallery_images' => $images]);

        return redirect()->route('admin.cooperative')->with('success', 'Gallery image removed.');
    }

    public function updatePaymentSettings(Request $request)
    {
        $data = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'instructions' => 'required|string',
        ]);

        $setting = \App\Models\PaymentSetting::first() ?? new \App\Models\PaymentSetting();
        $setting->fill($data)->save();

        return back()->with('success', 'Manual payment settings updated successfully.');
    }

    public function approvePayment(Payment $payment)
    {
        $payment->update(['status' => 'Paid']);

        // Check if this payment corresponds to an Event Reservation
        if (str_starts_with($payment->description, 'Event Ticket:')) {
            $eventTitle = str_replace('Event Ticket: ', '', $payment->description);
            $event = \App\Models\Event::where('title', $eventTitle)->first();
            if ($event) {
                $reservation = \App\Models\EventReservation::where('event_id', $event->id)
                    ->where('user_id', $payment->user_id)
                    ->first();
                if ($reservation) {
                    $reservation->update(['status' => 'confirmed']);
                    // Send confirmation mail
                    try {
                        Mail::to($reservation->email)->send(new \App\Mail\EventReservationMail($reservation, $event));
                    } catch (\Exception $e) {
                        // Log mail exception if any
                    }
                }
            }
        }

        // Check if this payment corresponds to a Shop Order
        if (str_starts_with($payment->description, 'Shop Purchase:')) {
            $order = \App\Models\Order::where('reference', $payment->reference)->first();
            if ($order) {
                $order->update(['status' => 'completed']);
            }
        }

        // Check if this payment corresponds to a Donation
        if (str_contains(strtolower($payment->description), 'donation') || str_contains(strtolower($payment->description), 'project')) {
            $parts = explode(':', $payment->description);
            if (count($parts) > 1) {
                $projectTitle = trim($parts[1]);
                $project = \App\Models\DonationProject::where('title', $projectTitle)->first();
                if ($project) {
                    $project->increment('raised_amount', $payment->amount);
                }
            }
        }

        return back()->with('success', 'Payment verified and approved successfully.');
    }

    public function rejectPayment(Payment $payment)
    {
        $payment->update(['status' => 'Failed']);

        // Also update corresponding Event Reservation if applicable
        if (str_starts_with($payment->description, 'Event Ticket:')) {
            $eventTitle = str_replace('Event Ticket: ', '', $payment->description);
            $event = \App\Models\Event::where('title', $eventTitle)->first();
            if ($event) {
                $reservation = \App\Models\EventReservation::where('event_id', $event->id)
                    ->where('user_id', $payment->user_id)
                    ->first();
                if ($reservation) {
                    $reservation->update(['status' => 'rejected']);
                }
            }
        }

        // Also update corresponding Order if applicable
        if (str_starts_with($payment->description, 'Shop Purchase:')) {
            $order = \App\Models\Order::where('reference', $payment->reference)->first();
            if ($order) {
                $order->update(['status' => 'cancelled']);
            }
        }

        return back()->with('success', 'Payment rejected successfully.');
    }
}
