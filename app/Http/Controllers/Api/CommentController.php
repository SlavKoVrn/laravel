<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
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
    public function index()
    {
        $perPage = 20;
        $comments = Comment::with('user')->paginate($perPage);

        return response()->json([
            "success" => true,
            "message" => "Comments List",
            "data" => $comments
        ]);
    }

}
