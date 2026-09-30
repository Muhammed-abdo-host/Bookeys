{{-- resources/views/borrows/index.blade.php --}}
<x-layouts.app title="استعاراتي">

    <h3 class="mb-3">استعاراتي</h3>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>الكتاب</th>
                <th>تاريخ الاستعارة</th>
                <th>تاريخ الإرجاع المتوقع</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $record)
                <tr>
                    <td>{{ $record->book->title }}</td>
                    <td>{{ $record->borrowed_at->format('Y-m-d') }}</td>
                    <td>{{ $record->due_date->format('Y-m-d') }}</td>
                    <td>
                        @if ($record->returned_at)
                            <span class="badge bg-success">تم الإرجاع</span>
                        @elseif ($record->due_date->isPast())
                            <span class="badge bg-danger">متأخر</span>
                        @else
                            <span class="badge bg-warning text-dark">مستعار</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">لا توجد استعارات بعد</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $records->links() }}

</x-layouts.app>