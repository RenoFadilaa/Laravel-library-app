<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-error text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300']) }}>
    {{ $slot }}
</button>
