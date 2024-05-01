<template>

        <div class=" sm:mx-auto bg-white">
            <div class="sm:px-4 lg:px-6 py-3 flex lg:justify-end flex-col sm:flex-row sm:justify-end items-center pt-5" >
                <div class="bg-gray-500 text-gray-500 hover:bg-gray-700 font-bold rounded mx-2 mb-3 sm:mb-0 flex" >
                    <input
                        type="text"
                        v-model="searchQuery"
                        @keyup="searchEmployees"
                        placeholder="Search"
                        class="rounded sm:w-32 lg:w-48 w-full inline-block" />
                    <font-awesome-icon
                        icon="search"
                        class="px-3 my-3 text-white" />
                </div>
                <div>
                    <select
                        v-model="filter"
                        @change="applyFilter"
                        class="bg-gray-500 text-white hover:bg-gray-700 font-bold rounded mx-2 inline-block"
                        name="filter"
                        id="filter" >
                        <option value="null">Filter</option>
                        <option value="all">All</option>
                        <option value="below18">Below 18</option>
                        <option value="above18">Above 18</option>
                        <option v-for="(user, i) in users" :key="i" :value="user.id">
                            {{ user.name }}
                        </option>
                    </select>
                    <Link
                        :href="route('employees.create')"
                        class="bg-gray-500 text-white hover:bg-gray-700 font-bold py-2.5 px-4 rounded mx-2" >
                            Add Employee +
                    </Link>
                </div>
            </div>
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

                <div id="down" ref="down">
                    <div class="flex justify-center">
                        <svg
                            aria-hidden="true"
                            class="inline w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                            viewBox="0 0 100 101"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg" >
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

</template>
<script>
    import axios from "axios";
    import { Link } from "@inertiajs/vue3";
    import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";


    
    export default {
        components: { FontAwesomeIcon, Link},

        props: ["employees", "users"],

        data() {
            return {
                page: 1,
                paginateEmployees: this.employees,
                filter: null,
                searchQuery: route().params.search || "",
            };
        },

        methods: {
            applyFilter() {
                this.$inertia.get(route("dashboard", { filter: this.filter }));
            },

            searchEmployees() {
                this.page = 1;

                window.history.pushState({}, "", route('dashboard', { search: this.searchQuery, filter: route().params.filter }));

                axios.get(route("employees.search", { search: this.searchQuery, filter: route().params.filter, }))
                    .then((response) => {
                        if (response.data.employees.length) {
                            this.paginateEmployees = response.data.employees;
                        } else this.paginateEmployees = [];
                    });
            },

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

            loadEmployee() {
                this.page++;

                axios.get(route("paginated-employees", { page: this.page, filter: route().params.filter, search: route().params.search }))
                    .then((response) => {
                        if (response.data.employees.length) {
                            setTimeout(() => {
                                this.paginateEmployees = [...this.paginateEmployees, ...response.data.employees];
                            }, 500);
                        } else this.$refs.down.style.visibility = "hidden";
                    });
            },
        },

        mounted() {
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) this.loadEmployee();
            });

            const down = this.$refs.down;

            if (down) observer.observe(down);
            if (this.searchQuery) this.searchEmployees();
        },
    };
</script>