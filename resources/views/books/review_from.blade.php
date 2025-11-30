@auth
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">Berikan Penilaian</h3>
    
    @if($userReview = $book->reviews->where('user_id', auth()->id())->first())
        <form action="{{ route('reviews.update', $userReview) }}" method="POST">
            @csrf @method('PUT')
    @else
        <form action="{{ route('reviews.store', $book) }}" method="POST">
            @csrf
    @endif
    
    <!-- Star Rating -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
        <div class="flex space-x-1" id="star-rating">
            @for($i = 1; $i <= 5; $i++)
                <button type="button" 
                        class="text-2xl {{ ($userReview->rating ?? 0) >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition"
                        data-rating="{{ $i }}">
                    ★
                </button>
            @endfor
        </div>
        <input type="hidden" name="rating" id="rating-input" value="{{ $userReview->rating ?? 0 }}" required>
    </div>

    <!-- Comment -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Ulasan (opsional)</label>
        <textarea name="comment" rows="3" 
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Bagikan pengalaman membaca Anda...">{{ $userReview->comment ?? '' }}</textarea>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
        {{ $userReview ? 'Update Review' : 'Submit Review' }}
    </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#star-rating button');
    const ratingInput = document.getElementById('rating-input');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            
            // Update star display
            stars.forEach((s, index) => {
                s.classList.toggle('text-yellow-400', index < rating);
                s.classList.toggle('text-gray-300', index >= rating);
            });
        });
    });
});
</script>
@else
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
    <p class="text-blue-800">
        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login</a> 
        untuk memberikan rating dan ulasan
    </p>
</div>
@endauth