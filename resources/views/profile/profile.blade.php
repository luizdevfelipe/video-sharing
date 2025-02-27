<x-layouts.main title="Video Sharing">
    <x-sections.profile-section name="{{ __('History') }}" :sources="['video1' => 'resources/images/image.png', 'video2' => 'resources/images/image.png']">
    </x-sections.profile-section>

    <x-sections.profile-section name="Playlists" :sources="['Pl1' => 'resources/images/image.png', 'Pl2' => 'resources/images/image.png']">
    </x-sections.profile-section>

    <x-modals.upload-video modalTitle="Add a new video" btText="+" class="absolute z-1 left-1/2 bottom-10 -translate-x-1/2">
        <form method="POST" action="{{ route('profile.video') }}" enctype="multipart/form-data" class="p-4 md:p-5">
            @csrf

            {{-- Title --}}
            <x-inputs.text label="Title" name="name" placeHolder="Title must contain a maximum of 255 characters" htmlAtributes="minlength=10 maxlength=255" />

            {{-- Description --}}
            <x-inputs.textarea label="Description" name="description" placeHolder="Description must contain a maximum of 3,000 characters" htmlAtributes="minlength=100 maxlength=3000" />

            {{-- Categories --}}
            <x-navigation.dropdown btText="Select a category">
                <li>
                    <x-inputs.checkbox name="categories" text="Lorem ipsum dolor sit amet." description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
                </li>
            </x-navigation.dropdown>

            {{-- Video --}}
            <x-inputs.drop-file name="video" />

            <x-inputs.submit text="Add Video" />
        </form>
    </x-modals.upload-video>
</x-layouts.main>