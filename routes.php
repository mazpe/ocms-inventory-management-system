<?php

use IIS\Inventory\Models\Item;
use Illuminate\Support\Facades\Input;

Route::post('/email_information', function() {
    $item_id = Input::get('item_id');
    $item = Item::find($item_id);

    // These variables are available inside the message as Twig
    $vars = [
        'serial' => $item->serial,
        'sender_email'       => Input::get('sender_email'),
        'sender_name'        => Input::get('sender_name'),
        'recipient_email'    => Input::get('recipient_email'),
        'recipient_name'     => Input::get('recipient_name')
    ];

    Mail::send('101', $vars, function($message) use ($vars) {
        $message->from($vars['sender_email'], $vars['sender_name']);
        $message->to($vars['recipient_email'], $vars['recipient_name']);
    });

    return Redirect::to('/portfolio/'. $item_id )->with('message', 'Email Sent');
});


