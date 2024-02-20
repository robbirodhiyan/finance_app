@extends('layouts/contentNavbarLayout')

@section('title', 'Add Employee')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Posisi /</span> Tambah Posisi
    </h4>
    <div>
        <form action="{{ route('positions.store') }}" method="POST">
            <div class="card mb-4">
                <h5 class="card-header">Posisi</h5>
                @csrf
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Web Developer" />
                        @error('name')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="floatingInput">Name <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="level" name="level" aria-label="Floating label select example">
                            <option selected value="{{old('level')}}">{{old('level','Pilih Level')}}</option>
                            <option value="junior">Junior</option>
                            <option value="senior">Senior</option>
                        </select>
                        @error('level')
                            <span class="text-danger ml-2">{{ $message }}</span>
                        @enderror
                        <label for="level">Works with selects</label>
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
@endpush
