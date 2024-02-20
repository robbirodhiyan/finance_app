@extends('layouts/contentNavbarLayout')

@section('title', 'Add Employee')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Karyawan /</span> Tambah Karyawan
    </h4>
    <div>
        <form action="{{ route('employee.store') }}" method="POST">
            <div class="card mb-4">
                <h5 class="card-header">Data pemerintahan</h5>
                @csrf
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nip" name="nip" value="{{ $nip }}"
                            readonly />
                        @error('nip')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Nip <span class="text-danger">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="nik" name="nik" value="{{ old('nik') }}"
                            maxlength="16" placeholder="120321*****" />
                        @error('nik')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Nik <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="no_bpjstk" name="no_bpjstk" maxlength="16"
                            value="{{ old('no_bpjstk') }}" placeholder="123456*****" />
                        @error('no_bpjstk')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">No Bpjs</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="no_npwp" name="no_npwp"
                            value="{{ old('no_npwp') }}" placeholder="120321*****" />
                        @error('no_npwp')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">No NPWP</label>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header">Data karyawan</h5>
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" placeholder="John Doe" />
                        @error('name')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Name <span class="text-danger">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" placeholder="johndoe@weza.co.id" />
                        @error('email')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Email <span class="text-danger">*</span> </label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number"
                            value="{{ old('whatsapp_number') }}" placeholder="628***********" />
                        @error('whatsapp_number')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Whatsapp Number <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">

                        <textarea name="address" class="form-control" id="address"
                            placeholder="Jl Malik Ibrahim No.16, Pucanganom, Sidoarjo - Jawa Timur">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Address <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="position" aria-label="Floating label select example"
                            name="position">
                            <option value="{{ old('position') }}" selected>{{ old('position', 'Pilih devisi') }}</option>
                            @foreach ($positions as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->level }})</option>
                            @endforeach
                        </select>
                        @error('position')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Position <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="employe_status" aria-label="Floating label select example"
                            name="employe_status">
                            <option value="{{ old('employe_status') }}" selected>
                                {{ old('employe_status', 'Jenis Karyawan') }}</option>
                            @foreach ($employeStatuses as $item)
                                <option data-contract="{{ $item['contract_status'] }}" value="{{ $item['title'] }}">
                                    {{ $item['title'] }}</option>
                            @endforeach
                        </select>
                        @error('employe_status')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Jenis Karyawan <span class="text-danger">*</span></label>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="start_date"
                                    value="{{ old('start_date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                    name="start_date">
                                <label for="start_date">Mulai Bekerja</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="end_date" value="{{ old('end_date') }}"
                                    name="end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                <label for="end_date">Akhir Kerja</label>
                            </div>
                        </div>
                    </div>




                </div>
            </div>

            {{-- salary --}}
            <div class="card mb-4">
                <h5 class="card-header">Penggajian</h5>
                <div class="card-body">

                    <div class="form-floating mb-3">
                        <select class="form-select" id="bank_code" name="bank_code"></select>
                        @error('bank_code')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Bank <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="bank_account" name="bank_account"
                            value="{{ old('bank_account') }}" placeholder="" />
                        @error('bank_account')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Nomor Rekening <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3" id="salary-form">
                        <input type="text" class="form-control" id="salary" name="salary"
                            value="{{ old('salary') }}" placeholder="4.000.000" />
                        @error('salary')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Gaji <span class="text-danger">*</span></label>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-grid">
                            <a href="{{ route('employee.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                                    class="bi-arrow-left-circle me-2"></i>Cancel</a>
                        </div>
                        <div class="col-md-6 d-grid">
                            <button type="submit" class="btn btn-dark btn-lg mt-3"><i class="bi-check-circle me-2"></i>
                                Save</button>
                        </div>
                    </div>


                </div>
            </div>
            {{-- salary --}}
        </form>
    </div>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        rel="stylesheet" />
    <style>
        /* jadikan select2 tampilannya seperti form floating bootstrab */
        .select2-container--bootstrap .select2-selection--single {
            height: calc(3.25rem + 2px);
            width: 100%;
            /* jika memiliki value hilangkan label */
            padding-top: 1.60rem;

        }
    </style>
@endpush

@push('page-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bank_code').select2({
                theme: 'bootstrap',
                ajax: {
                    url: "{{ route('api.list.bank') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            bank: params.term,
                            limit: 5 // Atur limit sesuai kebutuhan
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.data.map(function(item) {
                                return {
                                    id: item.code,
                                    text: item.name
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1 // Atur minimum karakter input untuk memulai pencarian
            });
        });


        // format nomor rekening
        document.addEventListener("DOMContentLoaded", function() {
            const bankAccountInput = document.getElementById("bank_account");

            bankAccountInput.addEventListener("input", function() {
                // Menghapus karakter selain angka
                const formattedValue = this.value.replace(/[^0-9]/g, "");

                // Membatasi panjang nomor rekening menjadi 10 digit
                const maxLength = 20;
                if (formattedValue.length > maxLength) {
                    this.value = formattedValue.slice(0, maxLength);
                } else {
                    this.value = formattedValue;
                }
            });
        });

        // format rupiah
        /* Dengan Rupiah */
        var dengan_rupiah = document.getElementById('salary');
        dengan_rupiah.addEventListener('keyup', function(e) {
            dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
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
        // max length 16 for id nik
        document.getElementById('nik').addEventListener('input', function(e) {
            if (this.value.length > 16)
                this.value = this.value.slice(0, 16);
        });
        document.getElementById('no_bpjstk').addEventListener('input', function(e) {
            if (this.value.length > 16)
                this.value = this.value.slice(0, 16);
        });
        document.getElementById('no_npwp').addEventListener('input', function(e) {
            if (this.value.length > 15)
                this.value = this.value.slice(0, 15);
        });

        const employeStatus = document.getElementById('employe_status');
        const salary = document.getElementById('salary-form');

        employeStatus.addEventListener('change', function(e) {
            if (this.options[this.selectedIndex].dataset.contract == 1) {
                salary.value = '';
                salary.style.display = 'block';
            } else {
                salary.value = '';
                salary.style.display = 'none';
            }
        });
    </script>
@endpush
