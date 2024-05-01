<template>
    <div class="mb-4">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
            Name
        </label>
        <input
            type="text"
            v-model="form.name"
            id="name"
            name="name"
            class="form-input rounded-md border-gray-300 w-full" />

        <span class="text-red-600" v-if="form.errors.name">
            {{ form.errors.name }}
        </span>
    </div>
    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2" >
            Email
        </label>
        <input
            type="text"
            v-model="form.email"
            id="email"
            name="email"
            class="form-input rounded-md border-gray-300 w-full" 
            @input="validateEmail()" />
        <span class="text-red-600" v-if="form.errors.email">
            {{ form.errors.email }}
        </span>
    </div>
    <div class="mb-4 mt-10">
        <button-component
            @click="$emit('submitted', form)"
            :processing="form.processing"
            role="button"
            type="button" />
    </div>
</template>

<script>
    import ButtonComponent from "@/Pages/ButtonComponent.vue";

    export default {
        components: {
            ButtonComponent
        },

        props: [
            "form"
        ],

        emits: [
            'submitted'
        ],

        methods:{
            validateEmail() {
                axios.get(route("validateEmail", { email: this.form.email }))
                    .then((response) => {
                        if (Boolean(response.data)) this.form.errors.email = response.data.message;

                        else this.form.errors.email = "";
                    }
                );
            },
        }
    }
</script>