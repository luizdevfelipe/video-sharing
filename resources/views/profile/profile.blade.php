<x-layouts.main title="Video Sharing">
    <x-sections.profile-section name="{{ __('History') }}" :sources="['video1' => 'resources/images/image.png', 'video2' => 'resources/images/image.png']">
    </x-sections.profile-section>

    <x-sections.profile-section name="Playlists" :sources="['Pl1' => 'resources/images/image.png', 'Pl2' => 'resources/images/image.png']">
    </x-sections.profile-section>

    

    <x-modals.upload-video text="+" class="absolute z-1 left-1/2 bottom-10 -translate-x-1/2">
    </x-modals.upload-video>



</x-layouts.main>