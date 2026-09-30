{{-- resources/views/catalog/index.blade.php --}}
<x-layouts.app title="تصفح الكتب">

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="ابحث عن كتاب...">
        </div>
        <div class="col-md-4">
            <select name="category_id" class="form-select">
                <option value="">كل التصنيفات</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">بحث</button>
        </div>
    </form>

    <div class="row g-3">
        @forelse ($books as $book)
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text text-muted mb-1">✍️ {{ $book->author->name }}</p>
                        <p class="card-text text-muted mb-1">🏷️ {{ $book->category->name }}</p>
                        <span class="badge {{ $book->isAvailable() ? 'bg-success' : 'bg-secondary' }}">
                            {{ $book->isAvailable() ? 'متاح' : 'غير متاح' }}
                        </span>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-outline-primary">
                            التفاصيل
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">لا توجد كتب مطابقة.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $books->links() }}</div>

</x-layouts.app>