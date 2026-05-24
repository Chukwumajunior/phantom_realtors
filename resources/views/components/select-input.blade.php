<select {{ $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50']) }}>
    {{ $slot }}
</select>