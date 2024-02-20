@extends('layouts/contentNavbarLayout')

@section('title', 'Pengeluaran')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Lainnya /</span> Sumber
<ul class="list-inline mb-0 float-end">
           <li class="list-inline-item">
               <a href="#" class="btn btn-outline-primary">
                   <i class="bi bi-download me-1"></i> Arsip
               </a>
           </li>
           <li class="list-inline-item">|</li>
           <li class="list-inline-item">
               <a href="{{ route('InputSumber') }}" class="btn btn-primary">
                   <i class="bi bi-plus-circle me-1"></i> Input Data
               </a>
           </li>
       </ul>
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        {{-- <h5 class="card-header">Table Basic</h5> --}}
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($sources as $source)
                        <tr>
                            <td>{{ $source->id }}</td>
                            <td>{{ $source->name }}</td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

@endsection
