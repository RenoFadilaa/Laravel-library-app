<section class="space-y-6">
    <header class="border-b border-base-300 pb-4">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2">
            <i class="fa-regular fa-id-card"></i> {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-base-content/60">
            {{ __("Update your account's profile information, email address, and profile picture.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Personal Image Upload -->
        <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-base-300">
            <div class="relative group">
                <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-primary/30 shadow-md bg-base-200 flex items-center justify-center">
                    @if ($user->avatar)
                        <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar Preview" class="w-full h-full object-cover">
                    @else
                        <div id="avatar-initial" class="w-full h-full bg-primary text-primary-content flex items-center justify-center font-bold text-3xl uppercase">
                            {{ mb_substr($user->firstname, 0, 1) }}
                        </div>
                        <img id="avatar-preview" src="" alt="Avatar Preview" class="w-full h-full object-cover hidden">
                    @endif
                </div>
            </div>

            <div class="flex-1 text-center sm:text-left space-y-2">
                <h3 class="text-sm font-semibold text-base-content">Profile Picture</h3>
                <p class="text-xs text-base-content/60">Upload a square image (JPG, PNG, WEBP, max 2MB).</p>
                <input type="file" id="avatar" name="avatar" class="file-input file-input-bordered file-input-primary file-input-sm w-full max-w-xs rounded-xl" accept="image/*" onchange="previewImage(event)" />
                <x-input-error class="mt-1" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-control w-full">
                <label class="label" for="firstname">
                    <span class="label-text font-semibold text-base-content/80">{{ __('First Name') }}</span>
                </label>
                <input id="firstname" name="firstname" type="text" class="input input-bordered input-primary w-full rounded-xl" value="{{ old('firstname', $user->firstname) }}" required autofocus autocomplete="given-name" />
                <x-input-error class="mt-1" :messages="$errors->get('firstname')" />
            </div>

            <div class="form-control w-full">
                <label class="label" for="lastname">
                    <span class="label-text font-semibold text-base-content/80">{{ __('Last Name') }}</span>
                </label>
                <input id="lastname" name="lastname" type="text" class="input input-bordered input-primary w-full rounded-xl" value="{{ old('lastname', $user->lastname) }}" required autocomplete="family-name" />
                <x-input-error class="mt-1" :messages="$errors->get('lastname')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-control w-full">
                <label class="label" for="username">
                    <span class="label-text font-semibold text-base-content/80">{{ __('Username') }}</span>
                </label>
                <input id="username" name="username" type="text" class="input input-bordered input-primary w-full rounded-xl" value="{{ old('username', $user->username) }}" required autocomplete="username" />
                <x-input-error class="mt-1" :messages="$errors->get('username')" />
            </div>

            <div class="form-control w-full">
                <label class="label" for="email">
                    <span class="label-text font-semibold text-base-content/80">{{ __('Email') }}</span>
                </label>
                <input id="email" name="email" type="email" class="input input-bordered input-primary w-full rounded-xl" value="{{ old('email', $user->email) }}" required autocomplete="email" />
                <x-input-error class="mt-1" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-xs text-error">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="link link-primary font-semibold ml-1">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-1 font-medium text-xs text-success">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="btn btn-primary rounded-xl px-6 shadow-md shadow-primary/20 hover:scale-[1.02] transition duration-200">
                <i class="fa-regular fa-floppy-disk mr-1.5"></i> {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 2000)"
                     class="alert alert-success py-2 px-4 text-xs font-semibold rounded-xl w-fit flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ __('Saved successfully.') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>

