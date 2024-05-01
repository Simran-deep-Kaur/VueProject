<template>
    <div class="sm:mx-auto bg-white">
        <div
            style="overflow-x: scroll"
            class="table-scroll mx-auto sm:px-6 lg:px-8 p-8" >
            <table class="divide-y divide-gray-200 dark:divide-gray-700 w-full" >
                <thead class="bg-gray-50 dark-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium">
                            #
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium">
                            Email
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium"
                            colspan="3" >
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody
                    class="divide-y divide-gray-200 dark:divide-gray-700" >
                    <tr v-for="(user, i) in users" :key="i">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ i + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ user.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a :href="`mailto: ${user.email}`">
                                {{ user.email }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap">
                            <Link
                                :href="route('users.show', user)"
                                class="mx-2 text-yellow-400 hover:text-yellow-600" >
                                    <font-awesome-icon icon="eye" />
                            </Link>
                        </td>
                        <td class="whitespace-nowrap">
                            <Link
                                :href="route('users.edit', user)"
                                class="mx-2 text-blue-400 hover:text-blue-700" >
                                    <font-awesome-icon icon="edit" />
                            </Link>
                        </td>
                        <td class="whitespace-nowrap">
                            <div
                                style="cursor: pointer"
                                @click.prevent="destroyUser(user)"
                                class="mx-2 text-red-500 hover:text-red-700" >
                                    <font-awesome-icon icon="trash" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
 
</template>
<script>
    import { Link } from "@inertiajs/vue3";
    import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

     export default {
        components: {
            FontAwesomeIcon,
            Link
        },

        props: [
            'users'
        ],
        
        methods: {
            destroyUser(user) {
                if (confirm("Are you sure you want to delete this user?")) {
                    this.$inertia.delete(route("user.destroy", user),{
                        onError: (error)=>{
                            alert(error.error);
                        }
                    })
                }
            },
        }
    };
</script>