<script setup>
import PaginationLinks  from "./Components/PaginationLinks.vue"
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
        (query) => router.get('/', { search: query}, {preserveState: true}))
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
            <p class="p-4 bg-green-200" v-if="$page.props.flash.greet"> {{ $page.props.flash.greet }}</p>
            <h1 class="title">
                Welcome back, {{ $page.props.auth.user.first_name }}!
            </h1>
        </div>

        <div>
                <div class="flex justify-end mb-4">
                        <div class="w-1/4">
                                <input 
                                 type="search" 
                                 placeholder="Search..."
                                 v-model="search"/>
                        </div>
                </div>
        </div> 
        <table>
                <thead>
                        <tr class="bg-slate-300">
                        <th>Avatar</th>
                        <th>Employee Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th v-if="can.delete_user">Actions</th>
                        </tr>
                </thead>

                <tbody>
                        <Link
                         v-for="user in users.data"
                         :key="user.id"
                         :href="route('user.profile', user.id)"
                         as="tr"
                         class="hover:bg-slate-100 cursor-pointer transition"
                        >
                        <td>
                        <img
                        :src="user.avatar ? 'storage/' + user.avatar : 'storage/avatars/default.jpg'"
                        class="avatar"
                        />
                        </td>
                        <td>{{ user.last_name + ', ' + user.first_name + ' ' + user.middle_name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ getDate(user.created_at) }}</td>
                        <td v-if="can.delete_user" class="space-x-2">
                                <button
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-2 py-1 rounded-md transition"
                                        title="Update"
                                >
                                Update
                                </button>
                                <button
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded-md transition"
                                        title="Delete"
                                >
                                Delete
                                </button>
                                </td>
                        </Link>
                </tbody>
        </table>
        
        <div>
                <PaginationLinks :paginator="users" />
        </div>
</template>