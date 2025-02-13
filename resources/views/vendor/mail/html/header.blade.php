@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Next Trip')
<img src="{{ asset('assets/img/next_trip_transparent.png') }}" class="logo" alt="Next Trip Logo" style="height: 180px;width: 120px;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
