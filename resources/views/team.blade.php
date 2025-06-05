<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tim Pengembang</title>
    <script src="https://cdn.tailwindcss.com"></script> {{-- Using Tailwind for utility classes --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> {{-- Link to your existing CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> {{-- Font Awesome for icons --}}
    <style>
        /* Add any specific styles for the team page here */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f8f8;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 0;
        }
        section {
            padding: 40px 0;
        }
        .team-member {
            text-align: center;
            margin-bottom: 20px;
        }
        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .team-member h3 {
            font-size: 1.2em;
            font-weight: bold;
        }
        .team-member p {
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>
<body>

    {{-- Header (You can include the dashboard header here if desired) --}}
    <header class="bg-gray-100 py-4 shadow-md">
        <div class="container flex justify-between items-center">
            <div class="text-xl font-bold">Tim Pengembang</div> {{-- Title for Team Page --}}
            <nav class="header-nav">
                <ul>
                    {{-- Example navigation links --}}
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('marketplace.index') }}">Marketplace</a></li>
                    {{-- Add other relevant links --}}
                </ul>
            </nav>
        </div>
    </header>

    <section class="team-section">
        <div class="container">
            <h2 class="text-2xl font-bold text-center mb-8">Anggota Tim Pengembang</h2>

            <div class="team-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                {{-- Example Team Member 1 --}}
                <div class="team-member">
                    <img src="https://via.placeholder.com/150" alt="Foto Anggota Tim 1">
                    <h3>Nama Anggota 1</h3>
                    <p>Peran (contoh: Fullstack Developer)</p>
                </div>

                {{-- Example Team Member 2 --}}
                <div class="team-member">
                    <img src="https://via.placeholder.com/150" alt="Foto Anggota Tim 2">
                    <h3>Nama Anggota 2</h3>
                    <p>Peran (contoh: WebGIS Specialist)</p>
                </div>

                {{-- Example Team Member 3 --}}
                <div class="team-member">
                    <img src="https://via.placeholder.com/150" alt="Foto Anggota Tim 3">
                    <h3>Nama Anggota 3</h3>
                    <p>Peran (contoh: Data Analyst)</p>
                </div>

                {{-- Example Team Member 4 --}}
                 <div class="team-member">
                    <img src="https://via.placeholder.com/150" alt="Foto Anggota Tim 4">
                    <h3>Nama Anggota 4</h3>
                    <p>Peran (contoh: UI/UX Designer)</p>
                </div>

                {{-- Add more team members as needed --}}
            </div>
        </div>
    </section>

    {{-- Footer (You can include a footer component here) --}}
    <footer class="bg-gray-800 text-white text-center py-4 mt-8">
        <div class="container">
            <p>&copy; 2023 Nama Website Anda. All rights reserved.</p>
        </div>
    </footer>

</body>
</html> 