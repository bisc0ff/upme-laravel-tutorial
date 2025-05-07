<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '../Components/TextInput.vue';
import CheckBoxInput from '../Components/CheckboxInput.vue';
import DropdownInput from '../Components/DeptDropdownInput.vue';
import StatusDropdownInput from '../Components/StatusDropdownInput.vue';
import CellphoneNumInput from '../Components/CellphoneNumInput.vue';

//inertia has a form helper that makes it easier to handle forms
const form = useForm({
    first_name: '',
    middle_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
    cellphone_num: `+639`,
    position: '',
    department: '',
    status: '',
    address: '',
    is_admin: false,
    avatar: null,
    preview: null
})

const change = (e) => {
    form.avatar = e.target.files[0];
    form.preview = URL.createObjectURL(e.target.files[0]);
};

const submit = () => {
    console.log("submitted form", form);

    //inertia's useForm automatically handles passing the data to the post route
    form.post(route("register"), {
        onError: () => form.reset('password', 'password_confirmation'), //reset the password fields on error, can configure for others too
    });
    
};

</script>

<template>
    <Head title="Register" />
    
    <h1 class="title">Register a new account</h1>

    <div class="w-2/4 mx-auto"></div>

    <form @submit.prevent="submit">
        
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
                            <input type="file" @input="change" id="avatar" hidden />
                            <img
                                class="object-cover w-full h-full"
                                :src="form.preview ?? 'storage/avatars/default.jpg'"
                                alt="Avatar Preview"
                            />
                        </div>
                        <p class="text-sm text-red-500 mt-2">{{ form.errors.avatar }}</p>
                    </div>


                    <!-- Name Fields -->
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <TextInput
                            name="First Name"
                            v-model="form.first_name"
                            :message="form.errors.first_name"
                        />
                        <TextInput
                            name="Middle Name"
                            v-model="form.middle_name"
                            :message="form.errors.middle_name"
                        />
                        <TextInput
                            name="Last Name"
                            v-model="form.last_name"
                            :message="form.errors.last_name"
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
                        v-model="form.cellphone_num"
                        :message="form.errors.cellphone_num"
                    />
                    <TextInput 
                        name="Email" 
                        v-model="form.email" 
                        :message="form.errors.email" 
                    />
                    <TextInput
                        name="Address"
                        v-model="form.address"
                        :message="form.errors.address"
                    />
                </div>
            </div>
            
            <div>
                <h2 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4">Company Position</h2>
            </div>
                <div class="flex flex-wrap space-x-6">
                    <DropdownInput
                    name="Department"
                    v-model="form.department"
                    :message="form.errors.department"
                    />
                    
                    <TextInput
                    name="Position"
                    v-model="form.position"
                    :message="form.errors.position"
                    />
                    
                    <StatusDropdownInput 
                    name="Status" 
                    v-model="form.status" 
                    :message="form.errors.status" 
                    />
                </div>

                <div class="w-full sm:w-auto">
                    <CheckBoxInput
                    name="is Admin?"
                    v-model="form.is_admin"
                    :message="form.errors.is_admin"
                    />
                
                <div class="flex space-x-6">
                    <TextInput
                    name="password"
                    type="password"
                    v-model="form.password"
                    :message="form.errors.password"
                    />
            
                    <TextInput
                    name="Password Confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    :message="form.errors.password_confirmation"
                    />
                </div>
            </div>
        </div>

        <div>
            <p class="text-slate-600 mb-2">Already a user? <a href="#" class="text-link">Login here!</a></p>
            <!-- :disabled:"form.processing" -> disables button while the form is being processed -->
            <button class="primary-btn" :disabled="form.processing">Register</button>
        </div>
    </form>
</template>