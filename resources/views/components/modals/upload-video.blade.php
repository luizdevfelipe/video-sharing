{{-- Modal toggle --}}
<button id="toggleUploadVideoModal" data-modal-target="crud-modal" data-modal-toggle="crud-modal" {{ $attributes->merge( ['class' => "block pb-1 px-3 size-16 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-[50%] text-[1.4em] text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"] ) }} type="button">
    {{ $btText }}
</button>

{{-- Main modal --}}
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-white/50 dark:bg-gray-800/50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        {{-- Modal content --}}
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            {{-- Modal header --}}
            <div class="flex items-center justify-between p-2 md:p-3 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __($modalTitle) }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            {{-- Modal body --}}
            {{ $slot }}
        </div>
    </div>
</div>