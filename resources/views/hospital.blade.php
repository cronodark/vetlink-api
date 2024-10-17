<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    @include('layouts.customstyle')
</head>
<body class="body font-family-karla flex">

    @include('layouts.sidebar')

    <div class="w-full flex flex-col h-screen overflow-y-hidden bg-[#F6F6F6]">
        <!-- Desktop Header Mobile Header & Nav -->
        @include('layouts.headbar')
        
        {{-- Isi disini --}}
        <div class="flex items-center justify-center flex-grow">
            <div class="bg-[#FFFFFF] h-[600px] w-[1185px] rounded-[20px] flex items-center justify-center text-white shadow-[20px_4px_35px_0px_rgba(0, 0, 0, 0.09)]">
                <svg xmlns="http://www.w3.org/2000/svg" width="1100" height="3" viewBox="0 0 1100 3" fill="none">
                    <path d="M1 1H1439" stroke="black" stroke-linecap="round"/>
                  </svg>
            </div>            
        </div>

    </div>

    @include('layouts.javascript')
</body>
</html>