<template>
    <Head title="View User" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                View User
            </h2>
        </template>

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 py-10 bg-white overflow-hidden shadow-sm sm:rounded-lg my-10">
            <div class="flex justify-center">
                <div>
                    <p class="my-2">
                        <strong>Name:</strong> {{ user.name }}
                    </p>
                    <p class="my-2">
                        <strong>Email:</strong> {{ user.email }}
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import { Head } from "@inertiajs/vue3";

    export default {
        components: {
            AuthenticatedLayout,
            Head,
        },
        
        props: [
            "user"
        ],
    };
</script>