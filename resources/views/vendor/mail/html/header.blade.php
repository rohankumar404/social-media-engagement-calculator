@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if(($tool_settings['white_label_active'] ?? '0') == '1' && !empty($tool_settings['custom_logo_path']))
                <img src="{{ config('app.url') . '/storage/' . $tool_settings['custom_logo_path'] }}" class="logo" alt="Logo">
            @elseif (trim($slot) === 'Mapsily Tools' || trim($slot) === 'Laravel' || trim($slot) === config('app.name'))
                <img src="https://mapsily.com/wp-content/uploads/2026/04/Mapsily-wihte-logo.png" class="logo"
                    alt="Mapsily Tools Logo" style="object-fit: contain;">
            @else
                {!! $slot !!}
            @endif
        </a>
    </td>
</tr>