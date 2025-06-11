<script setup>
import PaginationLinks from "./Components/PaginationLinks.vue"
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import AppSidebar from "./Components/AppSidebar.vue";

const props = defineProps({
    users: Object,
    searchTerm: String,
    can: Object
});

const search = ref(props.searchTerm);

// watches the search input and fetches the value from the search input field
watch(search, debounce(
    (query) => router.get('/dashboard', { search: query }, { preserveState: true }), 300
));

// Format date
const getDate = (date) =>
    new Date(date).toLocaleDateString("en-us", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
</script>

<template>
    <div class="flex h-full bg-gray-50 overflow-visible">

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-visible">
            <Head title="Dashboard" />
            
            <!-- Flash Message -->
            <div v-if="$page.props.flash.message" 
                 class="p-4 bg-green-200 text-green-800 border-l-4 border-green-600">
                {{ $page.props.flash.message }}
            </div>
            
            <!-- Welcome Banner -->
            <div class="bg-white shadow-sm p-4 border-b">
                <h1 class="text-2xl font-semibold text-gray-800">
                    Welcome back, {{ $page.props.auth.user.first_name }}!
                </h1>
            </div>

            <!-- Main Container - Full Height -->
            <main class="flex-1 overflow-auto">
                <div class="h-full p-6">
                    <div class="bg-white rounded-lg shadow-sm p-6 h-full">
                        <!-- Search & Controls -->
                        <div class="mb-6">
                            <div class="relative">
                                <input 
                                    type="search" 
                                    class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                    placeholder="Search by name..." 
                                    v-model="search" 
                                />
                            </div>
                        </div>

                        <!-- Employee Table -->
                        <div class="overflow-x-auto flex-1">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avatar</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hired Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" v-if="can.delete_user && can.update_user">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="user in users.data" 
                                        :key="user.id" 
                                        class="hover:bg-gray-50 cursor-pointer transition-colors duration-150"
                                        @click="() => router.visit(route('user.profile', user.id))">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img 
                                                :src="user.avatar ? '/storage/' + user.avatar : '/storage/avatars/default.jpg'" 
                                                class="h-10 w-10 rounded-full object-cover" 
                                                alt="User avatar"
                                            />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ user.last_name + ', ' + user.first_name + ' ' + user.middle_name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ user.email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ getDate(user.date_hired) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ user.department }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ user.position }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                  :class="user.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                                {{ user.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" v-if="can.delete_user && can.update_user">
                                            <div class="flex gap-2" @click.stop>
                                                <button 
                                                    @click="router.visit(route('user.edit', user.id))" 
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-2 py-1 rounded transition"
                                                    title="Update">
                                                    Update
                                                </button>
                                                
                                                <button 
                                                    @click="router.delete(route('users.softDel', user.id))" 
                                                    v-if="user.id !== $page.props.auth.user.id && user.status === 'Active'"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded transition"
                                                    title="Soft-Delete">
                                                    Soft-Delete
                                                </button>
                                                
                                                <button 
                                                    @click="router.delete(route('users.permaDel', user.id))" 
                                                    v-if="user.id !== $page.props.auth.user.id && user.status === 'Active'"
                                                    class="bg-red-800 hover:bg-red-900 text-white text-xs px-2 py-1 rounded transition"
                                                    title="Perma-Delete">
                                                    Perma-Delete
                                                </button>
                                                
                                                <button 
                                                    @click="router.patch(route('users.restore', user.id))" 
                                                    v-if="user.id !== $page.props.auth.user.id && user.status === 'Deleted'"
                                                    class="bg-green-500 hover:bg-green-600 text-white text-xs px-2 py-1 rounded transition"
                                                    title="Restore">
                                                    Restore
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            <PaginationLinks :paginator="users" />
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>