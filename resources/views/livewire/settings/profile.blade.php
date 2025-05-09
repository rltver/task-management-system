<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            @csrf
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>



            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

{{--        <form wire:submit="saveProfilePhoto" class="my-6 w-full space-y-6" >--}}
{{--                <!-- Avatar con previsualización -->--}}
{{--                <flux:avatar--}}
{{--                    size="xl"--}}
{{--                    src="{{ Auth::user()->profile_photo instanceof \Livewire\TemporaryUploadedFile--}}
{{--                        ? Auth::user()->profile_photo->temporaryUrl()--}}
{{--                        : Storage::url('img/profilePictures/' . Auth::user()->profile_photo) }}"--}}
{{--                />--}}

{{--                <!-- Input para seleccionar la nueva imagen -->--}}
{{--                <flux:input type="file" wire:model="profile_photo" />--}}

{{--                @error('profile_photo')--}}
{{--                <span class="text-red-500 text-sm">{{ $message }}</span>--}}
{{--                @enderror--}}

{{--                <!-- Botón para guardar -->--}}


{{--                <!-- Mensaje de éxito -->--}}
{{--                @if (session()->has('message'))--}}
{{--                    <span class="text-green-500">{{ session('message') }}</span>--}}
{{--                @endif--}}

{{--            <div class="flex items-center gap-4">--}}
{{--                <div class="flex items-center justify-end">--}}
{{--                    <flux:button variant="primary" type="submit" class="w-full">--}}
{{--                        {{ __('Update profile picture') }}--}}
{{--                    </flux:button>--}}
{{--                </div>--}}

{{--                @if (session()->has('message'))--}}
{{--                    <span class="text-green-500">{{ session('message') }}</span>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </form>--}}
        <livewire:profile-picture />
        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
