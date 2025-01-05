<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    track: {
        type: [Object, null],
        required: true
    },
    albumImage: {
        type: [String, null],
        required: true
    },
    voteType: {
        type: [Number, null],
        required: true
    }
});
</script>

<template>
    <Head title="Vote for a Track" />

    <AppLayout>
        <template #header>
            <!-- Heading -->
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Vote for a Track
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <section>
                        <header>
                            <!-- Secondary Heading -->
                            <h2 class="text-lg font-medium text-gray-900">
                                <span v-if="voteType !== null">
                                    🤘
                                </span>
                                <span v-else>
                                    👎
                                </span>
                                Your vote is in
                            </h2>

                            <p v-if="track !== null" class="mt-1 text-sm text-gray-600">
                                Thanks for your vote.
                            </p>
                        </header>

                    </section>

                    <section v-if="track !== null" class="mt-6">
                        <div class="flex flex-row">
                            <div class="pr-6">
                                <!-- Album Cover -->
                                <img :src="albumImage" 
                                    class="w-72 border border-slate-300 rounded-lg shadow"
                                    alt="Album cover"
                                >
                            </div>
                            <div class="flex flex-col justify-end">
                                <!-- Aminated Emoji -->
                                <div v-if="voteType === 1" class="pb-6">
                                    <img src="/images/thumbs-up.gif" alt="big-smile.gif" class="w-28 mx-auto">
                                </div>
                                <div v-if="voteType === -1" class="pb-6">
                                    <img src="/images/thumbs-down.gif" alt="crying.gif" class="w-28 mx-auto">
                                </div>

                                <!-- Track Name -->
                                <div class="text-gray-900 font-medium text-2xl">
                                    {{ track.title }}
                                </div>
                                <!-- Artists Name -->
                                <div class="text-gray-600 text-lg">
                                    {{ track.artist }}
                                </div>

                                <div class="text-xs text-gray-400 mt-4">
                                    Votes
                                </div>

                                <div class="flex flex-row mt-1">
                                    <span class="bg-gray-100 text-gray-800 font-medium me-2 px-2.5 py-1 rounded border border-gray-400">
                                        <span class="pr-3">
                                            <img src="/images/+1.png" class="inline w-6" :title="'Up votes: ' + track.up_votes ">
                                        </span>
                                        <span>
                                            {{ track.up_votes }}
                                        </span>
                                    </span>
                                    <span class="bg-gray-100 text-gray-800 font-medium me-2 px-2.5 py-1 rounded border border-gray-400">
                                        <span class="pr-3">
                                            <img src="/images/-1.png" class="inline w-6" :title="'Down votes: ' + track.down_votes">
                                        </span>
                                        <span>
                                            {{ track.down_votes }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>


    </AppLayout>

</template>