<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use \App\Exceptions\NotFoundException;
use App\Http\Responses\ApiResponse;

class UserController extends Controller
{
    public function list()
    {
        $users = User::all();
        return  response()->json($users);
    }

    public function show($id)
    {
        $user = User::with('posts')->find($id);

        if (!$user) {
            throw new NotFoundException('User not found.');
        }

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            throw new NotFoundException('User not found.');
        }

        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'birth_date' => 'required|date_format:Y-m-d\TH:i:s.v\Z', // Validate ISODateTime format with milliseconds
            'cpf' => 'required|string|max:11',
        ]);

        $user->update($validateData);

        return response()->json(ApiResponse::success($user, 'User updated succesfully.'));
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            throw new NotFoundException('User not found.');
        }

        $user->delete();

        return response()->json(ApiResponse::success(null, 'User deleted succesfully.'));
    }

    public function create(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'birth_date' => 'required|date_format:Y-m-d\TH:i:s.v\Z', // Validate ISODateTime format with milliseconds
            'cpf' => 'required|string|max:11',
        ]);

        $user = User::create($validateData);

        return response()->json(ApiResponse::success($user, 'User created successfully.'));
    }
}
