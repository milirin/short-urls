<?php 
require './models/User.php';

class UserController {
    public function getAll(Request $request, Response $response)
    {
        $user = new User();
        $users = $user->findAll();

        $name = $request->data['name'];
        $array = ['name' => $name, 'message' => "Welcome, $name", 'status' => 200];

        return $response->json($users, 200);
    }

    public function getById(Request $request, Response $response)
    {
        $user = User::findById($request->uriChunks()[1]);

        return $response->json($user, 200);
    }

    public function create(Request $request, Response $response)
    {  
        $user = new User();

        $user->login = $request->data['login'];
        $user->email = $request->data['email'];
        $user->password = password_hash($request->data['password'], PASSWORD_DEFAULT);

        if ($user->store()) {
            return $response->json(['message' => "user $user->login created"], 200);
        } else {
            return $response->json(['message' => 'bad request'], 400);
        }
    }

    public function remove(Request $request, Response $response)
    {
        $user = User::findById($request->uriChunks()[1]);
        $user->delete();

        return $response->json($users, 200);
    }
}