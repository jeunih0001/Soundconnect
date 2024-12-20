<x-guest-layout>
  <div class="">
    <h2 class="text-primary my-4 text-center text-xl font-semibold lg:text-2xl">Signup</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Name -->
      <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>

      <!-- User Name -->
      <div class="mt-4">
        <x-input-label for="username" :value="__('Username')" />
        <x-text-input id="username" class="mt-1 block w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
      </div>

      <!-- Email Address -->
      <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
      </div>

      <div class="mt-4 flex items-center justify-end">
        <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" href="{{ route('login') }}"> {{ __('Already registered?') }} </a>

        <x-primary-button class="ml-4"> {{ __('Register') }} </x-primary-button>
      </div>
    </form>
  </div>
</x-guest-layout>

