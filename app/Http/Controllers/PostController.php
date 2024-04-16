<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('dashboard.index', [
            'posts' => Post::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        
        
        $validated=$request->validate([
            'msg_content' => 'bail|required|string|max:255',
            "photo" => 'bail|required|image|mimes:jpeg,jpg,png,gif|max:1024',
        ]);
    
        // Générer un nom de fichier unique
        $filename = uniqid() . '.' . $request->photo->getClientOriginalExtension();

        // Stocker l'image avec le nom généré dans le dossier "posts"
        $request->photo->storeAs('public/posts', $filename);

        // Créer une entrée dans la base de données avec le même nom de fichier
        $request->user()->post()->create([
        'msg_content' => $validated['msg_content'],
        'photo' => $filename, // Utiliser le même nom de fichier dans la base de données
        ]);
    
        // 4. On retourne vers tous les posts : route("posts.index")
        return redirect(route("dashboard.index"));
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);
 
        return view('post.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);
 
        $validated = $request->validate([
            'msg_content' => 'required|string|max:255',
        ]);
 
        $post->update($validated);
 
        return redirect(route('dashboard.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);
 
        $post->delete();
 
        return redirect(route('dashboard.index'));
    }
}
