<section class="space-y-6">
    <header class="border-b border-base-300 pb-4">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2">
            <i class="fa-solid fa-key"></i> {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-base-content/60">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="form-control w-full max-w-md">
            <label class="label" for="update_password_current_password">
                <span class="label-text font-semibold text-base-content/80">{{ __('Current Password') }}</span>
            </label>
            <input id="update_password_current_password" name="current_password" type="password" class="input input-bordered input-primary w-full rounded-xl" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        <div class="form-control w-full max-w-md">
            <label class="label" for="update_password_password">
                <span class="label-text font-semibold text-base-content/80">{{ __('New Password') }}</span>
            </label>
            <input id="update_password_password" name="password" type="password" class="input input-bordered input-primary w-full rounded-xl" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
        </div>

        <div class="form-control w-full max-w-md">
            <label class="label" for="update_password_password_confirmation">
                <span class="label-text font-semibold text-base-content/80">{{ __('Confirm Password') }}</span>
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="input input-bordered input-primary w-full rounded-xl" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="btn btn-primary rounded-xl px-6 shadow-md shadow-primary/20 hover:scale-[1.02] transition duration-200">
                <i class="fa-regular fa-floppy-disk mr-1.5"></i> {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
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

