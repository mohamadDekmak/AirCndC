<div class="flex justify-center py-8">
    @foreach($available_locales as $locale_name => $available_locale)
        @if($available_locale === $current_locale)
            <span class="ml-2 mr-2 text-gray-700">{{ $locale_name }}</span>
        @else
            @php
                $currentUrlSegments = request()->segments();
                $localeIndex = array_search($current_locale, $currentUrlSegments);
                if ($localeIndex !== false) {
                    $currentUrlSegments[$localeIndex] = $available_locale;
                }
                $newUrl = '/' . implode('/', $currentUrlSegments);
            @endphp
            <a class="underline ml-2 mr-2" href="{{ url($newUrl) }}">
                <span>{{ $locale_name }}</span>
            </a>
        @endif
    @endforeach
</div>
