<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{

    public function store(){

        $validated = request()->validate([
            'content' => 'required|min:3|max:240'
        ]);

        $validated['user_id'] = auth()->id();

        Idea::create($validated);

        return redirect()->route('dashboard')->with('success', 'Idea was created successfully!');
    
    }

    public function show(Idea $idea){

        return view('ideas.show', compact('idea'));
        
    }

    public function edit(Idea $idea){
        if(auth()->id() !== $idea->user_id){
            abort(404, "nah uh");
        }

        $editing = true;
        return view('ideas.show', compact('idea', 'editing'));
        
    }

    public function update(Idea $idea){
        if(auth()->id() !== $idea->user_id){
            abort(404, "nah uh");
        }

        $validated = request()->validate([
            'content' => 'required|min:3|max:240'
        ]);

        $idea->update($validated);

        return redirect()->route('ideas.show', $idea->id)->with('success','Idea was updated successfully!');
        
    }

    public function destroy(Idea $idea){
        if(auth()->id() !== $idea->user_id){
            abort(404, "nah uh");
        }
        
        $idea->delete();

        return redirect()->route('dashboard')->with('success', 'Idea was deleted successfully!');

    }
    
}
