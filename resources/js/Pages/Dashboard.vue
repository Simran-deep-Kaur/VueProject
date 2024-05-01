<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout :type="this.type">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
      <main>
        <div class="bg-white mt-20 sm:mx-auto" >
          <!-- <div v-if="role == 'super-admin'">
            <button
              @click="$inertia.visit(route('dashboard', { type: 'users' }))"
              class="bg-green-500 text-white py-2.5 px-4 rounded mx-2" >
                User Dashboard
            </button>
            <button
              @click="$inertia.visit(route('dashboard', { type: 'employees' }))"
              class="bg-red-500 text-white py-2.5 px-4 rounded mx-2" >
                Employee Dashboard
            </button>
          </div> -->
        </div>
        <div v-if="(type === 'users') ">
          <UserDashboard :users="this.users"/>
        </div>

        <div v-if="(type === 'employees') || !Boolean(type)">
          <EmployeeDashboard :employees="this.employees" :users="this.users"/>
        </div>
      </main>
    </AuthenticatedLayout>
</template>

<script>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import EmployeeDashboard from "@/Pages/Employee/Index.vue";
  import { Head } from "@inertiajs/vue3";
  import UserDashboard from '@/Pages/User/Index.vue';

  export default {
    components: { AuthenticatedLayout, EmployeeDashboard, Head, UserDashboard },

    props:['employees','role', 'type', 'users'],
  }
</script>