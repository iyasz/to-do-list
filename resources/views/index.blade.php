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

{{-- NOTIFICATION  --}}




{{-- MODAL LOGIN NAME --}}
@if(!Auth::user())
<div class="modal-auth w-full h-full bg-slate-500/20 fixed z-[99] top-0 right-0 bottom-0 left-0 flex justify-center items-center">
    <div class="md:w-[450px] w-[90vw] flex-shrink-0 bg-white rounded-lg border-2 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] relative">
        <img src="https://i.ibb.co.com/4ZzMmTj3/1740284891070.png" alt="MIKA" class="absolute top-[-140px] z-[-1] right-50 translate-x-[50%] w-[200px]" loading="lazy">
        <div class="md:p-6 p-2 m-3">
            <div class="text-center">
                <h1 class="text-2xl font-semibold">Siapa namamu sensei ?</h1>
                <form action="/login" method="POST" class="flex items-center mt-8 gap-3"> 
                    @csrf
                    <input type="text" name="name" autocomplete="off" required placeholder="Masukkan nama" maxlength="25" class="w-full shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] border-2 py-3 px-4 text-sm text-slate-800 rounded-lg focus:outline-none  ">
                    <button class="h-full cursor-pointer bg-white border p-3 rounded-md shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endif


{{-- MODAL DIALOG CONFIRM DELETE AND COMPLETED ACTIVITY  --}}
<div id="modal-confirm" class="modal-confirm w-full h-full bg-slate-500/20 fixed z-[99] top-0 right-0 bottom-0 left-0 hidden justify-center items-center">
    <div class="md:w-[450px] w-[90vw] flex-shrink-0 bg-white rounded-lg border-2 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] relative">
        <img src="https://i.ibb.co.com/4ZzMmTj3/1740284891070.png" alt="MIKA" class="absolute top-[-140px] z-[-1] right-50 translate-x-[50%] w-[200px]" loading="lazy">
        <div class="md:p-6 p-2 m-3">
            <div class="text-center">
                <h1 class="text-2xl font-semibold">Apakah kamu yakin?</h1>
                <form action="" method="POST" id="confirmForm" class="flex items-center mt-8 gap-4 justify-center"> 
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="">
                    <div id="btn_cancel" class="font-semibold tracking-wide cursor-pointer bg-white border p-3 rounded-md shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        Cancel
                    </div>
                    <button id="btn_complete" class="font-semibold hidden tracking-wide cursor-pointer bg-green-400 border p-3 rounded-md shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        Selesai
                    </button>
                    <button id="btn_delete" class="font-semibold hidden tracking-wide cursor-pointer bg-red-400 border p-3 rounded-md shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        Hapus
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

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
                    <div class="flex justify-center items-center gap-9 mt-7">
                       
                        <a @if ($previousData != "" && $previousData->isNotEmpty()) href="?date={{$previousData->first()->created_at->format("d-m-Y")}}" @else class="invisible" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
                        </a>
                        
                        <div class="text-center w-[200px] ">
                            @if (request()->query("date"))
                                <h1 class="text-3xl tracking-wider font-bold">{{ $activities->first()->created_at->format("l") }}</h1>
                                <p class="text-slate-600 text-sm mt-1">{{ $activities->first()->created_at->format("d M Y") }}</p>
                            @else
                                <h1 class="text-3xl tracking-wider font-bold">{{ Carbon\Carbon::now()->format("l")}}</h1>
                                <p class="text-slate-600 text-sm mt-1">{{ Carbon\Carbon::now()->format("d M Y")}}</p>
                            @endif
                        </div>

                            <a @if ($nextData != "" && $nextData->isNotEmpty())
                                    @if ($nextData->first()->created_at->format("d-m-Y") == Carbon\Carbon::now()->format("d-m-Y"))
                                        href="/"
                                    @else
                                        href="?date={{$nextData->first()->created_at->format("d-m-Y")}}"
                                    @endif
                                @else 
                                    class="invisible" 
                                @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                            </a>

                    </div>
                    <div class="flex justify-center mt-4 gap-2">
                        <div class="w-[30px] h-[5px] bg-slate-900 rounded-full"></div>
                        <div class="w-[10px] h-[5px] bg-slate-900 rounded-full"></div>
                    </div>
                    <div class="mt-10">
                        <form method="POST" action="/activity" class="mx-10 flex items-center h-full gap-3"> 
                            @csrf
                            <input type="text" name="name" required autocomplete="off" maxlength="250" placeholder="Lagi mau ngapain nih ? .." class="w-full shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] border-2 py-3 px-4 text-sm text-slate-800 rounded-lg focus:outline-none  ">
                            <button class="h-full cursor-pointer bg-white border p-3 rounded-md shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
                            </button>
                        </form>
                    </div>
                    <div class="list mt-14 px-10">

                        @if (Auth::user() && $activities->isNotEmpty() )
                            @foreach($activities as $activity)
                            <div class="data_list flex gap-5">
                                <button onclick="showConfirm({{$activity->id}}, 'delete')" class="h-full cursor-pointer bg-red-400 border p-2 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-none duration-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                                <div class="">  
                                    <h1 class="capitalize leading-[1.1] {{ $activity->completed_at ? 'line-through' : '' }} mb-1">{{$activity->name}}</h1>
                                    <div class="flex items-center gap-2">
                                        <p class="text-xs text-slate-500">{{$activity->created_at->format('h:i A')}}</p>
                                        @if ($activity->completed_at)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                            <p class="text-xs text-green-600">{{$activity->completed_at->format('h:i A')}}</p>
                                        @endif
                                    </div>
                                </div>
                                @if(!$activity->completed_at && $activity->created_at->format("d-m-Y") == Carbon\Carbon::now()->format("d-m-Y"))
                                    <button onclick="showConfirm({{$activity->id}}, 'complete')" class="ms-auto h-full cursor-pointer bg-green-400 border p-2 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-none duration-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>
                                    </button>
                                @else
                                    <button class="ms-auto h-full cursor-not-allowed bg-slate-400 border p-2 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-none duration-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>
                                    </button>
                                @endif
                            </div>
                            <hr class="opacity-[0.15] my-5">
                            @endforeach
                        @else 
                            
                        <div class="flex justify-center mt-24"> 
                            <div class="text-center">  
                                <img src="https://i.ibb.co.com/r2DN6C5r/1740293897405.png" alt="not found data img" draggable="false" class="w-[140px] opacity-50">
                                <p class="text-slate-400 font-semibold">No Activity here ..</p>
                            </div>
                        </div>

                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>

<script>
var modalConfirm = document.getElementById("modal-confirm");
var btnDelete = document.getElementById("btn_delete");
var btnComplete = document.getElementById("btn_complete");
var btnCancel = document.getElementById("btn_cancel");
var confirmForm = document.getElementById("confirmForm");
var formMethod = document.getElementById("formMethod");

function showConfirm(id, type) {
    modalConfirm.classList.remove("hidden");
    modalConfirm.classList.add("flex");

    confirmForm.setAttribute("action", "/activity/" + id);

    btnDelete.classList.add("hidden");
    btnComplete.classList.add("hidden");

    if (type === "complete") {
        formMethod.value = "PUT";
        btnComplete.classList.remove("hidden");
    } else {
        formMethod.value = "DELETE"; 
        btnDelete.classList.remove("hidden");
    }
}

btnCancel.addEventListener("click", function () {
    modalConfirm.classList.add("hidden");
    modalConfirm.classList.remove("flex");

    btnComplete.classList.add("hidden");
    btnDelete.classList.add("hidden");
});
</script>
</body>
</html>