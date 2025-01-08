<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use \App\Http\Controllers\Utils;
use \App\Exceptions\NotFoundException;
use App\Http\Responses\ApiResponse;

class UserController extends Controller
{
    private $users = [];

    public function __construct()
    {
        $this->users = collect(Utils::loadJsonFile('temp-database.json')['users']);
    }

    public function list()
    {
        return  response()->json($this->users);
    }

    public function show($id)
    {
        $user = collect($this->users)->firstWhere('id', $id);

        if (!$user) {
            throw new NotFoundException('User not found.');
        }

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $userIndex = collect($this->users)->search(function ($user) use ($id) {
            return $user['id'] == $id;
        });

        if (!$userIndex) {
            throw new NotFoundException('User not found.');
        }

        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);
        
        $this->users[$userIndex] = array_merge($this->users[$userIndex], $validateData);

        // sobrescreve o "banco de dados", só pra simular
        Utils::writeFile('temp-database.json', 'users', $this->users);

        return response()->json(ApiResponse::success($this->users[$userIndex], 'User updated succesfully.'));
    }

    public function delete($id)
    {
        $user = collect($this->users)->firstWhere('id', $id);

        if (!$user) {
            throw new NotFoundException('User not found.');
        }

        collect($this->users)->reject(function ($user) use ($id) {
            return $user['id'] === $id;
        })->values()->all();

        return response()->json(ApiResponse::success(null, 'User deleted succesfully.'));
    }

    public function create(Request $request) {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'birthDate' => 'required|date_format:Y-m-d\TH:i:s.v\Z', // Validate ISODateTime format with milliseconds
        ]);

        $user = User::create($validateData);

        return response()->json(ApiResponse::success($user, 'User saved successfully.'));
    }
}
