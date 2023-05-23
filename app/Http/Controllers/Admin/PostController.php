<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Type;
use App\Models\Post;
use App\Models\Technology;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.posts.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        
        $post = new Post();
        $post->fill($data);

        $post->slug = Str::slug($data['title'], '-');
        if(isset($data['image'])){
            $post->image = Storage::put('uploads', $data['image']);
        }

        $post->slug =  Str::slug($data['title']);

        $post->save();

        if(isset($data['technologies'])){
            $post->technologies()->sync($data['technologies']);
        }

        return redirect()->route('admin.posts.index')->with('message', 'Post creato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // $post = Post::where('slug', $slug)->first();

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.posts.edit', compact('post', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        // $post->update($data);
        $post->slug = Str::slug($data['title'], '-');

        if(empty($data['set_image'])){
            if($post->image){
                Storage::delete($post->image);
                $post->image = null;
            }

        } else {
            if (isset($data['image'])) {

                if($post->image){
                    Storage::delete($post->image);
                }

                $post->image = Storage::put('uploads', $data['image']);
            }
        }

        $technologies = isset($data['technologies']) ? $data['technologies'] : [];
        $post->technologies()->sync($technologies);
        // $post->save();

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('message', "Post $post->id aggiornato con successo");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $old_id = $post->id;

        if($post->image){
            Storage::delete($post->image);
        }
        
        $post->delete();
        
        return redirect()->route('admin.posts.index')->with('message', "Post $old_id eliminato con successo");
    }
}
