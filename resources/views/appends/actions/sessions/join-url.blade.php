@if($meeting && $meeting->id)
    <a @if(Auth::user()->user_type == 2) href="{{ $meeting->start_url }}" @else onclick="openZoomMeeting('{{ $meeting->zoom_id }}', '{{ $meeting->password }}')" @endif class="table-anchor" title="Join Meeting">Open Link</a>
@elseif($row->meeting_link)
    <a href="{{ $row->meeting_link }}" class="table-anchor" target="_blank" >Open Link</a>
@else
    <span>No Meeting URL Available</span>
@endif