<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Post;
use App\Topic;
use App\Transformers\TopicTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class TopicController extends Controller
{
    /**
     * Returns all topics (5 per page)
     * @return mixed
     */
    public function index()
    {
        $topics = Topic::latestFirst()->paginate(5);
        $topicsCollection = $topics->getCollection();

        return fractal()->collection($topicsCollection)
                        ->parseIncludes(['user'])
                        ->transformWith(new TopicTransformer)
                        ->paginateWith(new IlluminatePaginatorAdapter($topics))
                        ->toArray();
    }


    /**
     * Shows specific topic
     * @param Topic $topic
     * @return mixed
     */
    public function show(Topic $topic)
    {
        return fractal()->item($topic)
                        ->parseIncludes(['user', 'posts', 'posts.user', 'posts.likes'])
                        ->transformWith(new TopicTransformer)
                        ->toArray();
    }


    /**
     * Stores topic to a database
     * @param StoreTopicRequest $request
     * @return mixed
     */
    public function store(StoreTopicRequest $request)
    {
        $topic = new Topic;
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);

        return fractal()->item($topic)
                        ->parseIncludes(['user', 'posts', 'posts.user'])
                        ->transformWith(new TopicTransformer)
                        ->toArray();
    }


    /**
     * Updates topic
     * @param UpdateTopicRequest $request
     * @param Topic $topic
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->title = $request->get('title', $topic->title);
        $topic->save();

        return fractal()->item($topic)
                        ->parseIncludes((['user']))
                        ->transformWith(new TopicTransformer)
                        ->toArray();
    }


    /**
     * Deletes topic with custom 204 (success - no content) response
     * @param Topic $topic
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);

        $topic->delete();

        return response(null, 204);
    }
}
