<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Post;
use App\Topic;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store/save post/reply to a topic
     * @param StorePostRequest $request
     * @param Topic $topic
     * @return array
     */
    public function store(StorePostRequest $request, Topic $topic)
    {
        $post = new Post;

        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->posts()->save($post);

        return fractal()->item($post)
                        ->parseIncludes(['user'])
                        ->transformWith(new PostTransformer)
                        ->toArray();
    }


    /**
     * Authorizes request, updates post, or throws exception
     * @param StorePostRequest $request
     * @param Topic $topic
     * @param Post $post
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StorePostRequest $request, Topic $topic, Post $post)
    {
        $this->authorize('update', $post);

        $post->body = $request->get('body', $post->body);
        $post->save();

        return fractal()->item($post)
                        ->parseIncludes(['user'])
                        ->transformWith(new PostTransformer)
                        ->toArray();
    }


    /**
     * Authorizes request, deletes post  or throws exception
     * @param Topic $topic
     * @param Post $post
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Topic $topic, Post $post)
    {
        $this->authorize('destroy', $post);

        $post->delete();

        return response(null, 204);
    }

}
