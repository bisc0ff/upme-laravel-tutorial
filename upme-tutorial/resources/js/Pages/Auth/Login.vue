<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '../Components/TextInput.vue';
import AuthLayout from '../../Layouts/AuthLayout.vue';

//inertia has a form helper that makes it easier to handle forms
const form = useForm({
    email: '',
    password: '',
    remember: null
})

const submit = () => {
    console.log("submitted form", form);

    //inertia's useForm automatically handles passing the data to the post route
    form.post(route("login"), {
        onError: () => form.reset('password'), //reset the password fields on error, can configure for others too
    });
};

defineOptions({
  layout: AuthLayout
})
</script>


<template>
    <Head title="Login" />
    
    <h1 class="title">Login to your account</h1>

    <div class="w-2/4 mx-auto"></div>

    <form @submit.prevent="submit">

        <TextInput 
            name="email" 
            type="email"
            v-model="form.email" 
            :message="form.errors.email" 
        />

        <TextInput 
            name="password" 
            type="password" 
            v-model="form.password" 
            :message=" form.errors.password" 
        />

        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <input type="checkbox" v-model="form.remember" id="remember" />
                <label for="remember">Remember Me?</label>
            </div>
        </div>

        <div>
            <!-- :disabled:"form.processing" -> disables button while the form is being processed -->
            <button class="primary-btn" :disabled="form.processing">Login</button>
        </div>
    </form>
</template>