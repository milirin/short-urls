<?php 
require './models/Post.php';

class PostController {
    public function getAll(Request $request, Response $response)
    {
        $post = new Post;
        $posts = $post->findAll();

        return $response->json(['posts' => $posts]);
    }
}