<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = Auth::user();

        if ($user->isSuperAdmin() || $user->hasRole(['admin'])) {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
            return;
        } elseif ($user->isTeknisi()) {
            $this->redirectIntended(default: route('admin.orders', absolute: false), navigate: true);
            return;
        }

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="max-w-md mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
        <p class="text-gray-500 text-sm mt-1">Please enter your details to sign in.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <x-text-input wire:model="form.email" id="email" class="block w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition-colors shadow-sm" type="email" name="email" required autofocus autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <x-text-input wire:model="form.password" id="password" class="block w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gray-900 focus:ring-gray-900 transition-colors shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center gap-2 cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                <span class="text-sm text-gray-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-gray-900 text-white rounded-xl font-semibold text-sm hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-950 transition translate-y-0 hover:-translate-y-0.5 shadow-lg shadow-gray-900/20">
            Sign In
        </button>
    </form>
</div>
