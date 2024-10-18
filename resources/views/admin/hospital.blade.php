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
        <div class="flex justify-center flex-grow">
            <div class="bg-white w-[1185px] rounded-[20px] text-black shadow-[20px_4px_35px_0px_rgba(0,0,0,0.09)] p-6 overflow-hidden mt-4 mb-4">
                <div class="max-h-[600px] overflow-y-auto">
                    <table class="table-auto w-full text-center" style="font-size: 16px;">
                        <thead class="sticky top-0 bg-white">
                            <tr class="border-b-2 border-gray-200">
                                <th class="px-4 py-2">Nama Klinik</th>
                                <th class="px-4 py-2">Kontak</th>
                                <th class="px-4 py-2">Alamat</th>
                                <th class="px-4 py-2">
                                    <div class="flex items-center">
                                        <span>Status Pendaftaran</span>
                                        <svg class="ml-1 w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="border-t px-4 py-4">Lo Veterinary Clinic</td>
                                <td class="border-t px-4 py-4">02189914595</td>
                                <td class="border-t px-4 py-4">Jalan Gunung Tangkuban Perahu Ruko Ambrosia Arcade No. 23 Perumahan Lippo Cikarang, Cibatu, Cikarang Sel., Cikarang Kab. Bekasi, Jawa Barat</td>
                                <td class="border-t px-4 py-4">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Disetujui</span>
                                </td>
                                <td class="border-t px-4 py-4">
                                    <button class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="border-t px-4 py-4">Lo Veterinary Clinic</td>
                                <td class="border-t px-4 py-4">02189914595</td>
                                <td class="border-t px-4 py-4">Jalan Gunung Tangkuban Perahu Ruko Ambrosia Arcade No. 23 Perumahan Lippo Cikarang, Cibatu, Cikarang Sel., Cikarang Kab. Bekasi, Jawa Barat</td>
                                <td class="border-t px-4 py-4">
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">Ditolak</span>
                                </td>
                                <td class="border-t px-4 py-4">
                                    <button class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="border-t px-4 py-4">Lo Veterinary Clinic</td>
                                <td class="border-t px-4 py-4">02189914595</td>
                                <td class="border-t px-4 py-4">Jalan Gunung Tangkuban Perahu Ruko Ambrosia Arcade No. 23 Perumahan Lippo Cikarang, Cibatu, Cikarang Sel., Cikarang Kab. Bekasi, Jawa Barat</td>
                                <td class="border-t px-4 py-4">
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm">Menunggu</span>
                                </td>
                                <td class="border-t px-4 py-4">
                                    <button class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <!-- Tambahkan baris lain di sini mengikuti pola yang sama -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        
    </div>

    @include('layouts.javascript')
</body>
</html>