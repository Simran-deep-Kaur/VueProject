<template>
    <Head title="Create User" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create User
            </h2>
        </template>

        <div class="flex max-w-2xl mx-auto sm:px-6 lg:px-8 py-10 bg-white overflow-hidden shadow-sm sm:rounded-lg my-10" >
            <form
              enctype="multipart/form-data"
              class="w-full mb-6 px-4" >
                <shared-form :form="form" @submitted="(form) => submit(form)"/>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import SharedForm from '../Employee/SharedForm.vue';
import { useForm } from "@inertiajs/vue3";

export default {
    components: {
        AuthenticatedLayout,
        Head,
        SharedForm,
    },
    data() {
        return {
            form: useForm({
                name: "",
                email: "",
                gender: "",
                age: "",
                description: "",
                profile_image: ""
            }),
        };
    },
    methods: {
        submit (form) {
            form.post(route("employees.store"));
        },
    }
};
</script>