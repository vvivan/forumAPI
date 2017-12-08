<?php
/**
 * Created by PhpStorm.
 * User: nikol
 * Date: 12/7/2017
 * Time: 2:38 PM
 */

namespace App\Transformers;


use App\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    protected $availableIncludes=['user', 'posts'];

    /**
     * Transforms topic return
     * @param Topic $topic
     * @return array
     */
    public function transform(Topic $topic)
    {
        return [
            'id' => $topic->id,
            'title' => $topic->title,
            'created_at' => $topic->created_at->toDateTimeString(),
            'created_at_human' => $topic->created_at->diffForHumans()
        ];
    }

    /**
     * Include user into topic return
     * @param Topic $topic
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Topic $topic)
    {
        return $this->item($topic->user, new UserTransformer);
    }


    /**
     * Include post into topic return
     * @param Topic $topic
     * @return \League\Fractal\Resource\Collection
     */
    public function includePosts(Topic $topic)
    {
        return $this->collection($topic->posts, new PostTransformer);
    }
}