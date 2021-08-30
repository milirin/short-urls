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
        $user = new User();
        $users = $user->findById($request->uriChunks()[1]);

        return $response->json($users, 200);
    }

    public function create(Request $request, Response $response)
    {
        
        $user = new User();

        $user->login = $request->data['login'];
        $user->email = $request->data['email'];
        $user->password = $request->data['password'];

        $users = $user->store();

        return $response->json($users, 200);
    }

    public function remove(Request $request, Response $response)
    {
        $user = new User();
        $users = $user->delete($request->uriChunks()[1]);

        return $response->json($users, 200);
    }
}