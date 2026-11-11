@extends('layouts.app')
@section('content')
<div class="hero"><h1>Library Resource Management System</h1><p>Discover books, manage library resources, and keep borrowing records organized.</p><div class="actions"><a class="btn gold" href="{{ route('catalog') }}">Explore Book Catalog</a>@guest<a class="btn light" href="{{ route('login') }}">Staff / Student Login</a>@else<a class="btn light" href="{{ route('dashboard') }}">Go to Dashboard</a>@endguest</div></div>
<div class="grid"><div class="card"><h2>Find a Book</h2><p class="muted">Search titles, authors, ISBN, and categories.</p></div><div class="card"><h2>Borrowing Records</h2><p class="muted">Track due dates, returns, and overdue transactions.</p></div><div class="card"><h2>Organized Library</h2><p class="muted">A centralized catalog for library resources.</p></div></div>
@endsection
