<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue'; // <-- Import the new layout
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthLayout> <!-- Use the new AuthLayout -->

        <Head title="Log in" />

        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-white">Welcome Back!</h2>
            <p class="text-sm text-gray-400">Log in to continue to your dashboard.</p>
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-teal-400 bg-teal-500/10 p-3 rounded-md">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" class="text-gray-300" />

                <TextInput id="email" type="email"
                    class="mt-1 block w-full bg-slate-700 border-slate-600 text-gray-200 focus:border-teal-500 focus:ring-teal-500"
                    v-model="form.email" required autofocus autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" class="text-gray-300" />

                <TextInput id="password" type="password"
                    class="mt-1 block w-full bg-slate-700 border-slate-600 text-gray-200 focus:border-teal-500 focus:ring-teal-500"
                    v-model="form.password" required autocomplete="current-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember"
                        class="!text-teal-500 focus:!ring-teal-600" />
                    <span class="ms-2 text-sm text-gray-400 hover:text-white">Remember me</span>
                </label>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="rounded-md text-sm text-gray-400 underline hover:text-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-slate-800">
                Forgot your password?
                </Link>

                <PrimaryButton
                    class="ms-4 bg-teal-500 hover:bg-teal-600 focus:bg-teal-600 active:bg-teal-700 focus:ring-offset-slate-800"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log In
                </PrimaryButton>
            </div>
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400">
                    Don't have an account?
                    <Link :href="route('register')" class="font-medium text-teal-400 hover:text-teal-300">
                    Sign up
                    </Link>
                </p>
            </div>
        </form>
    </AuthLayout>
</template>