@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Kompensasi')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kompensasi /</span> Edit Kompensasi
    </h4>
    <div>
        <form action="{{ route('compensations.update', $data->id) }}" method="POST">
            <div class="card mb-4">
                <h5 class="card-header">Kompensasi</h5>
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ $data->code }}" readonly />
                        <label for="floatingInput">Kode kompensasi <span class="text-danger">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}"
                            placeholder="Web Developer" />
                        @error('name')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Name <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="amount_type" name="amount_type"
                            aria-label="Floating label select example">
                            <option selected value="{{ old('amount_type', $data->amount_type) }}">
                                {{ old('amount_type', $data->amount_type) }}
                            </option>
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>
                        @error('amount_type')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="amount_type">Pilih Level</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="amount" name="amount" value="{{ $data->amount }}"
                            placeholder="" />
                        @error('amount')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Nominal <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="apply_date" name="apply_date"
                            value="{{ $data->apply_date }}" />
                        @error('apply_date')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Tanggal <span class="text-danger">*</span></label>
                    </div>

                    <div class="row">
                        <div class="col">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-dark w-100 mt-3">Kembali</a>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-dark w-100 mt-3">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
@endsection

@push('css')
@endpush

@push('page-script')
    <script>
        // hide amount
        // $('#amount').hide();
        $('#amount_type').change(function() {

            $('#amount').val('');
            $('#amount').removeAttr('max');
            $('#amount').removeAttr('min');
            $('#amount').removeAttr('placeholder');

            if ($(this).val() == 'fixed' || $(this).val() == '') {
                $('#amount').show();
                $('#amount').attr('placeholder', 'Nominal');
                var dengan_rupiah = document.getElementById('amount');
                dengan_rupiah.addEventListener('keyup', function(e) {
                    dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
                });
            } else {
                $('#amount').show();
                $('#amount').attr('placeholder', 'Persen');
                $('#amount').attr('max', '100');
                $('#amount').attr('min', '1');
            }
        });





        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
        }
    </script>
@endpush
