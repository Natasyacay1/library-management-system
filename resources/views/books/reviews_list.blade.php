<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold mb-4 flex items-center">
        <i class="fas fa-star text-yellow-400 mr-2"></i>
        Ulasan Pembaca 
        <span class="ml-2 text-sm text-gray-500">({{ $book->reviews->count() }})</span>
    </h3>

    <!-- Average Rating -->
    <div class="flex items-center mb-6 p-4 bg-gray-50 rounded-lg">
        <div class="text-3xl font-bold text-gray-800 mr-4">
            {{ number_format($book->average_rating, 1) }}/5
        </div>
        <div class="flex items-center">
            @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star text-{{ $i <= floor($book->average_rating) ? 'yellow-400' : ($i <= $book->average_rating ? 'yellow-300' : 'gray-300') }} text-xl"></i>
            @endfor
        </div>
    </div>

    <!-- Reviews List -->
    <div class="space-y-4">
        @forelse($book->reviews()->with('user')->latest()->take(5)->get() as $review)
        <div class="border-b border-gray-200 pb-4 last:border-b-0">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $review->user->name }}</p>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow-400' : 'gray-300' }} text-sm"></i>
                            @endfor
                            <span class="text-xs text-gray-500 ml-2">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                
                @if(auth()->id() === $review->user_id)
                <div class="flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm" 
                                onclick="return confirm('Hapus review ini?')">Hapus</button>
                    </form>
                </div>
                @endif
            </div>
            
            @if($review->comment)
            <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
            @endif
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-comment-slash text-4xl mb-3 text-gray-300"></i>
            <p>Belum ada ulasan untuk buku ini.</p>
        </div>
        @endforelse
    </div>
</div>