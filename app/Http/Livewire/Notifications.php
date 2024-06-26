<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;

class Notifications extends Component
{
    public $unreadMessages;

    //protected $listeners = ['newMessage' => 'actualise'];
    //protected $listener = ['ok' => '$refresh'];

    protected $listeners = [
        'actualiseNotif' => 'actualise',
        'ok' => '$refresh'
    ];

    public function actualise() 
    {
        $this->unreadMessages = Message::where('to_id', session('user'))
                ->whereNull('readAt')
                ->count() ;

        $this->emit('ok');
    }

    public function mount() 
    {
        self::actualise();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
