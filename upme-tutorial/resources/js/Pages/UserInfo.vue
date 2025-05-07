<script setup>
import TextInput from './Components/TextInput.vue';
import CheckBoxInput from './Components/CheckboxInput.vue';
import StatusDropdownInput from './Components/StatusDropdownInput.vue';
import CellphoneNumInput from './Components/CellphoneNumInput.vue';
import DeptDropdownInput from './Components/DeptDropdownInput.vue';

defineProps({
  user: Object,
  can: Object
});

</script>

<template>
    <Head title="Register" />
    
    <h1 class="title">Register a new account</h1>

    <div class="w-2/4 mx-auto"></div>
        <div>
            <div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4">Personal Information</h2>
                </div>

                <!-- Avatar + Name Fields -->
                <div class="flex flex-wrap gap-6">
                    <!-- Avatar Upload -->
                    <div class="flex flex-col items-center">
                        <div class="relative w-24 h-32 rounded-xl overflow-hidden border border-slate-300 shadow-sm">
                            <label for="avatar" class="absolute inset-0 grid content-end cursor-pointer bg-black/10">
                                <span class="bg-white/70 pb-2 text-center text-sm">Avatar</span>
                            </label>
                            <img
                                class="object-cover w-full h-full"
                                :src="user.avatar ? '/storage/' + user.avatar : 'storage/avatars/default.jpg'"
                                alt="Avatar Preview"
                            />
                        </div>
                    </div>

                    <!-- Name Fields -->
                    <div class="flex-1 grid grid-cols- md:grid-cols-3 gap-4">
                        <TextInput
                            name="First Name"
                            :model-value="user.first_name"
                            disabled
                        />
                        <TextInput
                            name="Middle Name"
                            :model-value="user.middle_name"
                            disabled
                        />
                        <TextInput
                            name="Last Name"
                            :model-value="user.last_name"
                            disabled
                        />
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4">Contact Information</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <CellphoneNumInput
                        name="Cellphone Number"
                        :model-value="user.cellphone_num"
                        disabled
                    />
                    <TextInput 
                        name="Email"
                        :model-value="user.email"
                        disabled 
                    />
                    <TextInput
                        name="Address"
                        :model-value="user.address"
                        disabled
                    />
                </div>
            </div>
            
            <div>
                <h2 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4">Company Position</h2>
            </div>
                <div class="flex flex-wrap space-x-6">
                    <DeptDropdownInput
                     name="Department"
                     :model-value="user.department"
                     disabled
                    />

                    <TextInput
                     name="Position"
                     :model-value="user.position"
                     disabled
                    />
                    
                    <StatusDropdownInput 
                     name="Status" 
                     :model-value="user.status"
                     disabled
                    />
  
                </div>

                <div class="w-full sm:w-auto">
                    <CheckBoxInput
                     name="is Admin?"
                     :model-value="Boolean(user.is_admin)"
                     disabled
                    />
                </div>
        </div>
</template>