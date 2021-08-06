<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="icon" href="https://i.ibb.co/bQChqfP/LOGO2.png" type="image/x-icon">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <!--Button Extension Datatables CSS-->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <!--Datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.4/b-flash-1.6.4/b-html5-1.6.4/b-print-1.6.4/datatables.min.js"></script>

    <style>
        /* Overrides to match the Tailwind CSS */

        .dataTables_wrapper {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem
        }

        table.dataTable.no-footer {
            border-bottom-width: 1px;
            border-color: #d2d6dc
        }

        table.dataTable tbody td, table.dataTable tbody th {
            padding: 0.75rem 1rem;
            border-bottom-width: 1px;
            border-color: #d2d6dc
        }

        div.dt-buttons {
            padding: 1rem 1rem 1rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dataTables_filter, .dataTables_info {
            padding: .75rem
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 1rem
        }

        .dataTables_filter label input {
            border-width: 2px;
            border-radius: 0.5rem
        }

        .dataTables_filter label input:focus {
            box-shadow: 0 0 0 3px rgba(118, 169, 250, 0.45);
            outline: 0
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:not(.disabled), .dataTables_wrapper .dataTables_paginate .paginate_button.next:not(.disabled), .dataTables_wrapper .dataTables_paginate .paginate_button.previous:not(.disabled), .dataTables_wrapper .dataTables_paginate .paginate_button:not(.disabled), button.dt-button {
            transition-duration: 150ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #374151 !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            font-size: 0.75rem;
            font-weight: 600;
            align-items: center;
            display: inline-flex;
            border-width: 1px !important;
            border-color: #d2d6dc !important;
            border-radius: 0.375rem;
            background: #ffffff;
            overflow: visible;
            margin-bottom: 0
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.next:focus:not(.disabled), .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover:not(.disabled), .dataTables_wrapper .dataTables_paginate .paginate_button.previous:focus:not(.disabled), .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover:not(.disabled), .dataTables_wrapper .dataTables_paginate .paginate_button:focus:not(.disabled), .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled), button.dt-button:focus, button.dt-button:focus:not(.disabled), button.dt-button:hover, button.dt-button:hover:not(.disabled) {
            background-color: #edf2f7 !important;
            border-width: 1px !important;
            border-color: #d2d6dc !important;
            color: #374151 !important
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:not(.disabled) {
            background: #6875f5 !important;
            color: #ffffff !important;
            border-color: #8da2fb !important
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background-color: #8da2fb !important;
            color: #ffffff !important;
            border-color: #8da2fb !important
        }


        .dataTables_length select {
            border-radius: .25rem;
            background-color: #edf2f7;
        }

        .dataTables_length {
            padding-top: .75rem;
        }
        .child{
            text-align: left;
        }
    </style>
    @livewireStyles
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">

    @if(auth()->user()->admin)
        @include('admin.navigation')
    @else
        @include('layouts.navigation')
    @endif

    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>

    @error("error")
        <div class="bg-red-300 shadow">
            <div class="max-w-7xl flex justify-items-start mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="pr-2">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div>
                    <b class="text-red-700">{{$message}}</b>
                </div>
            </div>
        </div>
    @enderror

    @if(session('status'))
        <div class="bg-indigo-300 shadow">
            <div class="max-w-7xl flex justify-items-start mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="pr-2">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div>
                    <b class="text-indigo-700">{{session('status')}}</b>
                </div>
            </div>
        </div>
@endif

<!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!--Footer-->
    <footer class="bg-white shadow mt-6">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h5 class="font-semibold text-gray-800 leading-tight text-center">
                &copy; 2021 Ultimate Manager
            </h5>
        </div>
    </footer>
</div>
@livewireScripts
</body>
</html>
