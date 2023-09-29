<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Like;
use App\Http\Controllers\AbstractController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CommentController extends AbstractController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $rules = [
            'sort' => 'nullable|in:user_id,-user_id,create_at,-create_at,max_count_likes_code,-max_count_likes_code',
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "message" => 'Validation Error.',
                "data" => $validator->errors()
            ]);
        }

        $qb = Comment::query();
        $qb->select([
            'comments.id as comment_id',
            'title',
            'comments.user_id',
            'comments.created_at',
            'comments.updated_at'
        ])
            ->selectRaw('MAX(likes.code) * COUNT(likes.code) AS max_count_likes_code')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('likes', 'comments.id', '=', 'likes.comment_id')
            ->groupBy('comments.id');

        if($request->has('sort')){
            $sort = $request->get('sort');
            $trimSorm = trim($sort,'-');
            if (substr($sort,0,1) == '-'){
                $qb->orderBy($trimSorm,'DESC');
            }else{
                $qb->orderBy($trimSorm,'ASC');
            }
        }

        $comments = $qb->paginate($request->get('per_page'));

        return response()->json([
            "success" => true,
            "message" => "Comments List",
            "data" => $comments
        ]);
    }

}
