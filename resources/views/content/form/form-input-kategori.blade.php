@extends('layouts/contentNavbarLayout')

@section('title', 'Basic Inputs - Forms')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Input /</span> Kategori
    </h4>
    <div>
        <div class="card mb-4">
            <h5 class="card-header">Input Kategori</h5>
            <div class="card-body">
                <form action="{{ route('storekategori') }}" method="POST">
@csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" value=""
                            placeholder="John Doe" aria-describedby="floatingInputHelp" />
                        <label for="floatingInput">Name</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6 d-grid">
                            <a href="{{ route('kategori') }}" class="btn btn-outline-dark btn-lg mt-3"><i
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
