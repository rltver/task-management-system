<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="validateRecaptchaAndRegister" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
        />

        <flux:input
            type="hidden"
            id="recaptcha_token"
            name="recaptcha_token"
            wire:model="recaptcha_token"
        />

        <div class="flex items-center justify-center">
            <flux:button
                type="submit"
                variant="primary"
                class="w-full"
                wire:loading.remove
                wire:target="register"
            >
                {{ __('Create account') }}
            </flux:button>

            <span wire:loading wire:target="register" class="text-gray-500">
                Loading...
            </span>
        </div>
    </form>

    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            grecaptcha.ready(function () {
                Livewire.on("getRecaptchaToken", (componentId) => {
                    grecaptcha.execute("{{ config('services.recaptcha.site_key') }}", { action: "register" }).then(function (token) {
                        Livewire.find(componentId[0].componentId).set("recaptcha_token", token);

                        // send the form to livewire
                        setTimeout(() => {
                            Livewire.find(componentId[0].componentId).call("register");
                        }, 500);
                    });
                });
            });
        });
    </script>



    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>



</div>
