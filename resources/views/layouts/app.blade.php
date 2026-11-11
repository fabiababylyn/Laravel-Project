
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Library System') | LRMS</title>

    <style>
        :root {
            --ink: #243044;
            --muted: #6d7788;
            --primary: #334e68;
            --accent: #d6a85f;
            --bg: #f4f6f8;
            --line: #e4e9ef;
            --white: #fff;
            --red: #b84444;
            --green: #287a57;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            font: 15px/1.5 Inter, Segoe UI, Arial, sans-serif;
            color: var(--ink);
        }

        a {
            color: var(--primary);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* NAVIGATION */
        .nav {
            background: #243b53;
            color: white;
            padding: 14px 4%;
            display: flex;
            align-items: center;
            gap: 22px;
            flex-wrap: wrap;
        }

        .brand {
            font-weight: 800;
            font-size: 18px;
            color: white;
            margin-right: auto;
        }

        .nav a {
            color: #edf2f7;
        }

        .nav form {
            margin: 0;
        }

        .nav button {
            background: none;
            border: 0;
            color: white;
            cursor: pointer;
            font: inherit;
        }

        .nav span {
            color: #edf2f7;
        }

        /* MAIN CONTENT */
        .wrap {
            max-width: 1180px;
            margin: 28px auto;
            padding: 0 20px;
            min-height: 65vh;
        }

        .hero {
            background: linear-gradient(120deg, #243b53, #486581);
            color: white;
            padding: 38px;
            border-radius: 16px;
            margin-bottom: 24px;
        }

        .hero h1 {
            font-size: 30px;
            margin: 0 0 8px;
        }

        .hero p {
            margin: 0;
            color: #e5edf5;
        }

        h1 {
            font-size: 27px;
            margin: 0 0 18px;
        }

        h2 {
            font-size: 19px;
            margin: 0 0 14px;
        }

        .muted {
            color: var(--muted);
        }

        .topline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        /* CARDS */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin: 18px 0;
        }

        .card,
        .panel {
            background: white;
            border: 1px solid var(--line);
            border-radius: 13px;
            padding: 19px;
            box-shadow: 0 3px 12px #172b3d08;
        }

        .metric {
            font-size: 29px;
            font-weight: 800;
            margin-top: 5px;
        }

        .metric-label {
            color: var(--muted);
            font-size: 13px;
        }

        /* BUTTONS */
        .btn {
            display: inline-block;
            border: 0;
            border-radius: 8px;
            padding: 10px 15px;
            background: var(--primary);
            color: white;
            font-weight: 650;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            opacity: .9;
            text-decoration: none;
        }

        .btn.gold {
            background: var(--accent);
            color: #243044;
        }

        .btn.light {
            background: #edf2f7;
            color: #243044;
        }

        .btn.danger {
            background: var(--red);
        }

        .btn.small {
            padding: 6px 10px;
            font-size: 12px;
        }

        /* FORMS */
        input,
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccd5df;
            border-radius: 8px;
            background: white;
            font: inherit;
            color: var(--ink);
        }

        label {
            display: block;
            font-weight: 650;
            margin: 12px 0 6px;
        }

        .formgrid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        /* TABLES */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }

        th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--muted);
            background: #f8fafc;
        }

        tr:last-child td {
            border-bottom: 0;
        }

        .tablewrap {
            overflow: auto;
            border: 1px solid var(--line);
            border-radius: 12px;
        }

        /* ALERTS */
        .alert {
            padding: 12px 15px;
            border-radius: 9px;
            margin: 12px 0;
            background: #e7f5ed;
            color: #216343;
        }

        .alert.error {
            background: #fdecec;
            color: #943939;
        }

        .errors {
            color: #b84444;
            font-size: 13px;
        }

        /* STATUS LABELS */
        .pill {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 30px;
            background: #edf2f7;
            font-size: 12px;
        }

        .pill.overdue {
            background: #fde8e8;
            color: #a12f2f;
        }

        .pill.returned {
            background: #e4f5ec;
            color: #246b4b;
        }

        /* SEARCH */
        .search {
            display: flex;
            gap: 8px;
            max-width: 520px;
        }

        .search input {
            min-width: 150px;
        }

        .pagination {
            padding: 15px;
        }

        /* AUTHENTICATION */
        .auth {
            max-width: 480px;
            margin: 45px auto;
        }

        .auth .panel {
            padding: 28px;
        }

        /* CHART */
        .chartbar {
            height: 12px;
            background: #edf2f7;
            border-radius: 20px;
            overflow: hidden;
        }

        .chartbar span {
            display: block;
            height: 100%;
            background: #d6a85f;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            padding: 30px;
            color: var(--muted);
            font-size: 13px;
        }

        /* RESPONSIVE DESIGN */
        @media(max-width: 650px) {
            .formgrid {
                grid-template-columns: 1fr;
            }

            .field.full {
                grid-column: auto;
            }

            .hero {
                padding: 25px;
            }

            .hero h1 {
                font-size: 24px;
            }

            .nav {
                gap: 12px;
            }

            .wrap {
                padding: 0 13px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVIGATION BAR -->
    <nav class="nav">

        <a class="brand" href="{{ route('home') }}">
            📚 LRMS
        </a>

        <a href="{{ route('catalog') }}">Book Catalog</a>

        @if(auth()->check())

            <a href="{{ route('dashboard') }}">Dashboard</a>

            @if(in_array(auth()->user()->role, ['admin', 'librarian']))

                <a href="{{ route('books.index') }}">Books</a>

                <a href="{{ route('borrowers.index') }}">Borrowers</a>

                <a href="{{ route('loans.index') }}">Transactions</a>

                <a href="{{ route('reports') }}">Reports</a>

            @else

                <a href="{{ route('my-loans') }}">My Loans</a>

            @endif

            <span>
                {{ auth()->user()->name }}
                ·
                {{ ucfirst(auth()->user()->role) }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>

        @else

            <a href="{{ route('login') }}">Login</a>

            <a href="{{ route('register') }}">Student Register</a>

        @endif

    </nav>

    <!-- MAIN CONTENT -->
    <main class="wrap">

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert error">

                <strong>Please check the following:</strong>

                <ul style="margin:6px 0 0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        @yield('content')

    </main>

    <!-- FOOTER -->
    <footer class="footer">
        Library Resource Management System · Laravel 12 · Academic Project
    </footer>

</body>
</html>
