@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-primary focus:border-primary_hover focus:ring-primary_hover rounded-md shadow-sm']) !!}>
