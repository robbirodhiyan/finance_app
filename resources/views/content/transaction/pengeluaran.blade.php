@extends('layouts/contentNavbarLayout')

@section('title', 'Pengeluaran')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">transaction /</span> Pengeluaran
        <ul class="list-inline mb-0 float-end">
            <li class="list-inline-item">
                <a href="#" class="btn btn-outline-primary">
                    <i class="bi bi-download me-1"></i> To Excel
                </a>
            </li>
            <li class="list-inline-item">|</li>
            <li class="list-inline-item">
                <a href="{{ route('InputCredit') }}" class="btn btn-primary">
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
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>kategori</th>
                        <th>Sumber</th>
                        <th>Nominal</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Log</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php
                        $sortedTransactions = $credits->sortBy('date');
                    @endphp
                    @foreach ($sortedTransactions as $credit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ date('d F Y', strtotime($credit->date)) }}</td>
                            <td>{{ $credit->name }}</td>
                            <td>{{ $credit->category }}</td>
                            <td>{{ $credit->source }}</td>
                            <td>Rp. {{ $credit->total }}</td>
                            <td>
                              @if ($credit->getFile())
                              <a href="{{ $credit->getFile() }}" target="__blank" >File</a>
                              @else
                              -
                              @endif
                            </td>
                            <td><span class="badge bg-label-success me-1">approved</span></td>
                            <td>
                                @if ($credit->status_update == 0)
                                    <span class="badge bg-label-success me-1">Original</span>
                                @else
                                    <span class="badge bg-label-success me-1">Diperbarui</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('editpengeluaran', ['credit' => $credit->id]) }}"
                                            class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-edit-alt me-1"></i>
                                            Edit</a>
                                        <button data-name="{{ $credit->name }}" value="{{ $credit->id }}"
                                            class="dropdown-item riwayat"><i class="bx bx-history me-1"></i>
                                            Lihat Riwayat</button>
                                    </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

    <!-- Modal -->
    <div class="modal fade" id="debitLog" tabindex="-1" aria-labelledby="debitLogLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="debitLogLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">



                </div>
                {{-- <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                  </div> --}}
            </div>
        </div>
    </div>


@endsection


@push('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
       $(document).ready(function() {
        $('#datatable').DataTable();
      } );

        // document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.riwayat').forEach(function(element) {
            element.addEventListener('click', function() {
                var id = this.value;
                var name = this.dataset.name;
                $.ajax({
                    url: "{{ url('/auth/credit-log') }}/" + id,
                    type: "GET",
                    data: {
                        id: id,
                    },
                    success: function(data) {

                        console.log(data);
                        $('#debitLogLabel').html(name);
                        var html = '';
                        var i;
                        html += `
                        <div class="table-responsive">
                        <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Tanggal</th>

      <th scope="col">Kategori</th>
      <th scope="col">Sumber</th>

      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
`;
                        for (i = 0; i < data.length; i++) {
                            html +=
                                `<tr>
      <th class="timestamp">${ moment(data[i].created_at).format('DD-MM-YYYY, HH:mm:ss')}</th>

      <td>${data[i].category}</td>
      <td>${data[i].source}</td>

    `;
                            if (data[i].status_update == 0) {
                                html +=
                                    `<td><span class="badge bg-label-success me-1">Original</span></td>`;
                            } else {
                                html +=
                                    `<td><span class="badge bg-label-success me-1">Diperbarui</span></td>`;
                            }
                        }

                        html += `</tr></tbody>
</table>
</div>
`;
                        $('.modal-body').html(html);
                        $('#debitLog').modal('show');
                    }
                });
            });
        });
        // });


    </script>
@endpush
