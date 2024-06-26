<div class="card" style="background-color: rgba(0,0,0,.1) !important;">
    @php $ancienneDate = "";  @endphp

    
    <div class="card-header msg_head" >
        <div class="d-flex bd-highlight">
            <div class="img_cont">
                <div class="rounded-circle user_img">{{ substr($user->name, 0, 2) }}</div>
            </div>
            <div class="user_info">
                <span>{{$user->name}}</span>
            </div>

        </div>
       
    </div>

    <div class="card-body msg_card_body" >
       

{{-- Boucle pour afficher tous les messages sauf le dernier --}}
@foreach ($conversation->slice(0, -1) as $k => $message)
    @php
        $dateC = new DateTime($message->writeAt);
        $date = $dateC->format('d F Y');
    @endphp

    @if ($ancienneDate != $date)
        <span class='bulletitre'>
            <span class='date-content'>{{ $date }}</span>
        </span>
        @php
            $ancienneDate = $date;
        @endphp
    @endif

    @if($message->from_id == $user->id)
        <div class="d-flex justify-content-start mb-4">
            <div class="msg_cotainer">
                @if($message->type == "text")
                <p>{{$message->content }}</p>
                @else
                <img src="/assets/Images/{{$message->content }}" alt=''>
                @endif
                <span class="msg_time">{{ date('H:i', strtotime($message->writeAt)) }}</span>
            </div>
        </div>
    @elseif($message->to_id == $user->id)
        <div class="d-flex justify-content-end mb-4" hx-target="this" hx-swap="outerHTML" id="m{{$message->id}}">
            <div class="msg_cotainer_send">
                @if($message->type == "text")
                <p>{{$message->content }}</p>
                @else
                <img src="/assets/Images/{{$message->content }}" alt=''>
                @endif
                <span class="msg_time_send">{{ date('H:i', strtotime($message->writeAt)) }}</span>
            </div>

            <div class='option'>
                <button class="img_cont_msg" onclick="activeOption(event)"><i class="bi bi-three-dots-vertical"></i></button>
                <div class="button">
                    @if($message->type == "text")
                    <button hx-get="{{ route('message.edit', $message->id) }}" class="submit-button"><i class="bi bi-pencil-square"></i></button>
                    @endif 
                    <button onclick='deleteMessage("{{route("message.delete",$message->id)}}", "m{{$message->id}}")' class="delete-button"><i class="bi bi-trash3"></i></button>
                </div>
            </div>
        </div>
    @endif
@endforeach

{{-- Boucle pour afficher le dernier message avec un indicateur de chargement --}}
@php
    $lastMessage = $conversation->last();
@endphp

@isset($lastMessage)
@if($lastMessage->from_id == $user->id)
    <div class="d-flex justify-content-start mb-4">
        <div class="msg_cotainer">
            @if($lastMessage->type == "text")
            <p>{{$lastMessage->content }}</p>
            @else
            <img src="/assets/Images/{{$lastMessage->content }}" alt=''>
            @endif
            <span class="msg_time">{{ date('H:i', strtotime($lastMessage->writeAt)) }}</span>
        </div>
    </div>
@elseif($lastMessage->to_id == $user->id)
    <div class="d-flex justify-content-end mb-4" hx-target="this" hx-swap="outerHTML" id="m{{$lastMessage->id}}">
        <div class="msg_cotainer_send">
            @if($lastMessage->type == "text")
            <p>{{$lastMessage->content }}</p>
            @else
            <img src="/assets/Images/{{$lastMessage->content }}" alt=''>
            @endif

            @if($lastMessage->id == session('onLoad'))
            <div class="spinner" wire:loading></div>
            @php
                 session(['onLoad' => 0]);
            @endphp
            @endif

            <span class="msg_time_send">{{ date('H:i', strtotime($lastMessage->writeAt)) }}</span>
        </div>

        <div class='option'>
            <button class="img_cont_msg" onclick="activeOption(event)"><i class="bi bi-three-dots-vertical"></i></button>
            <div class="button">
                @if($lastMessage->type == "text")
                <button hx-get="{{ route('message.edit', $lastMessage->id) }}" class="submit-button"><i class="bi bi-pencil-square"></i></button>
                @endif 
                <button onclick='deleteMessage("{{route("message.delete",$lastMessage->id)}}", "m{{$lastMessage->id}}")' class="delete-button"><i class="bi bi-trash3"></i></button>
            </div>
        </div>
    </div>
@endif
@endisset

    </div>

    <div class="card-footer">

        <div class="input-group" id="form">
            @csrf
            <div class="input-group-append">


          
                <form wire:submit.prevent="save" style="display:flex;">
                 
                    <span class="input-group-text attach_btn"><input type="file" class="envoi" id="screenshot" name="image" wire:model="photo" wire:loading.attr="disabled">
                    <i class="bi bi-image-fill"></i></span>
                    <div class="input-group-append">
                        <div><div class="spinner" style="margin-left:5px; margin-top:15px;" wire:loading wire:target="photo"></div></div>
                    <button type="submit" class="input-group-text send_btn" wire:loading.class="hidden" wire:target="photo"><i class="bi bi-send"></i></button>
                    </div>
                    
                    
                </form>

            </div>

            <textarea name="chat" class="form-control type_msg" placeholder="Type your message..." wire:model.defer="message"></textarea>


            <div class="input-group-append">
                <button name='envoi' class="input-group-text send_btn" wire:click="addMessage"><i class="bi bi-send"></i></button>
            </div>
            
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
        AOS.refresh();
        var messageContainer = document.querySelector('.msg_card_body');

        var observer = new MutationObserver(function () {
            // Attendez que l'image soit chargée avant de déclencher le défilement
            var newImages = messageContainer.querySelectorAll('img:not(.loaded)');
            newImages.forEach(function(image) {
                image.addEventListener('load', function() {
                    // Ajoutez une légère pause avant de déclencher le défilement
                    setTimeout(function() {
                        messageContainer.scrollTop = messageContainer.scrollHeight;
                        image.classList.add('loaded');
                    }, 100);
                });
            });
        });

        observer.observe(messageContainer, { childList: true });

            var observer = new MutationObserver(function () {
                messageContainer.scrollTop = messageContainer.scrollHeight;
            });

            observer.observe(messageContainer, { childList: true });

        });


    </script>
</div>