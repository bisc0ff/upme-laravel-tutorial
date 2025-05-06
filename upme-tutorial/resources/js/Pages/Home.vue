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
        <Head>
                <title>{{ $page.component }}</title>

                 <!-- use head-key if we want to set the meta tag for each page separately -->
                <meta   
                        head-key="description" 
                        name="description" 
                        content="home description"
                />
        </Head>
        <h1>This is the homepage.</h1>
        <!--  you can access any data in the page using the $page object -->
        
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th v-if="can.delete_user">Delete</th>
                        </tr>
                </thead>

                <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                        <td>
                        <img
                        :src="user.avatar ? 'storage/' + user.avatar : 'storage/avatars/default.jpg'"
                        class="avatar"
                        />
                        </td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ getDate(user.created_at) }}</td>
                        <td v-if="can.delete_user">
                                <button class="bg-red-500 w-6 h-6 rounded-full"></button>
                        </td>
                        </tr>
                </tbody>
        </table>

        <!-- Pagination Links -->
        <div>
                <PaginationLinks :paginator="users" />
        </div>
</template>