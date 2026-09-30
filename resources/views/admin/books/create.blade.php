{{-- resources/views/admin/books/create.blade.php --}}
<x-layouts.app title="إضافة كتاب">

    <h3 class="mb-3">إضافة كتاب جديد</h3>

    <form method="POST" action="{{ route('admin.books.store') }}" class="bg-white p-4 rounded">
        @csrf

        <div class="mb-3">
            <label class="form-label">العنوان</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control">
            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">المؤلف</label>
            <select name="author_id" class="form-select">
                <option value="">اختر مؤلف</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" @selected(old('author_id') == $author->id)>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
            @error('author_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">التصنيف</label>
            <select name="category_id" class="form-select">
                <option value="">اختر تصنيف</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">ISBN (اختياري)</label>
            <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-control">
            @error('isbn') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">عدد النسخ</label>
            <input type="number" name="total_copies" value="{{ old('total_copies', 1) }}" min="1" class="form-control">
            @error('total_copies') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">حفظ</button>
    </form>

</x-layouts.app>