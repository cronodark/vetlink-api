<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vetlink</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    @include('layouts.customstyle')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>
<body class="body font-family-karla flex">

    @include('layouts.sidebar')

    <div class="w-full flex flex-col h-screen overflow-y-hidden bg-[#F6F6F6]">
        <!-- Desktop Header Mobile Header & Nav -->
        @include('layouts.headbar')

        <!-- Isi Konten dengan Margin -->
        <div class="w-full flex items-center flex-col px-2 gap-y-7 mt-5">

            <div class="flex justify-center items-center">
                <div class="flex">
                    <img src="{{ asset('images/pictpet.png') }}" class="mx-auto h-auto w-full max-w-[300px] sm:max-w-[400px] md:max-w-[500px] lg:max-w-[1190px] shadow-[20px_4px_35px_0px_rgba(0, 0, 0, 0.09)]" alt="Pictpet">
                </div>
            </div>

            <div class="flex justify-center lg:gap-x-7 sm:gap-x-10 items-center  max-w-[300px] sm:max-w-[400px] md:max-w-[500px] lg:max-w-[1190px] shadow-[20px_4px_35px_0px_rgba(0, 0, 0, 0.09)]">
                <div class="bg-white w-96 h-56 rounded-[20px] shadow-[20px_4px_35px_0px_rgba(0, 0, 0, 0.1)]">

                    <div class="justify-center items-center flex gap-2 m-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path d="M21.25 0H8.75C6.6825 0 5 1.6825 5 3.75V30H25V3.75C25 1.6825 23.3175 0 21.25 0ZM13.75 23.75H10V21.25H13.75V23.75ZM13.75 18.75H10V16.25H13.75V18.75ZM11.25 10V7.5H13.75V5H16.25V7.5H18.75V10H16.25V12.5H13.75V10H11.25ZM20 23.75H16.25V21.25H20V23.75ZM20 18.75H16.25V16.25H20V18.75ZM30 11.25V30H27.5V7.73C28.9513 8.2475 30 9.6225 30 11.25ZM2.5 7.73V30H0V11.25C0 9.6225 1.04875 8.2475 2.5 7.73Z" fill="#3FA2F6"/>
                          </svg>
                        <p class="lg:text-xl sm:text-m font-bold text-[#3FA2F6]" style="font-family: 'Poppins', sans-serif;">
                            Jumlah Klinik
                        </p>
                    </div>

                    <div class="justify-center items-center my-auto flex">
                        <p class="lg:text-7xl sm:text-xl font-bold text-[#FFA33C]" style="font-family: 'Poppins', sans-serif;">
                            3
                        </p>
                    </div>
                </div>

                <div class="bg-white w-96 h-56 rounded-[20px] shadow-[20px_4px_35px_0px_rgba(0, 0, 0, 0.1)]">

                    <div class="justify-center items-center flex gap-2 m-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path d="M21.25 0H8.75C6.6825 0 5 1.6825 5 3.75V30H25V3.75C25 1.6825 23.3175 0 21.25 0ZM13.75 23.75H10V21.25H13.75V23.75ZM13.75 18.75H10V16.25H13.75V18.75ZM11.25 10V7.5H13.75V5H16.25V7.5H18.75V10H16.25V12.5H13.75V10H11.25ZM20 23.75H16.25V21.25H20V23.75ZM20 18.75H16.25V16.25H20V18.75ZM30 11.25V30H27.5V7.73C28.9513 8.2475 30 9.6225 30 11.25ZM2.5 7.73V30H0V11.25C0 9.6225 1.04875 8.2475 2.5 7.73Z" fill="#3FA2F6"/>
                          </svg>
                        <p class="lg:text-xl sm:text-m font-bold text-[#3FA2F6]" style="font-family: 'Poppins', sans-serif;">
                            Klinik Menunggu Konfirmasi
                        </p>
                    </div>

                    <div class="justify-center items-center my-auto flex">
                        <p class="lg:text-7xl sm:text-xl font-bold text-[#FFA33C]" style="font-family: 'Poppins', sans-serif;">
                            1
                        </p>
                    </div>
                </div>

                <div class="bg-white w-96 h-56 rounded-[20px] shadow-[20px_4px_35px_0px_rgba(0, 0, 0, 0.1)]">

                    <div class="justify-center items-center flex gap-2 m-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path d="M22.5 14.9975V6.24896C22.5 2.80328 19.6963 0 16.25 0H6.25C2.80375 0 0 2.80328 0 6.24896V22.3138C0 23.3049 0.54375 24.2122 1.4175 24.6809C1.815 24.8946 2.25125 24.9996 2.68625 24.9996C3.20625 24.9996 3.725 24.8484 4.175 24.5497L9.12875 21.2465H16.25C19.6963 21.2465 22.5 18.4432 22.5 14.9975ZM11.25 17.5021C10.56 17.5021 10 16.9422 10 16.2523C10 15.5624 10.56 15.0025 11.25 15.0025C11.94 15.0025 12.5 15.5624 12.5 16.2523C12.5 16.9422 11.94 17.5021 11.25 17.5021ZM13.0587 12.0392C12.5 12.3467 12.5 12.4367 12.5 12.5029C12.5 13.1941 11.94 13.7527 11.25 13.7527C10.56 13.7527 10 13.1941 10 12.5029C10 10.8682 11.2975 10.1546 11.8512 9.84961C12.2137 9.65089 12.595 9.18097 12.4788 8.51733C12.3925 8.02741 11.9762 7.61123 11.4875 7.52625C11.105 7.45626 10.735 7.55374 10.4475 7.7962C10.1625 8.03366 10 8.3836 10 8.75479C10 9.44593 9.44 10.0046 8.75 10.0046C8.06 10.0046 7.5 9.44593 7.5 8.75479C7.5 7.64373 7.98875 6.5964 8.84 5.88152C9.69125 5.16664 10.8112 4.86419 11.9187 5.06541C13.43 5.32911 14.6737 6.57141 14.94 8.08615C15.2188 9.67589 14.4625 11.2644 13.0575 12.0405L13.0587 12.0392ZM30 11.2481V27.3129C30 28.304 29.4562 29.2114 28.5825 29.6801C28.185 29.8938 27.7488 29.9988 27.3137 30C26.7937 30 26.275 29.8488 25.8262 29.5501L20.8713 26.2456H13.75C11.9375 26.2456 10.3162 25.457 9.17375 24.221L9.885 23.746H16.25C21.0737 23.746 25 19.8204 25 14.9975V6.24896C25 5.86402 24.9662 5.48909 24.9187 5.11665C27.8075 5.66656 30 8.20238 30 11.2481Z" fill="#3FA2F6"/>
                          </svg>
                        <p class="lg:text-xl sm:text-m font-bold text-[#3FA2F6]" style="font-family: 'Poppins', sans-serif;">
                            Jumlah Post
                        </p>
                    </div>

                    <div class="justify-center items-center my-auto flex">
                        <p class="lg:text-7xl sm:text-xl font-bold text-[#FFA33C]" style="font-family: 'Poppins', sans-serif;">
                            6
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('layouts.javascript')
</body>
</html>
