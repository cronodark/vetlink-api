<header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
    <div class="w-1/2"></div>
    <div x-data="{ isOpen: false }" class="relative w-1/2 gap-2 flex justify-end">
        <div class="gap-y-1 justify-center items-center">
            <p class="font-semibold text-s" style="font-family: 'Poppins'">
                Ghaniyy Ramadhan
            </p>
            <p class="font-normal flex justify-end text-s" style="font-family: 'Poppins'">
                Admin
            </p>
        </div>
        <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
            <img src="{{ asset('images/TTK.png') }}">
        </button>
        <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
        <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
            <a href="#" class="block px-4 py-2 account-link hover:text-white">Account</a>
            <a href="#" class="block px-4 py-2 account-link hover:text-white">Support</a>
            <a href="#" class="block px-4 py-2 account-link hover:text-white">Sign Out</a>
        </div>
    </div>
</header>
<header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
    <div class="flex items-center justify-between">
        <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        <button @click="isOpen = !isOpen" class="text-blue text-3xl focus:outline-none">
            <i x-show="!isOpen" class="fas fa-bars"></i>
            <i x-show="isOpen" class="fas fa-times"></i>
        </button>
    </div>

    <!-- Dropdown Nav -->
    <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
        <a href="{{ route('dashboard') }}" class="flex m-3 rounded-lg items-center active-nav-link text-[#878787] py-4 pl-4 nav-item transition duration-300 ease-in-out">
            <img src="images/dashboard.png" class="mr-3 w-6" alt="">
            Dashboard
        </a>
        <a href="{{ route('hospital') }}" class="mt-5 m-3 rounded-lg flex items-center text-[#070404] opacity-75 hover:opacity-100 py-4 pl-6 nav-item transition duration-300 ease-in-out">
            <img src="images/hospital.png" class="mr-3 w-6" alt="">
            Hospital
        </a>

        <a href="{{ route('forum') }}" class="mt-5 m-3 rounded-lg flex items-center text-[#878787] opacity-75 hover:opacity-100 py-4 pl-6 nav-item transition duration-300 ease-in-out">
            <img src="images/forum.png" class="mr-3 w-6" alt="">
            Forum
        </a>

        <a href="#" class="mt-5 m-3 rounded-lg flex items-center text-[#878787] opacity-75 hover:opacity-100 py-4 pl-6 nav-item transition duration-300 ease-in-out">
            <i class="fas fa-sign-out-alt mr-3"></i>
            Sign out
        </a>
       
    </nav>
    <!-- <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
        <i class="fas fa-plus mr-3"></i> New Report
    </button> -->
</header>