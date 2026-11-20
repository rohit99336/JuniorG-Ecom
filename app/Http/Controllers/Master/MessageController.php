<?php

namespace App\Http\Controllers\Master;

use App\Models\Message;
use App\Models\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        // $messagesQuery = Message::with('messageTemplate', 'event');

        // if ($request->has('search')) {
        //     $searchTerm = $request->search;
        //     $messagesQuery->where('name', 'like', '%' . $searchTerm . '%');
        // } elseif ($request->has('event')) {
        //     $event = $request->event;
        //     $messagesQuery->whereHas('event', function ($query) use ($event) {
        //         $query->where('name', $event);
        //     });
        // } else {
        //     $messagesQuery->orderBy('id', 'desc');
        // }

        $messagesQuery = Message::with('messageTemplate');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $messagesQuery->where('name', 'like', '%' . $searchTerm . '%');
        } else {
            $messagesQuery->orderBy('id', 'desc');
        }

        $messages = $messagesQuery->paginate(10);

        $messages->appends($request->except('page'));

        return view('master.messages.index', compact('messages'));
    }

    public function create()
    {
        $templates = Template::all();
        return view('master.messages.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $message = Message::create($request->all());
        return redirect()->route('messages.index')->with('success', 'Message created successfully');
    }

    public function show($id)
    {
        $message = Message::with('messageTemplate', 'event')->findOrFail($id);
        return view('master.messages.show', compact('message'));
    }

    public function edit($id)
    {
        $message = Message::findOrFail($id);
        $templates = Template::all();
        return view('master.messages.edit', compact('message', 'templates',));
    }


    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->update($request->all());
        return redirect()->route('messages.index')->with('success', 'Message updated successfully');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return redirect()->route('messages.index')->with('success', 'Message deleted successfully');
    }
}
