<?php

namespace App\Http\Controllers\Message;

use App\Events\chatNotif;
use Carbon\Carbon;
use App\Models\User;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessageNotifEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\MessageNotification;
use Symfony\Contracts\EventDispatcher\Event;

class EditMessageController extends Controller
{
    
    /**
     * addMessage
     *
     * @param  $req
     * @return redirect
     */
    public function addMessage(Request $req)
    {
        $user = User::where([
            ['name', $req->input('nm')],
        ])->first();
        

        if($user && $user->id != session('user'))
        {
            
            if(isset($req["image"]) && isset($req["nm"]))
            {
                $request = $req -> validate([
                    "image" => "required|image",
                ]);

                $imagePath = $request['image']->store("Images", "public");

                $message = new Message;
                $message-> type = "img";
                $message-> content = $imagePath;
                $message-> writeAt = Carbon::now();
                $message-> editAt = Carbon::now();    
                $message-> from_id = session('user');
                $message-> to_id = $user->id;
                $message->save();

                //$user->notify(new MessageNotification($message));
                event(new chatNotif($user->id));
            }
            else if(isset($req["nm"]))
            {
                
                $request = $req -> validate([
                    'chat' => 'required',
                ]);

                $message = new Message;
                $message-> content = $request['chat'];
                $message-> writeAt = Carbon::now();
                $message-> editAt = Carbon::now();    
                $message-> from_id = session('user');
                $message-> to_id = $user->id;
                $message->save();
                //$user->notify(new MessageNotification($message));
                event(new chatNotif($user->id));
            }
            return back();
        }
        else
        {
            return abort(403);
        }
    }
    
    /**
     * editMessage
     *
     * @param  $id
     * @return view
     */
    public function editMessage(Message $id)
    {
        if($id->from_id == session('user'))
        {
          return view("message.edit", ["message" => $id]);
        }
        else
        {
            return abort(403);
        }
    }
    
    /**
     * submitEditMessage
     *
     * @param  $req
     * @return redirect
     */
    public function submitEditMessage(request $req)
    {
        $message = Message::findOrFail($req->id);
        if($message->from_id == session('user'))
        {
            $message->content = $req->edit;
            $message->save(); 

            $contact = User::where([
                ['id', $message->to_id],
            ])->first()->name; 

            return redirect()->to(url()->previous() . '#m' . $message->id);

        }
        else
        {
            return abort(403);
        }
    }
        
    /**
     * deleteMessage
     *
     * @param  $id
     * @return void
     */
    public function deleteMessage(Message $id)
    {
        if( $id->from_id == session('user'))
        {
            if($id->type === 'img')
            {
                Storage::disk("public") -> delete($id->content);
            }
            $id->delete();   
        }
        else
        {
            return abort(403);
        }
    }

}
