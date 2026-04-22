<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mapsily') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        
        <style>
            body {
                background-color: #272727;
                color: #f8f9fa;
                font-family: 'Figtree', sans-serif;
            }
            .auth-card {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(133, 244, 58, 0.2);
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            }
            .btn-primary-cta {
                background: #85f43a !important;
                color: #111 !important;
                font-weight: 600;
                border: none;
                transition: all 0.3s ease;
            }
            .btn-primary-cta:hover {
                background: #74d933 !important;
                transform: translateY(-2px);
            }
            .form-control {
                background: rgba(255,255,255,0.05) !important;
                border: 1px solid rgba(255,255,255,0.1) !important;
                color: #fff !important;
            }
            .form-control:focus {
                background: rgba(255,255,255,0.1) !important;
                color: #fff !important;
                border-color: #85f43a !important;
                box-shadow: 0 0 0 0.25rem rgba(133, 244, 58, 0.25) !important;
            }
            .form-label {
                color: #a1a1aa;
                font-size: 0.9rem;
            }
            .text-muted-link {
                color: #a1a1aa;
                text-decoration: underline;
                font-size: 0.85rem;
            }
            .text-muted-link:hover {
                color: #f8f9fa;
            }
        </style>
    </head>
    <body>
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4">
            <div class="mb-4 bg-white rounded-3 p-2 shadow-sm">
                <a href="/">
                    <img src="{{ asset('assets/img/mapsily-logo.png') }}" alt="Mapsily" height="40">
                </a>
            </div>

            <div class="w-100 px-3" style="max-width: 450px;">
                <div class="auth-card p-4 p-sm-5">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
