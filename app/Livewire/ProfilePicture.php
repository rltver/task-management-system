<?php


namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilePicture extends Component
{
    use WithFileUploads;

    public $profile_photo;

    public function mount(){}

    public function saveProfilePhoto()
    {
        $this->validate([
            'profile_photo' => 'image|max:1024', // limit size to 1MB
        ]);

        $user = Auth::user(); // get autenticated user

        // delete previous photo if not default
        if ($user->profile_photo && $user->profile_photo !== 'default.png') {
            Storage::disk('public')->delete('img/profilePictures/' . $user->profile_photo);
        }

        // save new photo and get file name
        $filename = $this->profile_photo->store('img/profilePictures', 'public');
        $user->profile_photo = basename($filename);
        $user->save();

        session()->flash('message', 'Profile picture succesfully updated.');
    }

    public function render()
    {
        $user = Auth::user();
        $currentPhoto = $user->profile_photo ?? 'default.png'; // if the user doesn't have a photo it gets the default one

        return view('livewire.profile-picture', [
            'currentPhoto' => $currentPhoto, // share the new photo to the front end
        ]);
    }
}



//
//namespace App\Livewire;
//
//use Livewire\Component;
//
//class ProfilePicture extends Component
//{
//    public function render()
//    {
//        return view('livewire.profile-picture');
//    }
//}
