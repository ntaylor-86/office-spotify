<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    results: {
        type: Array,
        required: true
    }
});

const form = useForm({
    value: ''
});

function addTrack(trackUri) {
    console.log('going to add track ' + trackUri);
    var tempForm = useForm({
        uri: trackUri
    });
    tempForm.post(route('search.add-to-playlist'));
};
</script>

<template>
    <Head title="Search" />

    <AppLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Search
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Add a song to the playlist
                            </h2>
                            <!-- <p class="mt-1 text-sm text-gray-600">
                                Find a song to add to the companies playlist.
                            </p> -->
                        </header>

                        <form
                            @submit.prevent="form.get(route('search.index'), { preserveState: true })"
                            class="mt-6 space-y-6"
                        >
                            <div>
                                <InputLabel for="value" value="What do you want to listen to?" />
                                <TextInput
                                    id="value"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.value"
                                    required
                                    autofocus
                                />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>

        <div v-if="results.length > 0" class="pb-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Results <span class="text-gray-400">({{ results.length }})</span>
                            </h2>
                        </header>
                    </section>
                    <section>
                        <div v-for="(item, key) in results" class="grid grid-cols-4 gap-4 my-3 p-2 hover:bg-gray-100 rounded">
                            <div class="col-span-3">
                                <div class="flex flex-row">
                                    <div class="pr-2">
                                        <img :src="item.album.images[2].url" alt="Cover" class="rounded-md">
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="text-gray-900 font-medium">
                                            {{ item.name }}
                                        </div>
                                        <div class="w-full text-gray-600 text-sm">
                                            <span>
                                                <img 
                                                    src="images/explicit.svg" 
                                                    alt="Explicit" 
                                                    title="Explicit"
                                                    class="inline align-text-bottom mr-1"
                                                >
                                            </span>
                                            {{ item.artists[0].name }}
                                        </div>
                                        <div class="text-gray-400 text-xs">
                                            {{ item.album.release_date }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1 text-center content-center">
                                <PrimaryButton @click="addTrack(item.uri)">
                                    Add to playlist
                                </PrimaryButton>
                                <!-- <form method="post" :action="route('search.add-to-playlist')">
                                    <input type="text" name="uri" :value="item.uri" hidden>
                                    <PrimaryButton>
                                        Add to playlist
                                    </PrimaryButton>
                                </form> -->
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </AppLayout>

</template>