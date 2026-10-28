<!DOCTYPE html>
<html lang="en" data-theme="nature">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Admin' }}</title>

    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-base-200 text-base-content font-sans">

<div class="flex min-h-screen">

    <x-admin.sidebar />

    <div class="flex-1 flex flex-col pl-72">

        <x-admin.navbar />

        <main class="p-8">

            {{ $slot }}

        </main>

    </div>

</div>

</body>
</html>