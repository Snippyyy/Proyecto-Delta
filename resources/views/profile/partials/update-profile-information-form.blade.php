<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 px-4 py-3 rounded relative mt-3" role="alert">
                <strong class="font-bold text-green-500">Success!</strong>
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Provincia -->
        <div class="mt-4">
            <x-input-label for="province" :value="__('Province')"/>
            @include('components.province-select')
            <x-input-error :messages="$errors->get('province')" class="mt-2"/>
        </div>

        <!-- Direccion -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')"/>
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $user->address)" required
                          autofocus autocomplete="address"/>
            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
        </div>

        <!-- Codigo Postal -->
        <div class="mt-4">
            <x-input-label for="postal_code" :value="__('Postal Code')"/>
            <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code', $user->postal_code)" required
                          autofocus autocomplete="postal_code"/>
            <x-input-error :messages="$errors->get('postal_code')" class="mt-2"/>
        </div>

        <!-- Numero de telefono -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')"/>
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $user->phone_number)" required
                          autofocus autocomplete="phone_number"/>
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
