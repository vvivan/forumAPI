<?php
/**
 * Created by PhpStorm.
 * User: nikol
 * Date: 12/7/2017
 * Time: 12:03 PM
 */

namespace App\Transformers;


use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Transforms user return
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'username' => $user->username,
            'avatar' => $user->avatar(),
        ];
    }
}