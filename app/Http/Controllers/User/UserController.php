<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class UserController extends Controller
{    

    public function countUserMessages($userId)
    {
        $messageCount = Message::where('from_id', $userId)
                                ->count();

        return $messageCount;
    }

    /**
     * setting
     *
     * @return view
     */
    public function setting()
    {
            $user = User::where([
                ["id", "=", session('user')],
            ])->first();
            $user->openingDate = Carbon::parse($user->openingDate); // Parse the date

            $messageCount = $this->countUserMessages(session('user'));

            return view('index.setting',compact('user','messageCount'));
    } 
    /**
     * edit
     *
     * @param  $req
     * @return redirect
     */
    public function edit(Request $request)
    {
        // Validation des champs
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        $userId = session('user');
        $user = User::find($userId);

        $user->password = $request->input('new_password'); 
        $user->save(); 

        // Retourner une réponse de succès
        return response()->json(['success' => true, 'message' => 'Password updated successfully']);
    }
    
    /**
     * delete
     *
     * @return redirect
     */
    public function delete(){
        try {
            $id = session('user');
            $user = User::find($id);
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found.'], 404);
            }
            $user->delete();
            Session::put('connexion', false);
            Session::put('user', 0);
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the user.'], 500);
        }
    }
    
}