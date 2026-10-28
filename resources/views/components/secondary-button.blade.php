<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-ghost border border-base-300 text-base-content rounded-xl hover:bg-base-200 transition-all duration-300']) }}>
    {{ $slot }}
</button>
