<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">
    <title>Simple Todo-List </title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap');

        body {
            font-family: "Bricolage Grotesque", serif;
        }
    </style>

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>


@if(!Auth::user())
<div class="modal-auth w-full h-full bg-slate-500/20 fixed z-[99] top-0 right-0 bottom-0 left-0 flex justify-center items-center">
    <div class="md:w-[450px] w-[90vw] flex-shrink-0 bg-white rounded-lg border-2 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] relative">
        <img src="https://i.ibb.co.com/4ZzMmTj3/1740284891070.png" alt="MIKA" class="absolute top-[-140px] z-[-1] right-50 translate-x-[50%] w-[200px]" loading="lazy">
        <div class="md:p-6 p-2 m-3">
            <div class="text-center">
                <h1 class="text-2xl font-semibold">Siapa namamu sensei ?</h1>
                <form action="/login" method="POST" class="flex items-center mt-8 gap-3"> 
                    @csrf
                    <input type="text" name="name" required placeholder="Masukkan nama" maxlength="25" class="w-full shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] border-2 py-3 px-4 text-sm text-slate-800 rounded-lg focus:outline-none  ">
                    <button class="h-full cursor-pointer bg-white border p-3 rounded-md shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endif


<body class="">
    <div class="max-w-5xl mx-auto w-full">
        <div class="my-12 flex justify-center w-full">  
            <div class="md:w-[700px] w-full min-h-[700px] rounded-lg bg-white border-2 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                <div class="header h-[50px] border-b-2">
                    <div class="p-5 flex items-center h-full gap-3">
                        <div class="w-[13px] h-[13px] rounded-full bg-red-400"></div>
                        <div class="w-[13px] h-[13px] rounded-full bg-yellow-400"></div>
                        <div class="w-[13px] h-[13px] rounded-full bg-green-400"></div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex justify-center mt-7">
                        <div class="text-center">
                            <h1 class="text-dark text-3xl tracking-wide font-bold">SATURDAY!</h1>
                            <p class="text-slate-600 text-sm mt-1">Mar 23 2025</p>
                        </div>
                    </div>
                    <div class="flex justify-center mt-4 gap-2">
                        <div class="w-[30px] h-[5px] bg-slate-900 rounded-full"></div>
                        <div class="w-[10px] h-[5px] bg-slate-900 rounded-full"></div>
                    </div>
                    <div class="mt-10">
                        <form method="POST" action="" class="mx-10 flex items-center h-full gap-3"> 
                            @csrf
                            <input type="text" name="name" required placeholder="Lagi mau ngapain apa nih ? .." class="w-full shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] border-2 py-3 px-4 text-sm text-slate-800 rounded-lg focus:outline-none  ">
                            <button class="h-full cursor-pointer bg-white border p-3 rounded-md shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
                            </button>
                        </form>
                    </div>
                    <div class="list mt-14 px-10">

                        @for($i= 0; $i < 10; $i++)
                        <div class="data_list flex gap-5">
                            <button class="h-full cursor-pointer bg-red-400 border p-2 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-none duration-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                            <div class="">  
                                <h1>Ngerjain PR Bareng Bareng</h1>
                                <p class="text-xs text-slate-500">23 march 2025</p>
                            </div>
                            <button class="ms-auto h-full cursor-pointer bg-green-400 border p-2 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-none duration-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>
                            </button>
                        </div>
                        <hr class="opacity-[0.15] my-5">
                        @endfor
                        
                    </div>

                </div>

            </div>
        </div>
    </div>
</body>
</html>