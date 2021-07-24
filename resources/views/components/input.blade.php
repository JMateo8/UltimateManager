@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-green-700 focus:ring focus:ring-indigo-500 focus:ring-opacity-70']) !!}>
