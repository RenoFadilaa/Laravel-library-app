<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary text-white rounded-xl shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 transition-all duration-300']) }}>
    {{ $slot }}
</button>
