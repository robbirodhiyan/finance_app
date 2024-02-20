@extends('layouts/contentNavbarLayout')

@section('title', 'Add Kompensasi')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Payroll /</span> Kompensasi/{{ $type }}
    </h4>
    <div>
        <form action="{{ route('compensations.store') }}" method="POST">
            <div class="card mb-4">
                <h5 class="card-header">{{ $type }}</h5>
                @csrf
                <div class="card-body">
                    <input type="hidden" name="compensation_type" value="{{ request()->type }}">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}"
                            placeholder="WZC000001" />
                        @error('code')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Kode Kompensasi <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Web Developer" />
                        @error('name')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Name <span class="text-danger">*</span></label>
                    </div>


                    <div class="form-floating mb-3">
                        <select class="form-select" id="amount_type" name="amount_type"
                            aria-label="Floating label select example">
                            <option selected value="{{ old('amount_type') }}">{{ old('amount_type', 'Tipe Nominal') }}
                            </option>
                            <option value="fixed">Nominal</option>
                            <option value="percentage">Persen</option>
                        </select>
                        @error('amount_type')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="amount_type">Tipe nominal kompensasi <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="amount" name="amount"
                            value="{{ old('amount') }}" placeholder="" />
                        @error('amount')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Nominal <span class="text-danger">*</span></label>
                    </div>

                    {{-- <div class="form-floating mb-3">
                        <select class="form-select" id="compensation_type" name="compensation_type"
                            aria-label="Floating label select example">
                            <option selected value="{{ old('compensation_type') }}">
                                {{ old('compensation_type', 'Tipe Kompensasi') }}</option>
                            <option value="allowance">Allowance</option>
                            <option value="deduction">Deduction</option>
                        </select>
                        @error('compensation_type')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="compensation_type">Tipe kompensasi <span class="text-danger">*</span></label>
                    </div> --}}

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="apply_date" name="apply_date"
                            value="{{ old('apply_date') }}"/>
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
        $('#amount').hide();
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
