<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
                <div class=""mt-4>
                    <x-label for="phone" :value="__('Phone')" />

                    <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus />
                </div>
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>
            <div class="mt-4">
                <select class="form-control"
                        name="state_id" required>
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}"
                            {{$state->state}}>{{ $state->state }}</option>
                    @endforeach
                </select>
                @if ($errors->has('state_id'))
                    <span class="text-danger text-left">{{ $errors->first('state_id') }}</span>
                @endif
            </div>
            <div class="mt-4">
                    <select class="form-control"
                            name="dp_id" required>
                        <option value="">Select DP</option>
                        @foreach($dps as $dp)
                            <option value="{{ $dp->id }}"
                                {{$dp->dps}}>{{ $dp->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('dp_id'))
                        <span class="text-danger text-left">{{ $errors->first('dp_id') }}</span>
                    @endif
            </div>
            <div class="mt-4">
                    <select class="form-control"
                            name="sccu_id" required>
                        <option value="">Select SCCU</option>
                        @foreach($sccus as $sccu)
                            <option value="{{ $sccu->id }}"
                                {{$sccu->sccus}}>{{ $sccu->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('sccu_id'))
                        <span class="text-danger text-left">{{ $errors->first('sccu_id') }}</span>
                    @endif
            </div>

                <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
