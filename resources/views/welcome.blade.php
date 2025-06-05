<!DOCTYPE html>
<html>
<head>
    <title>WEBGIS Pertanian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container text-center mt-5">
        <h1 class="display-4">Selamat Datang di WEBGIS Pertanian</h1>
        <p class="lead">Sistem Informasi Geografis untuk data dan peta pertanian</p>
        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-success btn-lg me-3">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg">Daftar</a>
        </div>
    </div>
</body>
</html>
