@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Mapsily Tools' || trim($slot) === 'Laravel')
                <img src="https://mapsily.com/wp-content/uploads/2026/01/mapsily-logo-scaled.png" class="logo"
                    alt="Mapsily Tools Logo" style="object-fit: contain;">
            @else
                {!! $slot !!}
            @endif
        </a>
    </td>
</tr>