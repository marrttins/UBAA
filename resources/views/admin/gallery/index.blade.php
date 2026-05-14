@extends('admin.layouts.app')

@section('title', 'Gallery Management')

@section('extra_css')
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#4A0E4E',
                    secondary: '#D4AF37',
                }
            }
        }
    }
</script>
@endsection

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Visual Gallery</h3>
        <p class="text-gray-500 font-medium text-sm">Upload and manage branch memories and event photos.</p>
    </div>
    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg hover:brightness-110 transition-all flex items-center gap-2 border border-primary/20">
        <i class="fas fa-cloud-upload-alt text-xs"></i> Bulk Upload
    </button>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @foreach($images as $image)
    <div class="aspect-square bg-white rounded-2xl border border-gray-100 overflow-hidden relative group shadow-sm hover:shadow-xl transition-all duration-300">
        <img src="{{ asset($image->image_url) }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-4 text-center">
            <span class="text-[9px] font-black text-white uppercase tracking-widest mb-2 px-2 py-1 bg-primary/40 rounded">{{ $image->category ?? 'General' }}</span>
            <form action="{{ route('admin.gallery.delete', $image) }}" method="POST" onsubmit="return confirm('Delete this photo?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-trash-alt text-xs"></i>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-[200] flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] p-8 w-full max-w-xl relative shadow-2xl">
        <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded-full font-black text-gray-400"><i class="fa-solid fa-xmark"></i></button>
        <h3 class="text-2xl font-black text-primary mb-8 tracking-tight uppercase">Upload Memories</h3>
        
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Select Images (Multiple)</label>
                <input type="file" name="images[]" multiple required class="w-full px-6 py-10 bg-gray-50 border-2 border-dashed border-gray-100 rounded-3xl text-xs font-bold text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/80 transition-all cursor-pointer">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Category</label>
                    <select name="category" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700 appearance-none">
                        <option value="Events">Events</option>
                        <option value="Reunions">Reunions</option>
                        <option value="Campus">Campus</option>
                        <option value="Executive">Executive</option>
                        <option value="Misc">Miscellaneous</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest px-2">Global Caption</label>
                    <input type="text" name="caption" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-200 transition-all font-semibold text-gray-700" placeholder="Optional caption...">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-black text-sm tracking-widest shadow-xl shadow-primary/10 hover:brightness-110 active:scale-95 transition-all">
                    <i class="fas fa-upload mr-2"></i> START UPLOAD
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
