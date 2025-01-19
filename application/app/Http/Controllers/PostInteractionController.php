<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Exceptions\NotFoundException;
use App\Models\User;
use App\Models\Post;
use App\Models\PostInteraction;

class PostInteractionController extends Controller
{
    public function create(Request $request)
    {
        $validInteractions = [
            PostInteraction::INTERACTION_TYPE_FAVORITE,
            PostInteraction::INTERACTION_TYPE_HIDE,
            PostInteraction::INTERACTION_TYPE_FLAG,
            PostInteraction::INTERACTION_TYPE_RATE,
        ];

        $validateData = $request->validate([
            'user_id' => 'required|integer',
            'post_id' => 'required|integer',
            'interaction_type' => 'required|in:' . implode(',', $validInteractions),
            'value' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $interectionType = $request->input('interaction_type');

                    // Validate the value according to the interection type
                    if ($interectionType == PostInteraction::INTERACTION_TYPE_RATE && (!is_int($value) || $value < 1 || $value > 5)) {
                        $fail($attribute . ' must be an integer between 1 and 5.');
                    }

                    // Validate the value according to the interection type
                    if (in_array($interectionType, [
                        PostInteraction::INTERACTION_TYPE_FAVORITE,
                        PostInteraction::INTERACTION_TYPE_HIDE,
                        PostInteraction::INTERACTION_TYPE_FLAG
                    ]) && !is_bool($value)) {
                        $fail($attribute . ' must be a boolean.');
                    }
                }
            ]
            // 'value' => 'required_if:interaction_type,' . PostInteraction::INTERACTION_TYPE_FAVORITE . ',' . PostInteraction::INTERACTION_TYPE_HIDE . ',' . PostInteraction::INTERACTION_TYPE_FLAG . '|boolean',
            // 'rate' => 'required_if:interaction_type,' . PostInteraction::INTERACTION_TYPE_RATE . '|integer|min:1|max:5',
        ]);

        if (!in_array($validateData['interaction_type'], $validInteractions)) {
            return response()->json(ApiResponse::error('Invalid interection type.'));
        }

        $user = User::find($validateData['user_id']);
        if (!$user) {
            throw new NotFoundException('User not found.');
        }

        $post = Post::find($validateData['post_id']);
        if (!$post) {
            throw new NotFoundException('Post not found.');
        }

        $postInteraction = PostInteraction::create($validateData);

        return response()->json(ApiResponse::success($postInteraction, 'Post interection updated succesfully.'));
    }

    public function update(Request $request, $id)
    {
        $validInteractions = [
            PostInteraction::INTERACTION_TYPE_FAVORITE,
            PostInteraction::INTERACTION_TYPE_HIDE,
            PostInteraction::INTERACTION_TYPE_FLAG,
            PostInteraction::INTERACTION_TYPE_RATE,
        ];

        $validateData = $request->validate([
            'user_id' => 'required|integer',
            'post_id' => 'required|integer',
            'interaction_type' => 'required|in:' . implode(',', $validInteractions),
            'value' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $interectionType = $request->input('interaction_type');

                    // Validate the value according to the interection type
                    if ($interectionType == PostInteraction::INTERACTION_TYPE_RATE && (!is_int($value) || $value < 1 || $value > 5)) {
                        $fail($attribute . ' must be an integer between 1 and 5.');
                    }

                    // Validate the value according to the interection type
                    if (in_array($interectionType, [
                        PostInteraction::INTERACTION_TYPE_FAVORITE,
                        PostInteraction::INTERACTION_TYPE_HIDE,
                        PostInteraction::INTERACTION_TYPE_FLAG
                    ]) && !is_bool($value)) {
                        $fail($attribute . ' must be a boolean.');
                    }
                }
            ]
        ]);

        if (!in_array($validateData['interaction_type'], $validInteractions)) {
            return response()->json(ApiResponse::error('Invalid interection type.'));
        }

        $interaction = PostInteraction::where('id', $id)
            ->where('interaction_type', $validateData['interaction_type'])
            ->first();

        if (!$interaction) {
            throw new NotFoundException('Post interaction not found.');
        }

        $interaction->update($validateData);

        return response()->json(ApiResponse::success($interaction, 'Post interection updated succesfully.'));
    }
}
