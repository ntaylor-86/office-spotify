<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <Head title="No Access Token" />
        
        <div>
            <span class="inline font-bold text-3xl align-middle mr-2 text-green-500">Office</span>
            <img src="images/spotify-ar21.svg" alt="Spotify" class="inline">
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-8 py-6 shadow-md sm:max-w-md sm:rounded-lg"
        >
            
            <div>
                <p>
                    You do not currently have a Spotify access token.
                </p>

                <p class="mt-3">
                    You will have to login to your Spotify account to create one.
                </p>

                <p class="mt-3">
                    Click the below button to continue to login to your Spotify account
                    and generate an access token.
                </p>

                <div class="mt-4 text-center">
                    <a href="/token/get">
                        <PrimaryButton>
                            Continue
                        </PrimaryButton>
                    </a>
                </div>
            </div>

        </div>
    </div>
</template>
