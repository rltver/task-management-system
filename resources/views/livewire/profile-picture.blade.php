<div>
    <form wire:submit="saveProfilePhoto" class="my-6 w-full space-y-6" >
        <!-- preview profile picture -->
        <flux:avatar
            size="xl"
            src="{{ $profile_photo instanceof \Livewire\TemporaryUploadedFile
            ? $profile_photo->temporaryUrl()
            : Storage::url('img/profilePictures/' . $currentPhoto) }}"
        />

        <!-- input file where the user can select a new image -->
        <flux:input type="file" wire:model="profile_photo" />



        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">
                    {{ __('Update profile picture') }}
                </flux:button>
            </div>

            @error('profile_photo')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            @if (session()->has('message'))
                <span class="text-green-500">{{ session('message') }}</span>
            @endif
        </div>
    </form>
</div>
