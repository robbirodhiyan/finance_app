<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{ url('/') }}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>
    <meta name="description"
        content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
    <meta name="keywords"
        content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    {{-- <link rel="stylesheet" href="https://getbootstrap.com/docs/5.2/dist/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.2/dist/css/bootstrap.min.css">
    <!-- Include Styles -->
    @include('layouts/sections/styles')

    {{-- datatables --}}
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-colvis-2.4.1/b-html5-2.4.1/b-print-2.4.1/date-1.5.1/fh-3.4.0/r-2.5.0/datatables.min.css"
        rel="stylesheet">
    {{-- datatables --}}

    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('layouts/sections/scriptsIncludes')
    @stack('css')
</head>


<body>
    {{-- toast --}}
    <div aria-live="polite" aria-atomic="true" class="position-relative">

        <div class="toast-container top-0 end-0 p-3">

            @if (session('status'))
                <!-- Then put toasts within -->
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                    <div class="toast-header">
                        <img src="{{ asset('/assets/img/logofinance.png') }}" width="50px" class="rounded me-2"
                            alt="...">
                        <strong class="me-auto">Weza</strong>
                        <small class="text-muted">just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            {{-- <!-- Then put toasts within -->
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                <div class="toast-header">
                    <img src="{{ asset('/assets/img/logofinance.png') }}" width="50px" class="rounded me-2"
                        alt="...">
                    <strong class="me-auto">Weza</strong>
                    <small class="text-muted">just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    See? Just like this.
                </div>
            </div> --}}



        </div>
    </div>
    {{-- toast --}}
    <!-- Layout Content -->
    @yield('layoutContent')
    <!--/ Layout Content -->




    {{-- remove while creating package --}}
    {{-- <div class="buy-now">
    <a href="{{config('variables.productPage')}}" target="_blank" class="btn btn-danger btn-buy-now">Upgrade To Pro</a>
  </div> --}}
    {{-- remove while creating package end --}}



    <!-- Include Scripts -->
    @include('layouts/sections/scripts')
    @stack('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- datatables --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script
        src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-colvis-2.4.1/b-html5-2.4.1/b-print-2.4.1/date-1.5.1/fh-3.4.0/r-2.5.0/datatables.min.js">
    </script>
    {{-- datatables --}}

    

    <script>
        var toastElList = document.querySelectorAll('.toast');
        toastElList.forEach(function(toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    </script>

    <script>
        // Menggunakan querySelectorAll untuk memilih semua elemen dengan kelas 'delete-btn'
        var deleteButtons = document.querySelectorAll('.delete-btn');

        // Iterasi melalui setiap elemen dan menambahkan event listener
        deleteButtons.forEach(function(button) {
            button.addEventListener("submit", function(e) {
                var form = this;
                var text = this.getAttribute('data-text');
                e.preventDefault();
                Swal.fire({
                    title: "Yakin data akan dihapus ?",
                    text: text,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Ya,hapus data!',
                    cancelButtonText: 'Tidak, batalkan!',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',

                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (form && typeof form.submit === 'function') {
                            form.submit();
                        }
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Dibatalkan',
                            'Data tidak dihapus',
                            'info'
                        )
                    }
                });
            });
        });
    </script>

</body>


</html>
