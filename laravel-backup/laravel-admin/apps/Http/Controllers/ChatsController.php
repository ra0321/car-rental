<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;

class ChatsController extends Controller
{
    public function getChat($id)
    {
    	$chat = Chat::find($id);
    	return $chat;
    }

    public function getChatByTripId($id)
    {
    	$chat = Chat::with('renter', 'owner')->where('trip_id', $id)->first();
    	return $chat;
    }
}
