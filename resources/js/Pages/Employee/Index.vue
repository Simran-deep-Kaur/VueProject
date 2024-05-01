<template>
        <div class=" sm:mx-auto bg-white">    
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
                                Profile Image
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium">
                                Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium">
                                Gender
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium">
                                Age
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium">
                                Description
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
                        <tr v-for="(employee, i) in paginateEmployees" :key="i">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ i + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img
                                    :src="employee.profile_url"
                                    alt="error"
                                    style="max-width: 50px; border-radius: 50%" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a :href="`mailto: ${employee.email}`">
                                    {{ employee.email }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.gender }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.age }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.description }}
                            </td>
                            <td class="whitespace-nowrap">
                                <Link
                                    :href="route('employees.show', employee)"
                                    class="mx-2 text-yellow-400 hover:text-yellow-600" >
                                        <font-awesome-icon icon="eye" />
                                </Link>
                            </td>
                            <td class="whitespace-nowrap">
                                <Link
                                    :href="route('employees.edit', employee)"
                                    class="mx-2 text-blue-400 hover:text-blue-700" >
                                        <font-awesome-icon icon="edit" />
                                </Link>
                            </td>
                            <td class="whitespace-nowrap">
                                <div
                                    style="cursor: pointer"
                                    @click.prevent="destroyEmployee(employee)"
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
            "paginateEmployees",
            "users"
        ],

        data() {
            return {
                page: 1,    
            };
        },

        methods: {
            destroyEmployee(employee) {
                if (confirm("Are you sure you want to delete this user?")) {
                    this.$inertia.delete(route("employees.delete", employee),{
                        onSuccess:()=>{
                            const employeeIndex = this.paginateEmployees.findIndex(i => i.id === employee.id);
                            this.paginateEmployees.splice(employeeIndex, 1);
                        }
                    })
                }
            },

        },
    };
</script>