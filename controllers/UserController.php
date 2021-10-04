<?php
require './models/User.php';

class UserController
{
    public function getAll(Request $request, Response $response)
    {
        $user = new User();
        $users = $user->findAll()->get();

        $name = $request->data['name'];
        $array = ['name' => $name, 'message' => "Welcome, $name", 'status' => 200];

        return $response->json($users, 200);
    }

    public function getById(Request $request, Response $response)
    {
        $user = User::findById($request->data['id'])->with('posts')->get();

        return $response->json(['user' => $user], 200);
    }

    public function getPosts(Request $request, Response $response)
    {
        $user = User::findById($request->data['id']);
        $posts = $user->posts()->get();
        // $posts = $user->posts()->orderBy('title', 'desc')->get();

        return $response->json(['posts' => $posts], 200);
    }

    public function create(Request $request, Response $response)
    {
        $user = new User();

        $user->login = $request->data['login'];
        $user->email = $request->data['email'];
        $user->password = password_hash($request->data['password'], PASSWORD_DEFAULT);

        if ($user->store()) {
            return $response->json(['message' => "User $user->login created"], 200);
        } else {
            return $response->json(['message' => 'Bad request'], 400);
        }
    }

    public function remove(Request $request, Response $response)
    {
        $user = User::findById($request->data['id']);

        if ($user) {
            if ($user->delete()) {
                return $response->json(['message' => 'User deleted'], 200);
            } else {
                return $response->json(['message' => 'Unable to delete'], 403);
            }
        } else {
            return $response->json(['message' => 'User not found'], 404);
        }
    }

    public function update(Request $request, Response $response)
    {
        $user = User::findById($request->data['id']);
        $isSuccess = $user->update($request->data);

        if ($user) {
            if ($isSuccess) {
                return $response->json(['message' => 'User updated'], 200);
            } else {
                return $response->json(['message' => 'Unable to update'], 403);
            }
        } else {
            return $response->json(['message' => 'User not found'], 404);
        }
    }
}