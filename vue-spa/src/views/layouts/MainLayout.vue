<script setup>
import NavBar from '@/components/navigation/NavBar.vue'
import {onMounted} from 'vue';

onMounted(() => {
    document.getElementById('app').className = '';
    document.getElementById('app').classList.add('bg-white', 'dark:bg-black');
})
</script>

<template>

    <header>
         <NavBar />
    </header>

    <main>
        <slot />
    </main>

</template>
