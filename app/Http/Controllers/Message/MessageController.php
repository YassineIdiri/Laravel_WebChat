<?php

namespace App\Http\Controllers\Message;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{    
    /**
     * index
     *
     * @return view
     */
    public function index()
    {
          return view('message.chatBox'); 
    }
    
    /**
     * conversation
     *
     * @param  $user
     * @return view
     */
    public function conversation($user)
    {
        $userExist =  User::where([
            ["username", "=", $user],
        ])->first();

        if($userExist && $userExist->id != session('user'))
        {
           $conversation = true;
           Session::put('userMsg', $userExist->id);
           $this->getConv();
           return view('message.chatBox', ['conversation' => $conversation]); 
        }
        else if($userExist && $userExist->id == session('user'))
        {
             return redirect(url() -> previous())->with('you', 'L\'utilisateur n\'existe pas.');
        }
        else
        {
            return redirect(url() -> previous())->with('notFound', 'Vous ne pouvez pas vous contactez vous-meme');
        }
    }
    
    public function getConv()
    {
        $user1 = User::findOrFail(session('user'));
        $user2 = User::findOrFail(session('userMsg'));

        $conversation = Message::where([
            ['from_id', $user1->id],
            ['to_id', $user2->id],
        ])->orWhere([
            ['from_id', $user2->id],
            ['to_id', $user1->id],
        ])->orderBy('writeAt', 'asc')
          ->get();

          foreach ($conversation as $message) {
            if(!$message->readAt && $message->to_id == session('user')){
                    $message->readAt = Carbon::now();
                    $message->save(); 
            }
        }
    }
}