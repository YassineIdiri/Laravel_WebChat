<?php

namespace App\Http\Controllers\Index;
use Carbon\Carbon;
use App\Models\User;

use App\Models\Message;
use App\Models\TemporaryUser;
use App\Mail\ActivateAccountMail;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{    
     /**
     * index
     *
     * @return view
     */
    public function index()
    {
          return view('index.index'); 
    }
    
}