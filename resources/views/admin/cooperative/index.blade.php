@extends('admin.layouts.app')

@section('title', 'Cooperative Management')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h3 class="text-2xl font-extrabold text-gray-800">Cooperative Society Settings</h3>
            <p class="text-gray-500 font-medium text-sm">Update the information displayed on the Cooperative Society page.</p>
        </div>
        <a href="{{ route('admin.cooperative.applications') }}" class="bg-[var(--secondary)] text-[var(--primary)] font-bold px-6 py-3 rounded-xl hover:brightness-110 transition-all flex items-center gap-2 shadow-sm">
            <i class="fas fa-clipboard-list text-xs"></i> Applications ({{ $totalApplications }})
        </a>
    </div>

    {{-- Recent Applications Quick View --}}
    @if($applications->count() > 0)
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-[32px] border border-blue-100 p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 text-lg">📋</div>
                <h4 class="font-extrabold text-gray-800">Recent Applications</h4>
            </div>
            <a href="{{ route('admin.cooperative.applications') }}" class="text-sm font-bold text-blue-600 hover:underline">View All →</a>
        </div>
        <div class="space-y-2">
            @foreach($applications as $app)
            <div class="bg-white rounded-xl px-5 py-3 flex items-center justify-between border border-blue-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                        {{ substr($app->full_name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-700 text-sm">{{ $app->full_name }}</p>
                        <p class="text-[10px] text-gray-400">{{ $app->email }} · {{ $app->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold
                    {{ $app->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $app->status === 'contacted' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $app->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $app->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                ">{{ ucfirst($app->status) }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.cooperative.update') }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            <div class="space-y-8">
                {{-- Hero Content --}}
                <div class="pb-6 border-b border-gray-100">
                    <h4 class="font-extrabold text-gray-700 mb-6 flex items-center gap-2">
                        <i class="fas fa-heading text-purple-400 text-sm"></i> Hero Section
                    </h4>
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Hero Title</label>
                            <input type="text" name="title" value="{{ old('title', $setting->title) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. UBAA Lagos Cooperative Society" required>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Sub Heading</label>
                            <input type="text" name="heading" value="{{ old('heading', $setting->heading) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Building sustainable wealth through collective action">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Main Description</label>
                            <textarea name="description" rows="4" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="General info about the cooperative..." required>{{ old('description', $setting->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Benefits & Outlines --}}
                <div class="pb-6 border-b border-gray-100">
                    <h4 class="font-extrabold text-gray-700 mb-6 flex items-center gap-2">
                        <i class="fas fa-list-check text-green-400 text-sm"></i> Benefits & Outlines
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Key Benefits (One per line)</label>
                            <textarea name="benefits" rows="6" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Enter benefits, one per line...">{{ old('benefits', $setting->benefits) }}</textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Outlines / Key Features (One per line)</label>
                            <textarea name="outlines" rows="6" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Enter outlines, one per line...">{{ old('outlines', $setting->outlines) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- CTA & Stats --}}
                <div class="pb-6 border-b border-gray-100">
                    <h4 class="font-extrabold text-gray-700 mb-6 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-blue-400 text-sm"></i> CTA & Statistics
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">CTA Button Text</label>
                            <input type="text" name="cta_text" value="{{ old('cta_text', $setting->cta_text) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. Apply to Join">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Total Members (Display)</label>
                            <input type="text" name="stats_members" value="{{ old('stats_members', $setting->stats_members) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. 250+">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Total Investments (Display)</label>
                            <input type="text" name="stats_investments" value="{{ old('stats_investments', $setting->stats_investments) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="e.g. ₦50M+">
                        </div>
                    </div>
                </div>

                {{-- Media Section --}}
                <div class="pb-6 border-b border-gray-100">
                    <h4 class="font-extrabold text-gray-700 mb-6 flex items-center gap-2">
                        <i class="fas fa-images text-orange-400 text-sm"></i> Media & Images
                    </h4>
                    <div class="space-y-6">
                        {{-- Main Image --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Main Showcase Image</label>
                            <div class="flex items-center gap-4">
                                @if($setting->image_url)
                                    <img src="{{ asset($setting->image_url) }}" class="w-20 h-20 rounded-xl object-cover border border-gray-100">
                                @endif
                                <input type="file" name="image" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-primary hover:file:bg-purple-100 cursor-pointer">
                            </div>
                        </div>

                        {{-- Gallery Images --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Gallery Images (Multiple)</label>
                            @if($setting->gallery_images && count($setting->gallery_images) > 0)
                            <div class="flex flex-wrap gap-3 mb-4">
                                @foreach($setting->gallery_images as $galleryImage)
                                <div class="relative group">
                                    <img src="{{ asset($galleryImage) }}" class="w-24 h-24 rounded-xl object-cover border border-gray-100">
                                    <form action="{{ route('admin.cooperative.gallery.delete') }}" method="POST" class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-all">
                                        @csrf
                                        <input type="hidden" name="image" value="{{ $galleryImage }}">
                                        <button type="submit" class="w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center text-xs shadow-lg hover:bg-red-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <input type="file" name="gallery_images[]" multiple class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 cursor-pointer">
                            <p class="text-[9px] text-gray-400 font-medium px-2 mt-1">You can select multiple images. Existing images will be kept.</p>
                        </div>

                        {{-- Video --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Virtual Tour Video (YouTube Link)</label>
                                <input type="text" name="video_url" value="{{ old('video_url', $setting->video_url) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="YouTube URL">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">OR Upload Video File</label>
                                <input type="file" name="video" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-primary hover:file:bg-purple-100 cursor-pointer mt-3">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Application Link --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">External Application Link (Optional - Leave blank to use built-in form)</label>
                    <input type="text" name="application_link" value="{{ old('application_link', $setting->application_link) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="https://... (optional external form link)">
                    <p class="text-[9px] text-gray-400 font-medium px-2">If left blank, the "Apply to Join" button on the cooperative page will open the built-in application form.</p>
                </div>
            </div>

            <div class="mt-10 pt-10 border-t border-gray-50 flex justify-end">
                <button type="submit" class="bg-primary text-white py-4 px-12 rounded-2xl font-bold hover:brightness-110 transition-all shadow-xl shadow-purple-100 flex items-center gap-3" style="background: var(--primary);">
                    <i class="fas fa-save text-xs"></i> Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
