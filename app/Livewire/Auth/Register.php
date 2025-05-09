<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public $recaptcha_token;

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        $this->loading = true; // instance the loading

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'recaptcha_token' => ['required'],
        ]);

        if (!$this->validateRecaptcha($this->recaptcha_token)) {
            session()->flash('error', 'reCAPTCHA verification failed.');
            $this->loading = false; // when the verification ends turn loading to false
            return;
        }

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);


        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    private function validateRecaptcha($token)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
        ]);

        return $response->json()['success'] ?? false;
    }
    public function validateRecaptchaAndRegister()
    {
        // Trigger the event to obtain the token before registering
        $this->dispatch("getRecaptchaToken", ['componentId' => $this->getId()]);
    }
}
