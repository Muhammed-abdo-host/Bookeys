{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'مكتبة رقمية' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">📚 المكتبة</a>
            <div class="d-flex gap-2">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-light btn-sm">لوحة الأدمن</a>
                    @else
                        <a href="{{ route('borrows.index') }}" class="btn btn-outline-light btn-sm">استعاراتي</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm">تسجيل خروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">دخول</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm">حساب جديد</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{ $slot }}
    </div>

</body>
</html>