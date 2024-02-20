@extends('layouts/contentNavbarLayout')

@section('title', 'Basic Inputs - Forms')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Input /</span> Credit
    </h4>
    <div>
        <div class="card mb-4">
            <h5 class="card-header">Input Pengeluaran</h5>
            <div class="card-body">
                <form action="{{ route('storecredit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" value="{{old("name")}}"
                            placeholder="John Doe" aria-describedby="floatingInputHelp" />
                        @error('name')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                        <label for="floatingInput">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="description" name="description" value="{{old("description")}}"
                            placeholder="Description" aria-describedby="floatingInputHelp" />
                        @error('description')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                        <label for="floatingInput">Description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="total" name="total" value="{{old("total")}}"
                            placeholder="Rp. xxxxxx" aria-describedby="floatingInputHelp" />
                        @error('total')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                        <label for="floatingInput">Total</label>

                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select name="category" class="form-select" id="category" aria-label="Default select example">
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}"
                                    {{ old('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="source" class="form-label">Sumber</label>
                        <select name="source" class="form-select" id="source" aria-label="Default select example">
                            @foreach ($sources as $source)
                                <option value="{{ $source->name }}" {{ old('source') == $source->name ? 'selected' : '' }}>
                                    {{ $source->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('source')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name="file" accept="application/pdf">
                        @error('file')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="html5-date-input" class="col-md-2 col-form-label">Date</label>
                        <input class="form-control" type="date" value="{{old("date")}}" id="date" name="date" />
                        @error('date')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 d-grid">
                            <a href="{{ route('pengeluaran') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                                    class="bi-arrow-left-circle
me-2"></i>
                                Cancel</a>
                        </div>
                        <div class="col-md-6 d-grid">
                            <button type="submit" class="btn btn-dark
btn-lg mt-3"><i class="bi-check-circle me-2"></i>
                                Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('page-script')
    <script>
        var dengan_rupiah = document.getElementById('total');
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
            return prefix == undefined ? rupiah : (rupiah ?   rupiah : '');
        }
    </script>
@endpush
