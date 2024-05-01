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
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
        <div>
            <label for="male" class="inline-flex items-center">
                <input
                    type="radio"
                    v-model="form.gender"
                    id="male"
                    name="gender"
                    value="male"
                    class="form-radio text-gray-600" />
                <span class="ml-2">Male</span>
            </label>
            <label for="female" class="inline-flex items-center ml-6">
                <input
                    type="radio"
                    v-model="form.gender"
                    id="female"
                    name="gender"
                    value="female"
                    class="form-radio text-gray-600" />
                <span class="ml-2">Female</span>
            </label>
            <label for="other" class="inline-flex items-center ml-6">
                <input
                    type="radio"
                    v-model="form.gender"
                    id="other"
                    name="gender"
                    value="other"
                    class="form-radio text-gray-600" />
                <span class="ml-2">Other</span>
            </label>
        </div>
        <span class="text-red-600" v-if="form.errors.gender">
            {{ form.errors.gender }}
        </span>
    </div>
    <div class="mb-4">
        <label
            for="age"
            class="inline-block text-gray-700 text-sm font-bold mb-2">
            Age
        </label>
        <input
            type="number"
            name="age"
            id="age"
            class="form-input rounded-md border-gray-300 w-full"
            v-model="form.age">
    </div>
    <div class="mb-4">
        <label
            for="description"
            class="block text-gray-700 text-sm font-bold mb-2">
            Description
        </label>
        <textarea
            v-model="form.description"
            id="description"
            name="description"
            rows="3"
            class="form-textarea rounded-md border-gray-300 w-full">
        </textarea>
    </div>
    <div class="mb-4">
        <label
            for="profile_image"
            class="block text-gray-700 text-sm font-bold mb-2">
            Profile Image
        </label>
        <input
            type="file"
            @change="updateProfileImage"
            id="profile_image"
            name="profile_image"
            accept="image/*"
            class="form-input rounded-md border-gray-300 w-full" />
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
        components: { ButtonComponent },

        props: [
            "form"
        ],

        emits: [
            'submitted'
        ],

        methods: {
            updateProfileImage(event) {
                this.form.profile_image = event.target.files[0];
            },

            validateEmail() {
                axios.get(route("validateEmail", { email: this.form.email }))
                    .then((response) => {
                        if (Boolean(response.data)) this.form.errors.email = response.data.message;

                        else this.form.errors.email = "";
                    }
                );
            },
        },
    }
</script>