@extends('layouts/contentNavbarLayout')

@section('title', 'Basic Inputs - Forms')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Edit /</span> Debit
    </h4>
    <div>
        <div class="card mb-4">
            <h5 class="card-header">Edit Pemasukan</h5>
            <div class="card-body">
                <form action="{{ route('updatecredit', ['credit' => $credit->id]) }}" method="POST">
                    @csrf
                    @method('put')
                    <fieldset disabled>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $errors->any() ? old('name') : $credit->name }}" placeholder="John Doe"
                                aria-describedby="floatingInputHelp" />
                            <label for="floatingInput">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="description" name="description"
                                value="{{ $errors->any() ? old('description') : $credit->description }}"
                                placeholder="Description" aria-describedby="floatingInputHelp" />
                            <label for="floatingInput">Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="total" name="total"
                                value="{{ $errors->any() ? old('total') : $credit->total }}" placeholder="Rp. xxxxxx"
                                aria-describedby="floatingInputHelp" />
                            <label for="floatingInput">Total</label>

                        </div>
                    </fieldset>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select name="category" class="form-select" id="category" aria-label="Default select example">
                            @php
                                $selected = '';
                                if ($errors->any()) {
                                    $selected = old('category');
                                } else {
                                    $selected = $credit->category_id;
                                }
                            @endphp
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}"
                                    {{ old('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="source" class="form-label">Sumber</label>
                        <select name="source" class="form-select" id="source" aria-label="Default select example">
                            @php
                                $selected = '';
                                if ($errors->any()) {
                                    $selected = old('source');
                                } else {
                                    $selected = $credit->source_id;
                                }
                            @endphp
                            @foreach ($sources as $source)
                                <option value="{{ $source->name }}" {{ old('source') == $source->name ? 'selected' : '' }}>
                                    {{ $source->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <fieldset disabled>
                        <div class="mb-3">
                            <label for="html5-date-input" class="col-md-2 col-form-label">Date</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date"
                                    value="{{ $errors->any() ? old('date') : $credit->date }}"
                                    id="html5-date-input" />
                            </div>
                        </div>
                    </fieldset>
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
