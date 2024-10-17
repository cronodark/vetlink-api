<aside class="relative bg-sidebar h-screen w-80 hidden sm:block shadow-xl">
    <div class="p-6">
        <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">
            <img src="images/logo.png" alt="">
        </a>
    </div>

    <nav class="text-white text-base font-semibold pt-3">
        <a href="{{ route('dashboard') }}" class="flex m-3 gap-2 rounded-lg items-center {{ \Route::is('dashboard') ? 'active-nav-link' : '' }} text-gray-500 py-4 pl-4 nav-item transition duration-300 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                <path d="M12.5641 3.48923V9.06051C12.563 9.75439 12.3566 10.4324 11.9711 11.0093C11.5855 11.5863 11.038 12.0363 10.3974 12.3028C9.97357 12.478 9.51909 12.5668 9.06054 12.5641H3.48929C2.56257 12.5603 1.67511 12.1895 1.02117 11.5329C0.367221 10.8762 6.75153e-05 9.98724 7.52982e-05 9.06051V3.50359C6.75153e-05 2.57686 0.367221 1.68788 1.02117 1.03124C1.67511 0.374601 2.56257 0.00379806 3.48929 1.23734e-10H9.06054C9.98726 -7.78282e-06 10.8762 0.367148 11.5329 1.0211C12.1895 1.67504 12.5603 2.56251 12.5641 3.48923ZM27.9999 3.50359V9.06051C28.003 9.51932 27.9143 9.97411 27.7393 10.3982C27.5642 10.8223 27.3062 11.2072 26.9804 11.5303C26.6596 11.86 26.2754 12.1215 25.851 12.2991C25.4267 12.4768 24.9708 12.5669 24.5107 12.5641H18.9395C18.2472 12.5632 17.5706 12.3581 16.9944 11.9745C16.4182 11.5908 15.9679 11.0457 15.7001 10.4074C15.5226 9.98069 15.4328 9.52264 15.4359 9.06051V3.50359C15.4347 3.04377 15.5256 2.58837 15.7032 2.16421C15.8807 1.74005 16.1414 1.35572 16.4697 1.03385C16.7926 0.706761 17.1771 0.446967 17.601 0.269506C18.025 0.0920447 18.4799 0.00044156 18.9395 1.23734e-10H24.5107C25.4374 0.00379806 26.3249 0.374601 26.9788 1.03124C27.6328 1.68788 27.9999 2.57686 27.9999 3.50359ZM12.5641 18.9538V24.5108C12.5603 25.4375 12.1895 26.325 11.5329 26.9789C10.8762 27.6329 9.98726 28 9.06054 28H3.48929C2.56401 27.9982 1.67669 27.6319 1.01956 26.9805C0.693775 26.6574 0.435786 26.2726 0.260721 25.8485C0.0856571 25.4244 -0.00295757 24.9696 7.52982e-05 24.5108V18.9538C-0.00295757 18.495 0.0856571 18.0403 0.260721 17.6161C0.435786 17.192 0.693775 16.8072 1.01956 16.4841C1.67379 15.8248 2.56055 15.4484 3.48929 15.4359H9.06054C9.98989 15.4434 10.8788 15.817 11.5347 16.4755C12.1905 17.134 12.5604 18.0245 12.5641 18.9538ZM27.9999 21.7251C27.9971 22.965 27.627 24.1761 26.9364 25.2058C26.2459 26.2355 25.2657 27.0376 24.1197 27.5107C22.9737 27.9839 21.7133 28.1069 20.4974 27.8644C19.2816 27.6218 18.1648 27.0244 17.2881 26.1478C16.4114 25.2711 15.8141 24.1543 15.5715 22.9384C15.329 21.7226 15.452 20.4621 15.9252 19.3161C16.3983 18.1701 17.2003 17.19 18.23 16.4994C19.2597 15.8088 20.4709 15.4387 21.7107 15.4359C22.9549 15.4394 24.1703 15.8101 25.2046 16.5016C26.2388 17.193 27.0459 18.1745 27.5246 19.3229C27.8405 20.0839 28.0014 20.9009 27.9999 21.7251Z" fill="#BABABA"/>
              </svg>
            Dashboard
        </a>
        <a href="{{ route('hospital') }}" class="mt-5 m-3 gap-2 rounded-lg flex items-center {{ \Route::is('hospital') ? 'active-nav-link' : '' }} text-gray-500 py-4 pl-4 nav-item transition duration-300 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                <path d="M19.8333 0H8.16667C6.237 0 4.66667 1.57033 4.66667 3.5V28H23.3333V3.5C23.3333 1.57033 21.763 0 19.8333 0ZM12.8333 22.1667H9.33333V19.8333H12.8333V22.1667ZM12.8333 17.5H9.33333V15.1667H12.8333V17.5ZM10.5 9.33333V7H12.8333V4.66667H15.1667V7H17.5V9.33333H15.1667V11.6667H12.8333V9.33333H10.5ZM18.6667 22.1667H15.1667V19.8333H18.6667V22.1667ZM18.6667 17.5H15.1667V15.1667H18.6667V17.5ZM28 10.5V28H25.6667V7.21467C27.0212 7.69767 28 8.981 28 10.5ZM2.33333 7.21467V28H0V10.5C0 8.981 0.978833 7.69767 2.33333 7.21467Z" fill="#BABABA"/>
              </svg>
            Hospital
        </a>
        <a href="{{ route('forum') }}" class="mt-5 m-3 gap-2 rounded-lg flex items-center {{ \Route::is('forum') ? 'active-nav-link' : '' }} text-gray-500 py-4 pl-4 nav-item transition duration-300 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                <path d="M21 13.9977V5.83236C21 2.6164 18.3832 0 15.1667 0H5.83333C2.61683 0 0 2.6164 0 5.83236V20.8262C0 21.7512 0.5075 22.5981 1.323 23.0355C1.694 23.235 2.10117 23.3329 2.50717 23.3329C2.9925 23.3329 3.47667 23.1918 3.89667 22.913L8.52017 19.83H15.1667C18.3832 19.83 21 17.2136 21 13.9977ZM10.5 16.3353C9.856 16.3353 9.33333 15.8127 9.33333 15.1688C9.33333 14.5249 9.856 14.0023 10.5 14.0023C11.144 14.0023 11.6667 14.5249 11.6667 15.1688C11.6667 15.8127 11.144 16.3353 10.5 16.3353ZM12.1882 11.2366C11.6667 11.5236 11.6667 11.6076 11.6667 11.6694C11.6667 12.3144 11.144 12.8359 10.5 12.8359C9.856 12.8359 9.33333 12.3144 9.33333 11.6694C9.33333 10.1436 10.5443 9.47759 11.0612 9.19297C11.3995 9.0075 11.7553 8.56891 11.6468 7.94951C11.5663 7.49225 11.1778 7.10382 10.7217 7.0245C10.3647 6.95917 10.0193 7.05016 9.751 7.27645C9.485 7.49808 9.33333 7.8247 9.33333 8.17114C9.33333 8.8162 8.81067 9.33761 8.16667 9.33761C7.52267 9.33761 7 8.8162 7 8.17114C7 7.13414 7.45617 6.15664 8.25067 5.48942C9.04517 4.8222 10.0905 4.53991 11.1242 4.72771C12.5347 4.97384 13.6955 6.13331 13.944 7.54708C14.2042 9.03083 13.4983 10.5134 12.187 11.2378L12.1882 11.2366ZM28 10.4983V25.4921C28 26.4171 27.4925 27.264 26.677 27.7014C26.306 27.9009 25.8988 27.9988 25.4928 28C25.0075 28 24.5233 27.8589 24.1045 27.5801L19.4798 24.4959H12.8333C11.1417 24.4959 9.6285 23.7599 8.56217 22.6062L9.226 22.163H15.1667C19.6688 22.163 23.3333 18.4991 23.3333 13.9977V5.83236C23.3333 5.47309 23.3018 5.12315 23.2575 4.77554C25.9537 5.28879 28 7.65556 28 10.4983Z" fill="#BABABA"/>
              </svg>
            Forum
        </a>
    </nav>
</aside>
