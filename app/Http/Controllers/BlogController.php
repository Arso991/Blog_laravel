<?php

namespace App\Http\Controllers;

use App\Models\Blogapi;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller {
    public function store(Request $request){
       $data = $request->all();
       $post = $data['posts'];

       $save = Blogapi::create([
        'posts' => $post
       ]);

       if($save){
        return response()->json([
            "message" => "Post saved with successful",
            "post" => $save,
            "status" => 201
        ]);
       }

       return response()->json([
        "message" => "Failed !"
       ]);
    }

    public function lists(){
        $posts = Blogapi::all();
        return response()->json($posts);
    }

    public function saveComment(Request $request){
        $data = $request->all();      

        try {
            if(!Blogapi::where("id", $data["blog_id"])->exists()){
                return response()->json(["message" => "Blog ID not found !"], 200);
            }
    
            $save = Comment::create([
                "comment" => $data["comment"],
                "blog_id" => $data["blog_id"]
            ]);
    
            if($save){
                return response()->json(["message"=>"Comment added with successful !"], 201);
            }
        } catch (\Exception $exception) {
            return response()->json(["message"=>$exception->getMessage()], 422);
        }
    }

    public function getCommentsBlog(Request $request, $id){
        $blog = Blogapi::find($id);
        if(!$blog){
            return response()->json(['message'=>"Blog not found !"]);
        }

        return response()->json([
            "blog" => array("id"=>$blog->id, "comment" => $blog->posts),
            "comment" => $blog->commentaire,
            "today" => Carbon::now(),
            "today_format_y_m_d"=>Carbon::now()->toString(),
            "format_string"=>Carbon::now()->toFormattedDateString(),
            "date_created"=>Carbon::parse($blog->created_at)->locale('fr_FR')->diffForHumans()
        ]);
    }

    public function getBlogs(){
        $blog = Blogapi::with(["commentaire"])->get();
        return response()->json($blog);
    }

    public function deleteBlog($id){
        try {
            Blogapi::where("id", $id)->delete();
            return response()->json(["message"=> "Blog deleted !"]);
        } catch (\Exception $exception) {
            return response()->json(["message"=>$exception->getMessage()]);
        }
    }
}