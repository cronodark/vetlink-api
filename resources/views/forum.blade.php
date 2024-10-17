<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    @include('layouts.customstyle')

</head>
<body class="body font-family-karla flex">

    @include('layouts.sidebar')

    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header Mobile Header & Nav -->
        @include('layouts.headbar')
    {{-- isi disini --}}
    <h1 class="text-xl">forum</h1>

    </div>

    @include('layouts.javascript')
</body>
</html>