<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    currentTrack: {
        type: Object,
        required: true
    }
});
</script>

<style scoped>
.disk {
    animation-duration: 7s;
    animation-iteration-count: infinite;
}
.disk {
        animation-name: spin;
        animation-timing-function: linear;
    }
    @keyframes spin {
        from { transform: rotate(0deg) }
        to { transform: rotate(360deg) }
    }
</style>

<template>
    <Head title="Home" />

    <AppLayout>
        <!-- <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Home
            </h2>
        </template> -->

        <div
            class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:pt-0"
        >

            <div class="bg-white px-8 py-6 shadow-md mt-10 rounded-lg" style="width: 490px;">

                <div class="grid grid-cols-1 text-center">
                    <div v-if="currentTrack === null" class="text-gray-600 font-bold tracking-widest">
                        ⏸️ PAUSED ⏸️
                    </div>
                    <div v-else class="text-gray-600 font-bold tracking-widest">
                        🎵 NOW PLAYING 🎵 
                    </div>
                </div>

                <!-- Cover & CD -->
                <div v-if="currentTrack === null" class="mt-10">
                    <div class="relative">
                        <img
                            class="relative rounded drop-shadow-md" 
                            style="z-index: 10; width: 300px;"
                            src="images/default_cover.png" 
                            alt="cover" 
                        >
                        <img 
                            class="absolute top-0 z-0"
                            style="width: 298px; top: 1px; left: 125px; z-index: 0;"
                            src="images/CD.png"
                            alt="cd"
                        >
                    </div>
                </div>

                <div v-else class="mt-10">
                    <div class="relative">
                        <div class=" bg-slate-500 rounded relative" style="width: 300px; height: 300px; z-index: 20;">
                            <img 
                                class="rounded drop-shadow-md"
                                style="z-index: 10; width: 300px;"
                                :src="currentTrack.cover"
                                alt="cover"
                            >
                        </div>
                        <img 
                            class="absolute disk top-0 z-0"
                            style="width: 298px; top: 1px; left: 125px; z-index: 0;"
                            src="images/CD.png"
                            alt="cd"
                        >
                    </div>
                </div>

                <!-- Track Info -->
                <div class="mt-5">
                    <div>
                        <span class="text-xs tracking-wide text-emerald-400">
                            Artist:
                        </span>
                        <span v-if="currentTrack === null" class="tracking-wide text-gray-400">
                            
                        </span>
                        <span v-else class="tracking-wide text-gray-400">
                            {{ currentTrack.artist }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs tracking-wide text-emerald-400">
                            Track:
                        </span>
                        <span v-if="currentTrack === null" class="tracking-wide text-gray-400">
                            
                        </span>
                        <span v-else class="tracking-wide text-gray-400">
                            {{ currentTrack.track }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs tracking-wide text-emerald-400">
                            Release Date:
                        </span>
                        <span v-if="currentTrack === null" class="tracking-wide text-gray-400">
                            
                        </span>
                        <span v-else class="tracking-wide text-gray-400">
                            {{ currentTrack.releaseDate }}
                        </span>
                    </div>
                </div>

                <!-- Vote For This Track -->
                <div v-if="currentTrack !== null">
                    <hr class="mt-10">

                    <div class="mt-5 grid grid-cols-1">
                        <div class="text-indigo-600 tracking-widest">
                            VOTE FOR THIS TRACK
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                    </div>

                    <div class="">
                        <button 
                            type="button" 
                            class="text-gray-700 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 uppercase tracking-widest"
                        >
                            Yeah
                            <img src="images/+1.png" alt="yeah" class="w-6 inline">
                        </button>
                        <button 
                            type="button" 
                            class="text-gray-700 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 uppercase tracking-widest"
                        >
                            Nah
                            <img src="images/-1.png" alt="nah" class="w-6 inline">
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </AppLayout>

</template>