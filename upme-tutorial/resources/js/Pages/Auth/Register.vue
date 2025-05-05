<script setup>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import TextInput from '../Components/TextInput.vue';

//inertia has a form helper that makes it easier to handle forms
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const submit = () => {
    console.log("submitted form", form);

    //inertia's useForm automatically handles passing the data to the post route
    form.post(route("register"), {
        onError: () => form.reset('password', 'password_confirmation'), //reset the password fields on error, can configure for others too
        
        onSuccess: () => router.visit('/')
    });
};

</script>

<template>
    <Head title="Register" />
    
    <h1 class="title">Register a new account</h1>

    <div class="w-2/4 mx-auto"></div>

    <form @submit.prevent="submit">

        <TextInput name="name" v-model="form.name" :message="form.errors.name" />
        <TextInput name="email" v-model="form.email" :message="form.errors.email" />
        <TextInput name="password" v-model="form.password" :message=" form.errors.password" />
        <TextInput name="Confirm Password" v-model="form.password_confirmation" />

        <div>
            <p class="text-slate-600 mb-2">Already a user? <a href="#" class="text-link">Login here!</a></p>
            <!-- :disabled:"form.processing" -> disables button while the form is being processed -->
            <button class="primary-btn" :disabled="form.processing">Register</button>
        </div>
    </form>
</template>