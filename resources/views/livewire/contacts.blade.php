<div class="card-body contacts_body">

    <ul class="contacts">
    @for ($i = 0; $i < count($contacts); $i++)
        <li>
            <a href="{{route("message.conversation", $username[$i])}}">
                @if($user!=false && $user == $contacts[$i])
                  <div class="d-flex bd-highlight activeContact" id="{{$contacts[$i]}}">
                @else
                 <div class="d-flex bd-highlight" id="{{$contacts[$i]}}">
                @endif
                  
                <div class="img_cont">
                    <div class="rounded-circle user_img">{{ substr($contacts[$i], 0, 2) }}</div>

                    @if($unreadMessagesCount[$contacts[$i]] > 0) 
                     <span class="online_icon">{{$unreadMessagesCount[$contacts[$i]]}}</span>
                    @endif
                </div>
                <div class="user_info">
                    <span>{{$contacts[$i]}}</span>
                    <p>{{$lastMessages[$contacts[$i]]}}</p>
                </div>
            </div>
        </a>
        </li>
    @endfor

    </ul>
</div>