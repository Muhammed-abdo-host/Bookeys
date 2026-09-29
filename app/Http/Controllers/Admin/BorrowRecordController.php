<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowRecordController extends Controller
{
    //
    public function index(Request $request)
    {
        $records = BorrowRecord::with(['book', 'user'])
            ->when($request->status === 'active', fn($q) => $q->whereNull('returned_at'))
            ->when($request->status === 'overdue', fn($q) => $q->whereNull('returned_at')->whereDate('due_date', '<', now()))
            ->when($request->status === 'returned', fn($q) => $q->whereNotNull('returned_at'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.borrows.index', compact('records'));
    }
    public function returnBook(BorrowRecord $record)
    {
        if ($record->returned_at) {
            return back()->with('error', 'هذا الكتاب تم إرجاعه مسبقًا');
        }
        DB::transaction(function () use ($record) {
            $record->update([
                'returned_at' => now()->toDateString(),
                'status'      => 'returned',
            ]);
            $record->book()->increment('available_copies');
        });

        return back()->with('success', 'تم تسجيل الإرجاع بنجاح');
    }
}
