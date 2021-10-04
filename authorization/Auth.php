<?php

class Auth { 
    public function registration(Request $request, Response $response)
    {
        $user = $this->verification($request->data, $response);

        if (array_key_exists('password', $request->data) && strlen($request->data['password']) > 7) {
            $user->password = password_hash($request->data['password'], PASSWORD_DEFAULT);
        } else {
            return $response->json(['message' => 'Пароль должен быть не менее 8-ми символов'], 300);
        }

        try {
            $user->store();
            return $response->json(['message' => 'user created'], 200);
        } catch (\Throwable $th){
            return $response->json(['message' => 'Error'], 500);
        }
    }

    public function verification($data, Response $response)
    {
        $user = new User();
        unset($data['password']);
        foreach ($data as $key => $value) {
            if ($value != '') {
                $user->$key = $value;
            } else {
                return $response->json(['message' => "$key должен быть заполнен"], 300);
            }
        }

        return $user;
    }

    public function login(Request $request, Response $response)
    {
        
    }
}