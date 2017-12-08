<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Policy on post update (only user which created post can update it)
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }

    /**
     * Policy on post delete (only user which created it can delete it)
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function destroy(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }


    public function like(User $user, Post $post)
    {
        return !$user->ownsPost($post);
    }
}
