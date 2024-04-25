<template>
    <Head title="Edit User" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User
            </h2>
        </template>

        <div class="flex max-w-2xl mx-auto sm:px-6 lg:px-8 py-10 bg-white overflow-hidden shadow-sm sm:rounded-lg my-10">
            <form
                class="w-full mb-6"
                enctype="multipart/form-data" >
               <shared-form :form="form" @submitted="(form) => submit(form)" />
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import SharedForm from './SharedForm.vue';
import { useForm } from "@inertiajs/vue3";

export default {
    components: {
        AuthenticatedLayout,
        Head,
        SharedForm,
    },
    
    props: ["employee"],

    data() {
        return {
            form: useForm({
                _method: "PUT",
                name: this.employee.name,
                email: this.employee.email,
                gender: this.employee.gender,
                age: this.employee.age,
                description: this.employee.description,
                profile_image: "",
            }),
        };
    },
    methods: {
        submit(form) {
            form.post(route("employees.update", this.employee));
        },
    },
};
</script>
