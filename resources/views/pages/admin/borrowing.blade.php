<x-admin.layout>

    <x-slot:title>
        Borrowing Transactions Management
    </x-slot:title>

    @if(session('success'))
        <div class="alert alert-success mb-6 rounded-xl shadow-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error mb-6 rounded-xl shadow-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-xmark text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-base-content">
            Borrowing Management
        </h1>
    </div>

    <livewire:admin.borrowing.table />

</x-admin.layout>
