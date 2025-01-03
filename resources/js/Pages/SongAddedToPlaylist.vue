<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    response: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <Head title="Song Added To Playlist" />

    <AppLayout>
        <template #header>
            <h2
                v-if="response.songAdded"
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Song added to playlist
            </h2>
            <h2
                v-else
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Song already exists in playlist
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <section>
                        <header>
                            <h2 v-if="response.songAdded"  class="text-lg font-medium text-gray-900">
                                🎸 Song added
                            </h2>
                            <h2 v-else  class="text-lg font-medium text-gray-900">
                                🤦‍♀️ Uhh ohh
                            </h2>

                            <p v-if="response.songAdded" class="mt-1 text-sm text-gray-600">
                                Your song had been added to the playlist.
                            </p>
                            <p v-else class="mt-1 text-sm text-red-500">
                                This banger is already in the playlist. I'm not going to add it twice.
                            </p>
                        </header>

                    </section>

                    <section class="mt-6">
                        <div class="flex flex-row">
                            <div class="pr-6">
                                <img :src="response.albumImage" 
                                    class="w-72 border border-slate-300 rounded-lg shadow"
                                    alt="Album cover"
                                >
                            </div>
                            <div class="flex flex-col justify-end">
                                <div v-if="response.songAdded" class="pb-10">
                                    <img src="/images/big-smile.gif" alt="big-smile.gif" class="w-28 mx-auto">
                                </div>
                                <div v-else class="pb-6">
                                    <img src="/images/crying.gif" alt="crying.gif" class="w-28 mx-auto">
                                </div>

                                <div class="text-gray-900 font-medium text-2xl">
                                    {{ response.trackName }}
                                </div>
                                <div class="text-gray-600 text-lg">
                                    {{ response.artist }}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>


    </AppLayout>

</template>