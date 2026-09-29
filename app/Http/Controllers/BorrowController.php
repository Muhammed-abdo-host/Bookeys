<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    //
    public function index(Request $request)
    {
        $records = $request->user()
            ->borrowRecords()
            ->with('book.author')
            ->latest()
            ->paginate(10);

        return view('borrows.index', compact('records'));
    }

    public function store(Request $request, Book $book)
    {
        $user = $request->user();
        $days = 14;
        $result = DB::transaction(function () use ($book, $user, $days) {
            $book = Book::lockForUpdate()->findOrFail($book->id);
            if (! $book->isAvilable()) {
                return 'No Copies';
            }

            $alreadyBorrowed = BorrowRecord::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->whereNull('returned_at')
                ->exists();

            if ($alreadyBorrowed) {
                return 'already_borrowed';
            }

            BorrowRecord::create([
                'book_id' => $book->id,
                'user_id' => $user->id,
                'borrow_at' => now()->toDateString(),
                'due_date' => now()->addDays()->toDateString(),
                'status' => 'borrowed',
            ]);

            $book->decrement('available_copies');

            return 'ok';
        });

        return match ($result) {
            'no_copies'        => back()->with('error', 'لا توجد نسخ متاحة حاليًا من هذا الكتاب'),
            'already_borrowed' => back()->with('error', 'أنت مستعير هذا الكتاب بالفعل'),
            default            => redirect()->route('borrows.index')
                ->with('success', 'تمت الاستعارة بنجاح'),
        };
    }
}
