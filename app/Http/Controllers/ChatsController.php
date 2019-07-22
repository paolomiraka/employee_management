<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Message;
use app\events\MessageSent;
use Alert;


class ChatsController extends Controller
{
    public function index()
    {
       
        return view('chat');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return  Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
