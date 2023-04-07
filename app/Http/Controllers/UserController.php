<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'email']);
        $validator = validator($data, [
            'name' => 'required|string',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->update($data);
        return response()->json([
            'status' => true,
            'data' => $user,
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}