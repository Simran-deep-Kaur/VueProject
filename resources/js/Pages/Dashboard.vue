<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout :type="this.type">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>
    <main class="bg-white mt-20 sm:mx-auto">
      <div class="sm:px-4 lg:px-6 py-3 flex lg:justify-end flex-col sm:flex-row sm:justify-end items-center pt-5" >
        <div
          v-if="type != 'users'"
          class="bg-gray-500 text-gray-500 hover:bg-gray-700 font-bold rounded mx-2 mb-3 sm:mb-0 flex" >
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
            v-if="type != 'users'"
            v-model="filter"
            @change="applyFilter"
            class="bg-gray-500 text-white hover:bg-gray-700 font-bold rounded mx-2 inline-block"
            name="filter"
            id="filter" >
            <option value="null">Filter</option>
            <option value="all">All</option>
            <option value="below18">Below 18</option>
            <option value="above18">Above 18</option>
            <option
              v-for="(user, i) in users"
              :key="i"
              :value="user.id" >
              {{ user.name }}
            </option>
          </select>
          <Link
            :href="createRoute"
            class="bg-gray-500 text-white hover:bg-gray-700 font-bold py-2.5 px-4 rounded mx-2" >
            {{ type === "users" ? "Add User +" : "Add Employee +" }}
          </Link>
        </div>
      </div>
      <div v-if="type === 'users'">
        <UserDashboard :users="this.users" />
      </div>
      <div v-if="type === 'employees' || !Boolean(type)">
        <EmployeeDashboard
          :users="this.users"
          :paginateEmployees="this.paginateEmployees"/>
      </div>
      <div v-if="type != 'users'" id="down" ref="down">
        <div class="flex justify-center my-3">
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
    </main>
  </AuthenticatedLayout>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import EmployeeDashboard from "@/Pages/Employee/Index.vue";
  import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
  import { Head, Link } from "@inertiajs/vue3";
  import UserDashboard from "@/Pages/User/Index.vue";

  export default {
    components: {
      AuthenticatedLayout,
      EmployeeDashboard,
      Head,
      FontAwesomeIcon,
      Link,
      UserDashboard,
    },

    props: [
      "employees", "role", "type", "users"
    ],

    data() {
      return {
        filter: null,
        searchQuery: route().params.search || "",
        paginateEmployees: this.employees,
        page: 1,
      };
    },

    methods: {
      applyFilter() {
        this.$inertia.get(route("dashboard", { filter: this.filter }));
      },

      searchEmployees() {
        this.page = 1;

        window.history.pushState({}, "", route("dashboard", { search: this.searchQuery, filter: route().params.filter,}));

        axios.get(route("employees.search", { search: this.searchQuery, filter: route().params.filter,}))
          .then((response) => {
            if (response.data.employees.length) {
              this.paginateEmployees = response.data.employees;
            } else this.paginateEmployees = [];
          });
      },

      loadEmployee() {
        this.page++;

        axios.get(route("paginated-employees", { page: this.page, filter: route().params.filter, search: route().params.search }))
          .then((response) => {
            if (response.data.employees.length) {
              setTimeout(() => {
                this.paginateEmployees = [
                  ...this.paginateEmployees,
                  ...response.data.employees,
                ];
              }, 500);
            } else this.$refs.down.style.visibility = "hidden";
          });
      },
    },

    computed: {
      createRoute() {
        return this.type === "users" ? route("users.create") : route("employees.create");
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
