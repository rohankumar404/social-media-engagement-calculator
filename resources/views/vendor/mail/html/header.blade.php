@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Mapsily Tools' || trim($slot) === 'Laravel')
<img src="{{ asset('assets/img/mapsily-logo.png') }}" class="logo" alt="Mapsily Tools Logo" style="max-height: 45px; object-fit: contain;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
