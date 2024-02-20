@extends('layouts/contentNavbarLayout')

@section('title', 'Karyawan')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Employee</span>
        <ul class="list-inline mb-0 float-end">
            <li class="list-inline-item">
                <a href="#" class="btn btn-outline-primary">
                    <i class="bi bi-download me-1"></i> To Excel
                </a>
            </li>
            <li class="list-inline-item">|</li>
            <li class="list-inline-item">
                <a href="{{ route('employee.index') }}" class="btn btn-warning">
                    <i class="bi bi-plus-circle me-1"></i> Karyawan
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
                        <th>Nip</th>
                        {{-- <th>Nik</th> --}}
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Whatsapp</th>
                        <th>Posisi</th>
                        <th>Gaji</th>
                        <th>Durasi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($data as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>

                          <td>{{ $item->nip }}</td>
                          {{-- <td>{{ $item->nik }}</td> --}}
                          <td>{{ $item->name }}</td>
                          <td>{{ $item->email }}</td>
                          <td>{{ $item->whatsapp_number }}</td>
                          <td>{{ $item->position_name }} ({{ $item->level }})</td>
                          <td>{{ 'Rp ' . number_format($item->salary, 0, ',', '.') }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->start_date)->diffForHumans($item->end_date, false) }}
                          </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <form action="{{ route('employee.unarchived',$item->nip) }}" method="post">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="bx bx-history me-1"></i>
                                                Unarchived</button>
                                        </form>

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
        });

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
