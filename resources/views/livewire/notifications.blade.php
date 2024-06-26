@if($unreadMessages > 0)
<div class='mini circle'>{{ $unreadMessages }}</div>
@else
<div class="circle" style="display:none;">{{ $unreadMessages }}</div>
@endif