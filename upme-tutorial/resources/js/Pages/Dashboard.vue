<script setup>
import PaginationLinks from "./Components/PaginationLinks.vue"
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';

const props = defineProps({
        users: Object,
        searchTerm: String,
        can: Object
});

const search = ref(props.searchTerm);

// watches the search input and fetches the value from the search input field
watch(search, debounce(
        (query) => router.get('/dashboard', { search: query }, { preserveState: true }))
);


// Format date
const getDate = (date) =>
        new Date(date).toLocaleDateString("en-us", {
                year: "numeric",
                month: "long",
                day: "numeric",
        });



</script>

<template>

        <Head title="Dashboard" />
        <div>
                <p class="p-4 bg-green-200" v-if="$page.props.flash.message"> {{ $page.props.flash.message }}</p>
                <h1 class="title">
                        Welcome back, {{ $page.props.auth.user.first_name }}!
                </h1>
        </div>

                

        <div class="w-full flex justify-center">
                <div class="flex flex-col items-start space-y-4" style="width: max-content;">
                        
                        <div>
                                <div>
                                        <input type="search" placeholder="Search..." v-model="search" />
                                </div>
                        </div>
        
                        <div>
                                
                                <table class="mx-auto">
                                <thead>
                                        <tr class="bg-slate-300">
                                                <th>Avatar</th>
                                                <th>Employee Name</th>
                                                <th>Email</th>
                                                <th>Hired Date</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>Status</th>
                                                <th v-if="can.delete_user && can.update_user">Actions</th>
                                        </tr>
                                </thead>
                
                                <tbody>
                                        <tr v-for="user in users.data" :key="user.id"
                                                class="hover:bg-slate-100 cursor-pointer transition"
                                                @click="() => router.visit(route('user.profile', user.id))">
                                                <td>
                                                        <img :src="user.avatar ? '/storage/' + user.avatar : '/storage/avatars/default.jpg'"
                                                                class="avatar" />
                                                </td>
                                                <td>{{ user.last_name + ', ' + user.first_name + ' ' + user.middle_name }}</td>
                                                <td>{{ user.email }}</td>
                                                <td>{{ getDate(user.date_hired) }}</td>
                                                <td>{{ user.department }}</td>
                                                <td>{{ user.position }}</td>
                                                <td>{{ user.status }}</td>
                
                                                <td v-if="can.delete_user && can.update_user">
                                                        <div class="flex gap-2 items-center" @click.stop>
                                                                <button @click="router.visit(route('user.edit', user.id))"
                                                                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-2 py-1 rounded-md transition whitespace-nowrap"
                                                                        title="Update">
                                                                        Update
                                                                </button>
                
                                                                <button @click="router.delete(route('users.softDel', user.id))"
                                                                        v-if="user.id !== $page.props.auth.user.id && user.status === 'Active'"
                                                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded-md transition whitespace-nowrap"
                                                                        title="Soft-Delete">
                                                                        Soft-Delete
                                                                </button>
                
                                                                <button @click="router.delete(route('users.permaDel', user.id))"
                                                                        v-if="user.id !== $page.props.auth.user.id && user.status === 'Active'"
                                                                        class="bg-red-800 hover:bg-red-900 text-white text-xs px-2 py-1 rounded-md transition whitespace-nowrap"
                                                                        title="Perma-Delete">
                                                                        Perma-Delete
                                                                </button>
                
                                                                <button @click="router.patch(route('users.restore', user.id))"
                                                                        v-if="user.id !== $page.props.auth.user.id && user.status === 'Deleted'"
                                                                        class="bg-green-500 hover:bg-green-600 text-white text-xs px-2 py-1 rounded-md transition whitespace-nowrap"
                                                                        title="Restore">
                                                                        Restore
                                                                </button>
                                                        </div>
                                                </td>
                
                
                                        </tr>
                                </tbody>
                                </table>
        
                        </div>
        
                        <div class="">
                                <PaginationLinks :paginator="users" />
                        </div>


                </div>

        </div>
        
       

</template>