<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthLayout>

        <Head title="Register" />

        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-white">Create Your Account</h2>
            <p class="text-sm text-gray-400">Join us to revolutionize your travel planning.</p>
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" class="text-gray-300" />

                <TextInput id="name" type="text"
                    class="mt-1 block w-full bg-slate-700 border-slate-600 text-gray-200 focus:border-teal-500 focus:ring-teal-500"
                    v-model="form.name" required autofocus autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" class="text-gray-300" />

                <TextInput id="email" type="email"
                    class="mt-1 block w-full bg-slate-700 border-slate-600 text-gray-200 focus:border-teal-500 focus:ring-teal-500"
                    v-model="form.email" required autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" class="text-gray-300" />

                <TextInput id="password" type="password"
                    class="mt-1 block w-full bg-slate-700 border-slate-600 text-gray-200 focus:border-teal-500 focus:ring-teal-500"
                    v-model="form.password" required autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" class="text-gray-300" />

                <TextInput id="password_confirmation" type="password"
                    class="mt-1 block w-full bg-slate-700 border-slate-600 text-gray-200 focus:border-teal-500 focus:ring-teal-500"
                    v-model="form.password_confirmation" required autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-6 flex items-center justify-end">
                <Link :href="route('login')"
                    class="rounded-md text-sm text-gray-400 underline hover:text-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-slate-800">
                Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4 bg-teal-500 hover:bg-teal-600 focus:bg-teal-600 active:bg-teal-700 focus:ring-offset-slate-800"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </AuthLayout>
</template>