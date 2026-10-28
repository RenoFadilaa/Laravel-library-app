@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input input-bordered w-full rounded-xl border-base-300 bg-base-100 text-base-content focus:border-primary focus:ring-primary/30 transition-colors duration-200']) }}>
