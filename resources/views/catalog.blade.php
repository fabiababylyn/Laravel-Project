
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h2 class="mb-2">Library Book Catalog</h2>
    <p>Explore our available books and find something to read.</p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('catalog') }}" method="GET" class="mb-4">

        <div class="row g-2">

            <div class="col-md-6">
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    placeholder="Search title, author, or ISBN..."
                    value="{{ request('q') }}"
                >
            </div>

            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category }}"
                            @selected(request('category') == $category)
                        >
                            {{ $category }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">
                    Search
                </button>
            </div>

        </div>
    </form>

    <div class="row g-3">

        @forelse($books as $book)

            <div class="col-md-4">

                <div class="card h-100 shadow-sm">

                    <div class="card-body">

                        <h5 class="card-title">
                            {{ $book->title }}
                        </h5>

                        <p class="mb-1">
                            <strong>Author:</strong>
                            {{ $book->author }}
                        </p>

                        <p class="mb-1">
                            <strong>Category:</strong>
                            {{ $book->category ?? 'Uncategorized' }}
                        </p>

                        <p class="mb-1">
                            <strong>ISBN:</strong>
                            {{ $book->isbn ?? 'Not available' }}
                        </p>

                        <p class="mb-3">
                            <strong>Available Copies:</strong>
                            {{ $book->available_copies }}
                        </p>

                        @auth
                            @if(auth()->user()->role === 'student')

                                @if($book->available_copies > 0)

                                    <form
                                        action="{{ route('catalog.borrow', $book) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to borrow this book?');"
                                    >
                                        @csrf

                                        <button type="submit" class="btn btn-primary w-100">
                                            Borrow Book
                                        </button>
                                    </form>

                                @else

                                    <button class="btn btn-secondary w-100" disabled>
                                        Not Available
                                    </button>

                                @endif

                            @elseif(in_array(auth()->user()->role, ['admin', 'librarian']))

                                <span class="badge bg-info">
                                    Admin/Librarian View
                                </span>

                            @endif

                        @else

                            <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                Login to Borrow
                            </a>

                        @endauth

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info">
                    No books found.
                </div>
            </div>

        @endforelse

    </div>

    <div class="mt-4">
        {{ $books->links() }}
    </div>

</div>

@endsection
