<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verified</title>

    <!-- AdminLTE CSS (adjust path if different) -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .verified-box {
            max-width: 760px;
            width: 100%;
            padding: 40px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .badge-success-big {
            font-size: 72px;
            color: #28a745;
        }
    </style>
</head>

<body class="hold-transition">

    <div class="verified-box">
        <div class="mb-3">
            <i class="fa-solid fa-circle-check badge-success-big"></i>
        </div>

        <h1 class="h3">Email Verified Successfully</h1>
        <p class="text-muted">
            Thanks — your email address has been verified. You can now continue to your account.
        </p>

        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary mr-2">Go to Home</a>
        </div>

        <p class="mt-3 text-sm text-muted">If you did not expect this, contact support.</p>
    </div>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
