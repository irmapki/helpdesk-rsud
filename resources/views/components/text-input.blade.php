@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-emerald-600 focus:ring-emerald-600 rounded-xl shadow-sm bg-white text-gray-900 placeholder-gray-400 font-medium']) }}>