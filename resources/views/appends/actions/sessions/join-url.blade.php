@if($meeting && $meeting->id)
    <a @if(Auth::user()->user_type == 2) target="_blank" href="{{ $meeting->start_url }}" @else onclick="openZoomMeeting('{{ $meeting->zoom_id }}', '{{ $meeting->password }}')" @endif class="table-anchor" title="Join Meeting">Open Link</a>
@else
    <span>No Meeting URL Available</span>
@endif