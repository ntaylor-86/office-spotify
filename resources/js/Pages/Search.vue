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

function search() {
    console.log('going to search for ' + this.form.value);
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
                            <p class="mt-1 text-sm text-gray-600">
                                Find a song to add to the companies playlist.
                            </p>
                        </header>

                        <form
                            @submit.prevent="form.get(route('search.index'))"
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
                                <PrimaryButton
                                    @click="search"
                                    :disabled="form.processing"
                                >
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>

    </AppLayout>

</template>