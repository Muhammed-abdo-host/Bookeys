{{-- resources/views/catalog/show.blade.php --}}
<x-layouts.app :title="$book->title">

    <div class="card">
        <div class="card-body">
            <h3>{{ $book->title }}</h3>
            <p class="text-muted">✍️ {{ $book->author->name }} — 🏷️ {{ $book->category->name }}</p>
            <p>عدد النسخ المتاحة: <strong>{{ $book->available_copies }}</strong> من {{ $book->total_copies }}</p>

            @auth
                @if (auth()->user()->isClient())
                    <form method="POST" action="{{ route('borrow.store', $book) }}">
                        @csrf
                        <button class="btn btn-primary" @disabled(! $book->isAvailable())>
                            {{ $book->isAvailable() ? 'استعارة هذا الكتاب' : 'لا توجد نسخ متاحة' }}
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary">سجّل دخول للاستعارة</a>
            @endauth
        </div>
    </div>

</x-layouts.app>