<section class="space-y-6">
    <header class="border-b border-base-300 pb-4">
        <h2 class="text-xl font-bold text-error flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation animate-pulse"></i> {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-sm text-base-content/60">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button"
        class="btn btn-error rounded-xl shadow-md shadow-error/10 px-6 hover:scale-[1.02] transition duration-200"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <i class="fa-regular fa-trash-can mr-1.5"></i> {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-base-100 rounded-3xl border border-base-300">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-error flex items-center gap-2">
                <i class="fa-solid fa-circle-question"></i> {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-base-content/70">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6 form-control w-full">
                <label class="label sr-only" for="password">
                    <span class="label-text">{{ __('Password') }}</span>
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="input input-bordered input-error w-full max-w-md rounded-xl"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" class="btn btn-ghost rounded-xl" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="btn btn-error rounded-xl px-6">
                    <i class="fa-regular fa-trash-can mr-1.5"></i> {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>

