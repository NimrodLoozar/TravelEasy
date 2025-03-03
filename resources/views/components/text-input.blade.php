@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-900 bg-gray-100 text-gray-900 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm']) }}>
