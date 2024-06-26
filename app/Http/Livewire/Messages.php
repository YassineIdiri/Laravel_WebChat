<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Events\chatNotif;
use Livewire\WithFileUploads;

class Messages extends Component
{
    use WithFileUploads;

    public $conversation;
    public $user;
    public $message ='';
    public $photo;
    public $onLoad;


    protected $listeners = [
        'sent' => '$refresh',
        'newMessage' => 'getConv'
    ];
    //protected $listene = ['ok' => '$refresh'];

    public function getConv()
    {
        $user1 = User::findOrFail(session('user'));
        $user2 = User::findOrFail(session('userMsg'));

        $this->conversation = Message::where([
            ['from_id', $user1->id],
            ['to_id', $user2->id],
        ])->orWhere([
            ['from_id', $user2->id],
            ['to_id', $user1->id],
        ])->orderBy('writeAt', 'asc')
          ->get();

          foreach ($this->conversation as $message) {
            if(!$message->readAt && $message->to_id == session('user')){
                    $message->readAt = Carbon::now();
                    $message->save(); 
            }
        }

          $this->user = $user2;

          $this->emit('actualiseNotif');
          $this->emit('actualiseContact');
    }

    public function mount() {
        self::getConv();
    }
    
    public function render()
    {

        return view('livewire.messages');
    }


    public function addMessage()
    {
        $msg = new Message;
        $msg-> content = $this->message;
        $msg-> writeAt = Carbon::now();
        $msg-> editAt = Carbon::now();    
        $msg-> from_id = session('user');
        $msg-> to_id = $this->user->id;
        $msg->save();

        $this->onLoad = $msg->id;

        //$user->notify(new MessageNotification($message));
        event(new chatNotif($this->user->id));
        
        $this->conversation->add($msg);
        $this->message ='';
        session(['onLoad' => $this->onLoad]);

        $this->emit('sent');
    }
        

    
    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);
 
        $imagePath = $this->photo->store("ImageMessages", "public");

        $msg = new Message;
        $msg-> type = "img";
        $msg-> content = $imagePath;
        $msg-> writeAt = Carbon::now();
        $msg-> editAt = Carbon::now();    
        $msg-> from_id = session('user');
        $msg-> to_id = $this->user->id;
        $msg->save();

        $this->conversation->add($msg);
        $this->photo =null;

        $this->emit('sent');
        event(new chatNotif($this->user->id));
    }



}