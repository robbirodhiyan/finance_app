@extends('layouts/contentNavbarLayout')

@section('title', 'Karyawan')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Devisi</span>
        <ul class="list-inline mb-0 float-end">
            <li class="list-inline-item">
                <a href="{{ route('positions.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Input Data
                </a>
            </li>
        </ul>
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card p-4">
        {{-- <h5 class="card-header">Table Basic</h5> --}}
        <div class="table-responsive text-nowrap">
            <table class="table" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Posisi</th>
                        <th>Level</th>
                        <th>Dibuat pada</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->level }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('positions.edit', $item->id) }}" class="dropdown-item"><i
                                                class="bx bx-edit-alt me-1"></i>
                                            Edit</a>
                                        <form action="{{ route('positions.destroy', $item->id) }}" method="post"
                                            class="delete-btn" data-text="Data Posisi {{ $item->name }} akan dihapus">
                                            @method('delete')
                                            @csrf
                                            <button class="dropdown-item" type="submit"><i class="bx bx-trash me-1"></i>
                                                Delete</button>
                                        </form>
                                    </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
