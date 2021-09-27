<?php 
require './models/Post.php';

class PostController {
    public function getAll(Request $request, Response $response)
    {
        $posts = Post::findAll()->orderBy('id', 'desc')->limit('2')->get();

        return $response->json(['posts' => $posts]);
    }

    public function get(Request $request, Response $response)
    {
        $post = Post::findById($request->data['id'])->with('user')->get();
        
        return $response->json(['post' => $post]);
    }
}