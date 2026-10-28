<x-admin.layout>

    <x-slot:title>
        Publisher Management
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
            Publisher Management
        </h1>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <div class="xl:col-span-2">
            <livewire:admin.publisher.table />
        </div>

        <div class="bg-base-100 rounded-2xl shadow-md border border-base-300 p-6 nature-card">
            <h2 class="font-bold text-lg text-base-content mb-6 flex items-center gap-2">
                <i class="fa-solid fa-circle-plus text-primary"></i> Create Publisher
            </h2>

            @if ($errors->any())
                <div class="alert alert-error mb-4 rounded-xl text-xs py-3 flex items-start gap-1">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.publisher.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="form-control">
                        <input type="text" name="publisher_name" value="{{ old('publisher_name') }}" placeholder="Publisher Name"
                            class="input input-bordered w-full rounded-xl text-sm" required>
                    </div>

                    <div class="form-control">
                        <textarea name="publisher_description" placeholder="Description" rows="4"
                            class="textarea textarea-bordered w-full rounded-xl text-sm">{{ old('publisher_description') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full text-white rounded-xl py-3 shadow-md shadow-primary/20">
                        <i class="fa-solid fa-plus mr-1"></i> Create Publisher
                    </button>
                </div>
            </form>
        </div>

    </div>

</x-admin.layout>
