<?php

use App\Models\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {
    $app->get('/users', function (Request $request, Response $response) {
        $users = User::all();
        $response->getBody()->write($users->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    });
    $app->post('/users', function (Request $request, Response $response, $args) {
        // $user = User::create([
        //     'name' => 'gio',
        //     'email'=> 'email@email.com',
        //     'password' => 'secret'
        // ]);
        $data = $request->getParsedBody();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $users = User::create($data);
        $users->save();
        return $response;
    });
    $app->get('/users/{id}', function (Request $request, Response $response, $args) {
        $user = User::find($args['id']);
        if (!$user) {
            return $response->withStatus(404);
        }
        $response->getBody()->write($user->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    });
    $app->put('/users/{id}', function (Request $request, Response $response, $args) {
        $user = User::find($args['id']);
        if (!$user) {
            return $response->withStatus(404);
        }
        $user->fill($request->getParsedBody());
        $user->save();
        return $response;
    });
    $app->delete('/users/{id}', function (Request $request, Response $response, $args) {
        $user = User::find($args['id']);
        if (!$user) {
            return $response->withStatus(404);
        }
        $user->delete();
        return $response;
    });
    $app->post('/login', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $user = User::where('email', '=', $data['email'])->first();
        if ($user && password_verify($data['password'], $user->password)) {
            $response->getBody()->write("Success! Welcome {$user->name}");
        } else {
            $response->getBody()->write('login failed');
        }
        return $response;
    });
};
