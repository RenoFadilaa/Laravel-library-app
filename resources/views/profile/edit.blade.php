<x-user.layout>
    <x-slot:title>Settings</x-slot:title>

    <x-slot:hero>
        <div class="bg-gradient-to-r from-neutral to-primary py-12 text-white border-b border-primary/20 shadow-md">
            <div class="max-w-7xl mx-auto px-6 md:px-8 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-extrabold flex items-center gap-2 tracking-tight">
                        <i class="fa-solid fa-gear text-accent"></i> Account Settings
                    </h1>
                    <p class="text-white/80 text-sm mt-2 font-light">
                        Manage your profile information, personal image, and account security.
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex gap-2">
                    <span class="badge bg-white/10 text-white border-white/20 px-3 py-2 rounded-lg text-xs">
                        <i class="fa-solid fa-user-gear mr-1"></i> Personal Profile
                    </span>
                </div>
            </div>
        </div>
    </x-slot:hero>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-10">
        <!-- Profile Card -->
        <div class="card bg-base-100 p-6 sm:p-8 rounded-3xl border border-base-300 shadow-xl relative overflow-hidden">
            <!-- Glass decoration background -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-secondary/10 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Security Card -->
        <div class="card bg-base-100 p-6 sm:p-8 rounded-3xl border border-base-300 shadow-xl relative overflow-hidden">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-accent/10 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="card bg-base-100 p-6 sm:p-8 rounded-3xl border border-base-300 shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    const preview = document.getElementById('avatar-preview');
                    const initial = document.getElementById('avatar-initial');
                    preview.src = reader.result;
                    preview.classList.remove('hidden');
                    if (initial) {
                        initial.classList.add('hidden');
                    }
                }
                if (event.target.files[0]) {
                    reader.readAsDataURL(event.target.files[0]);
                }
            }
        </script>
    </x-slot:scripts>
</x-user.layout>

