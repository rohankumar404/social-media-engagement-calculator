<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mapsily Tools')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-main: #272727;
            --bg-card: #333333;
            --color-primary: #85f43a;
            --color-secondary: #47A805;
            --text-light: #f8f9fa;
            --text-muted: #a1a1aa;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
        }
        
        .text-primary-accent {
            color: var(--color-primary) !important;
        }

        /* Cards */
        .card {
            background-color: var(--bg-card);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1.25rem 1.5rem;
            border-top-left-radius: 16px !important;
            border-top-right-radius: 16px !important;
        }
        
        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-primary-cta {
            background-color: var(--color-primary);
            color: #1a1a1a;
            border: none;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(133, 244, 58, 0.15);
        }

        .btn-primary-cta:hover, .btn-primary-cta:focus {
            background-color: var(--color-secondary);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(133, 244, 58, 0.25);
        }

        .btn-outline-custom {
            border: 1px solid var(--color-primary);
            color: var(--color-primary);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-outline-custom:hover {
            background-color: var(--color-primary);
            color: #1a1a1a;
        }

        /* Custom inputs */
        .form-control, .form-select {
            background-color: rgba(0,0,0,0.2) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: var(--text-light) !important;
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(133, 244, 58, 0.15) !important;
            border-color: var(--color-primary) !important;
        }
        
        .form-control::placeholder {
            color: #6c757d;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #e4e4e7;
        }
        
        /* Custom Radio Buttons / Cards */
        .btn-check:checked + .btn-custom-radio {
            border-color: var(--color-primary) !important;
            background-color: rgba(133, 244, 58, 0.05) !important;
            color: var(--text-light) !important;
        }
        
        .btn-custom-radio {
            background: rgba(255,255,255,0.05);
            border: 2px solid rgba(255,255,255,0.1) !important;
            color: var(--text-light);
            text-align: left;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .btn-custom-radio:hover {
            border-color: rgba(255,255,255,0.3) !important;
            color: var(--text-light);
            background: rgba(255,255,255,0.08);
        }

        /* Progress Bar */
        .steps-container {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem auto 3.5rem;
            max-width: 650px;
            padding: 0 1rem;
        }

        .steps-container::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 1rem;
            right: 1rem;
            height: 4px;
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-50%);
            z-index: 1;
            border-radius: 2px;
        }

        .steps-progress {
            position: absolute;
            top: 50%;
            left: 1rem;
            height: 4px;
            background-color: var(--color-primary);
            transform: translateY(-50%);
            z-index: 1;
            border-radius: 2px;
            transition: width 0.4s ease;
        }

        .step-item {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .step-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--bg-card);
            border: 4px solid var(--bg-main);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 0 0 2px rgba(255,255,255,0.1);
        }

        .step-item.active .step-circle {
            border-color: var(--bg-main);
            background-color: var(--bg-card);
            color: var(--color-primary);
            box-shadow: 0 0 0 2px var(--color-primary);
        }
        
        .step-item.completed .step-circle {
            background-color: var(--color-primary);
            color: #1a1a1a;
            box-shadow: 0 0 0 2px var(--color-primary);
            border-color: var(--bg-main);
        }

        .step-label {
            position: absolute;
            top: 45px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            white-space: nowrap;
        }
        
        .step-item.active .step-label {
            color: var(--text-light);
        }

        /* Hero Section */
        .page-hero {
            padding: 3rem 0 2rem;
            text-align: center;
        }
        
        .hero-badge {
            background-color: rgba(133, 244, 58, 0.1);
            color: var(--color-primary);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        /* Sidebar specific */
        .sidebar-feature {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        
        .sidebar-icon {
            color: var(--color-primary);
            font-size: 1.3rem;
            background: rgba(133, 244, 58, 0.1);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-text h5 {
            font-size: 1.05rem;
            margin-bottom: 0.15rem;
        }
        
        .sidebar-text p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 0;
        }
        
        .pro-card {
            background: linear-gradient(145deg, var(--bg-card) 0%, rgba(71, 168, 5, 0.1) 100%);
            border: 1px solid rgba(133, 244, 58, 0.2);
        }
        
        .navbar-brand {
            font-weight: 800;
            color: #fff !important;
            font-size: 1.5rem;
        }
        
        .navbar-brand span {
            color: var(--color-primary);
        }

    </style>
    @stack('styles')
</head>
<body>
    
    <!-- Optional: Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent py-3">
        <div class="container">
            <a class="navbar-brand" href="/">Mapsily<span>Tools</span></a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-toggle="target" aria-controls="navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-medium">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Tools</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-custom btn-sm py-2 px-3 mt-1 mt-lg-0" href="#">Sign In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="pb-5">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
