<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;

class Contacts extends Component
{
    public $contacts;
    public $username;
    public $lastMessages;
    public $unreadMessagesCount;
    public $user;


    protected $listeners = [
        'actualiseContact' => 'getContact',
        'okk' => '$refresh',
        'sent' => 'getContact'
    ];

    public function render()
    {
        return view('livewire.contacts');
    }

    public function getContact()
    {
        self::contact();
        self::lastMessage();
        self::unreadMessageCount();

        if(session()->has('userMsg'))
        {
            $this->user = session('userMsg');
        }
        else
        {
            $this->user = false;
        }

        $this->emit('okk');
    }

    public function mount() 
    {
        self::getContact();
    }


    public function contact()
    {
        $messages = Message::where([
            ['from_id', session('user')],
        ])->orWhere([
            ['to_id',session('user')],
        ])->orderBy('writeAt', 'desc')
          ->get();
         
          $i = 0;
          $tabNamesContact = [];
          $addedContactIds = []; // Tableau pour stocker les identifiants déjà ajoutés
          
          foreach ($messages as $message) {
              $contactId = ($message->from_id == session('user')) ? $message->to_id : $message->from_id;
              
              // Vérifiez si l'identifiant du contact a déjà été ajouté
              if (!in_array($contactId, $addedContactIds)) {
                  $user = User::findOrFail($contactId);
                  $tabNamesContact[$i] = $user->name;
                  $addedContactIds[] = $contactId; // Ajouter l'identifiant au tableau des identifiants ajoutés
                  $i++;
              }
          }
        
        $this->contacts =  $tabNamesContact;

        foreach($this->contacts as $contact)
        {
            $user = User::where([
                ['name', $contact],
            ])->first();
            $this->username[] = $user->username;
        }
    }

    public function lastMessage()
    {
        $tabMessage = [];
        foreach($this->contacts as $contact)
        {
            $user = User::where([
                ['name', $contact],
            ])->first();

            $msg= Message::where([
                ['from_id', $user->id],
                ['to_id', session('user')],
            ])->orWhere([
                ['from_id', session('user')],
                ['to_id', $user->id],
            ])->latest('writeAt')->first();

            if($msg->type == "text")
            {
                $tabMessage[$contact] = $msg->content;
            }
            else
            {
                $tabMessage[$contact] = "Image";
            }

        }

        $this->lastMessages =  $tabMessage;
    }

    public function unreadUser($user)
    {
            $user1 = session('user');
            $user2 = User::where([
                ['name', $user],
            ])->first()->id; 

            $unreadMessagesCount = Message::where('from_id', $user2)
                ->where('to_id', $user1)
                ->whereNull('readAt')
                ->count();

            return $unreadMessagesCount;
    }

    public function unreadMessageCount()
    {
        $tab= [];
        foreach ($this->contacts as $contact) 
        {
            $tab[$contact] = $this->unreadUser($contact);
        }
        $this->unreadMessagesCount = $tab;
    }



}
