@extends('admin.layouts.app')

@section('title', 'News & Press')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-extrabold text-gray-800">Communication Center</h3>
        <p class="text-gray-500 font-medium text-sm">Publish and curate news articles for the alumni community.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.news.create') }}" class="bg-[var(--primary)] text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-purple-100 hover:bg-[var(--primary-dark)] transition-all flex items-center gap-2">
            <i class="fas fa-pen-nib text-xs"></i> Write New Article
        </a>
    </div>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50 bg-opacity-50">
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Article Details</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Category</th>
                    <th class="px-8 py-5 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Publication Date</th>
                    <th class="px-8 py-5 text-right text-[10px] font-extrabold text-gray-400 uppercase tracking-[2px]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($news as $article)
                <tr class="hover:bg-purple-50 hover:bg-opacity-30 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            @if($article->image_url)
                                <img src="{{ asset($article->image_url) }}" class="h-12 w-12 rounded-2xl object-cover shadow-sm border-2 border-white">
                            @else
                                <div class="h-12 w-12 rounded-2xl bg-pink-100 flex items-center justify-center text-pink-600 shadow-sm border-2 border-white">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                            <div class="max-w-[300px]">
                                <div class="text-sm font-extrabold text-gray-800 truncate">{{ $article->title }}</div>
                                <div class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">By {{ $article->author ?? 'Admin' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-extrabold rounded-full bg-purple-50 text-[var(--primary)] border border-purple-100 uppercase tracking-widest">
                            {{ $article->category ?? 'General' }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                        {{ $article->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right flex justify-end gap-2">
                        <a href="{{ route('admin.news.edit', $article) }}" class="text-[var(--primary)] hover:bg-purple-50 p-2 rounded-lg transition-colors">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.news.delete', $article) }}" method="POST" class="inline" onsubmit="return confirm('Delete this article?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-8 border-t border-gray-50 bg-gray-50 bg-opacity-30">
        {{ $news->links() }}
    </div>
</div>
@endsection
