<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />

    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:pt-0"
    >
        <div class="bg-white px-8 py-6 shadow-md mt-10 rounded-lg" style="width: 490px;">

            <div class="grid grid-cols-1 text-center">
                <div class="text-gray-600">
                    🎵 NOW PLAYING 🎵
                </div>
            </div>

            <div class="mt-10">
                <div class="relative">
                    <img 
                        class="relative rounded"
                        style="z-index: 10;"
                        src="https://i.scdn.co/image/ab67616d00001e02eda9478c39a21e1cdc6609ca"
                        alt="cover"
                    >
                    <img 
                        class="absolute disk top-0 z-0"
                        style="width: 300px; left: 115px; z-index: 0;"
                        src="https://i.postimg.cc/ZqhVJxg3/CD.png"
                        alt="cd"
                    >
                </div>
            </div>

            <div style="padding-top: 10px;">
                <div>
                    <span class="text-xs text-emerald-400">
                        Artist:
                    </span>
                    <span class="text-gray-400">
                        The Goo Goo Dolls
                    </span>
                </div>
                <div>
                    <span class="text-xs text-emerald-400">
                        Track:
                    </span>
                    <span class="text-gray-400">
                        Dizzy up the Girl
                    </span>
                </div>
                <div>
                    <span class="text-xs text-emerald-400">
                        Release Date:
                    </span>
                    <span class="text-gray-400">
                        1998
                    </span>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-1 text-center">
                <div class="text-gray-600">
                    VOTE FOR THIS TRACK
                </div>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-4">
                <div class="text-center text-2xl">
                    👍
                </div>
                <div class="text-center text-2xl">
                    👎
                </div>
            </div>

        </div>
    </div>
</template>