{{-- resources/views/admin/books/index.blade.php --}}
<x-layouts.app title="إدارة الكتب">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>إدارة الكتب</h3>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">+ إضافة كتاب</a>
    </div>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>المؤلف</th>
                <th>التصنيف</th>
                <th>النسخ (متاح/إجمالي)</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->available_copies }} / {{ $book->total_copies }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-secondary">تعديل</a>
                        <form method="POST" action="{{ route('admin.books.destroy', $book) }}"
                              onsubmit="return confirm('متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $books->links() }}

</x-layouts.app>