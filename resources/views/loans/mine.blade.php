
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h2>My Borrowed Books</h2>
    <p>Track your borrowing records and due dates.</p>

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

    <div class="table-responsive">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Borrowed Date</th>
                    <th>Due Date</th>
                    <th>Returned Date</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($loans as $loan)

                    <tr>
                        <td>{{ $loan->book->title ?? 'Book unavailable' }}</td>

                        <td>{{ $loan->borrowed_at }}</td>

                        <td>{{ $loan->due_date }}</td>

                        <td>{{ $loan->returned_at ?? 'Not yet returned' }}</td>

                        <td>
                            @if($loan->returned_at)
                                <span class="badge bg-success">Returned</span>
                            @elseif($loan->due_date < today())
                                <span class="badge bg-danger">Overdue</span>
                            @else
                                <span class="badge bg-primary">Borrowed</span>
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center">
                            You have no borrowing records yet.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{ $loans->links() }}

</div>

@endsection
