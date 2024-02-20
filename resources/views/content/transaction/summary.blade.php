@extends('layouts/contentNavbarLayout')

@section('title', 'Pemasukan')

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">transaction /</span> Summary
    </h4>


    <!-- Basic Bootstrap Table -->
    <div class="card mb-5">
        {{-- <h5 class="card-header">Table Basic</h5> --}}
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover table-striped mb-0 bg-white" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>kategori</th>
                            <th>Sumber</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $sortedTransactions = $transactions->sortBy('date');
                        @endphp
                        @foreach ($sortedTransactions as $transaction)
                            {{-- @dd($transaction) --}}
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d F Y', strtotime($transaction->date)) }}</td>
                                <td>{{ $transaction->name }}</td>
                                <td>{{ $transaction->category }}</td>
                                <td>{{ $transaction->source }}</td>
                                <td>
                                    @if ($transaction instanceof App\Models\Debit)
                                        <span class="badge bg-success">Rp. {{ $transaction->total }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($transaction instanceof App\Models\Credit)
                                        <span class="badge bg-danger">Rp. {{ $transaction->total }}</span>
                                    @endif
                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                    <tfoot>

                        <tr>
                            <th colspan="5">Total</th>
                            <td>Rp. {{ $transactions->whereInstanceOf('App\Models\Debit')->sum('total') }}</td>
                            <td>Rp. {{ $transactions->whereInstanceOf('App\Models\Credit')->sum('total') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <br>
    <nav class="navbar rounded floating-nav">
        <div class="container-fluid">
            <h4 class="navbar-text center-y text-white">
              Saldo
            </h4>
            <h4 class="navbar-text center-y text-white">
              Rp.{{ number_format($transactions->whereInstanceOf('App\Models\Debit')->sum('total') - $transactions->whereInstanceOf('App\Models\Credit')->sum('total'), 0, ',', '.')}}
            </h4>
        </div>
    </nav>


@endsection

@push('css')
    <style>
      .floating-nav {
        position: fixed;
        bottom: 0;
        width: 80%;
        bottom:20px;
        background-color:#112967;
        align-items: center;
      }

    </style>
@endpush

@push('page-script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endpush
