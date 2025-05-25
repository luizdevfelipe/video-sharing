<x-layouts.main title="Video Sharing">
    <x-sections.profile-section name="{{ __('History') }}" :sources="['video1' => 'resources/images/image.png', 'video2' => 'resources/images/image.png']" />

    <x-sections.profile-section name="Playlists" :sources="['Pl1' => 'resources/images/image.png', 'Pl2' => 'resources/images/image.png']" />

    <x-modals.upload-video modalTitle="Add a new video" btText="+" class="absolute z-1 left-1/2 bottom-10 -translate-x-1/2">
        <form method="POST" action="{{ route('profile.video') }}" enctype="multipart/form-data" class="p-4 md:p-5">
            @csrf

            {{-- Title --}}
            <x-inputs.text label="Title" name="title" placeHolder="Title must contain a maximum of 255 characters" htmlAtributes="minlength=10 maxlength=255" />

            {{-- Description --}}
            <x-inputs.textarea label="Description" name="description" placeHolder="Description must contain a maximum of 3,000 characters" htmlAtributes="minlength=100 maxlength=3000" />

            {{-- Categories --}}
            <x-navigation.dropdown btText="Select a category" class="shadow-[0px_0px_0px_4px_rgba(0,0,0,0.75)] dark:shadow-[0px_0px_0px_4px_rgba(255,255,255,0.75)]">
                <li>
                    <x-inputs.checkbox name="categories" value="action" text="Ação" description="Filmes e vídeos repletos de adrenalina e cenas eletrizantes." />
                </li>
                <li>
                    <x-inputs.checkbox name="categories" value="comedy" text="Comédia" description="Conteúdos engraçados para entreter e divertir." />
                </li>
                <li>
                    <x-inputs.checkbox name="categories" value="drama" text="Drama" description="Histórias envolventes e emocionantes que exploram relações humanas." />
                </li>
                <li>
                    <x-inputs.checkbox name="categories" value="documentary" text="Documentário" description="Vídeos informativos e educativos baseados em fatos reais." />
                </li>
                <li>
                    <x-inputs.checkbox name="categories" value="horror" text="Terror" description="Filmes e vídeos assustadores para os fãs de suspense e medo." />
                </li>
                <li>
                    <x-inputs.checkbox name="categories" value="sci-fi" text="Ficção Científica" description="Histórias futurísticas, tecnologia avançada e mundos imaginários." />
                </li>
                <li>
                    <x-inputs.checkbox name="categories" value="animation" text="Animação" description="Conteúdos animados para todas as idades, desde infantis até adultos." />
                </li>
                <li>
                    <x-inputs.checkbox name="categories" value="music" text="Música" description="Videoclipes, apresentações ao vivo e documentários musicais." />
                </li>
                <li>
                    <x-inputs.checkbox name="categories" value="sports" text="Esportes" description="Partidas, documentários e conteúdos sobre esportes diversos." />
                </li>
                <li>
                    <x-inputs.checkbox name="categories" value="education" text="Educação" description="Vídeos didáticos e tutoriais para aprendizado e desenvolvimento pessoal." />
                </li>
            </x-navigation.dropdown>

            {{-- Video --}}
            <p class="text-black dark:text-white">{{ __("Video File") }}</p>
            <x-inputs.drop-file name="video" />

            {{-- Thumb --}}
            <p class="text-black dark:text-white">{{ __("Thumb File") }}</p>
            <x-inputs.drop-file name="thumbnail" />

            <x-inputs.submit text="Add Video" />
        </form>
    </x-modals.upload-video>
</x-layouts.main>