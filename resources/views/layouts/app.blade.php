<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aplikasi Kasir')</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: sans-serif; margin: 0; color: #1f2937; }
        nav { background: #1e3a8a; padding: 14px 40px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
        nav .brand { color: #fff; font-weight: bold; font-size: 18px; }
        nav ul { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; flex-wrap: wrap; }
        nav ul li a { color: #cbd5e1; text-decoration: none; padding: 6px 4px; }
        nav ul li a.active { color: #fff; font-weight: bold; border-bottom: 2px solid #fff; }
        nav .navbar-user { display: flex; align-items: center; gap: 12px; color: #cbd5e1; font-size: 14px; }
        nav .btn-logout { background: none; border: 1px solid #cbd5e1; color: #cbd5e1; padding: 4px 10px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        nav .btn-logout:hover { background: #1e40af; color: #fff; }
        main { max-width: 1000px; margin: 0 auto; padding: 30px 40px; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background: #f3f4f6; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 10px 14px; border-radius: 4px; margin-bottom: 16px; }
        .alert-error { background: #fee2e2; color: #991b1b; padding: 10px 14px; border-radius: 4px; margin-bottom: 16px; }
        .btn { display: inline-block; padding: 6px 14px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; font-size: 14px; }
        .btn-danger { background: #dc2626; }
        .btn-gray { background: #6b7280; }
        form.inline { display: inline; }
        .form-box { max-width: 520px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input[type=text], input[type=number], input[type=date], input[type=search], select, textarea { width: 100%; padding: 6px; margin-top: 4px; }
        .error { color: #b91c1c; font-size: 14px; margin-top: 4px; }
        .toolbar { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; margin: 12px 0; }
        .toolbar input { width: auto; margin: 0; }
        .stats-grid { display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px; }
        .stat-card { flex: 1; min-width: 180px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; text-align: center; }
        .stat-card .value { font-size: 28px; font-weight: bold; color: #1e3a8a; }
        .stat-card .label { margin-top: 6px; color: #6b7280; font-size: 14px; }
        .summary { margin-top: 16px; font-size: 18px; }
        .right { text-align: right; }
        .pagination { margin-top: 16px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .pagination a { color: #2563eb; text-decoration: none; }
        .pagination .pagination-current { font-weight: bold; color: #1e3a8a; }
        .pagination .pagination-disabled { color: #9ca3af; }
        footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb; margin-top: 40px; }
        @media print {
            nav, footer, .no-print { display: none !important; }
            main { padding: 0; }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <main>
        @include('partials.alert')

        @yield('content')
    </main>

    <footer>&copy; {{ date('Y') }} Aplikasi Kasir</footer>
</body>
</html>
