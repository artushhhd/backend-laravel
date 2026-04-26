<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        try {
            // Используем Query Builder (DB::table), чтобы обойти касты модели User
            // Это гарантированно уберет ошибку 500, если проблема в Enum
            $users = DB::table('users')
                ->select('id', 'name', 'email', 'role', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateRole(Request $request, User $user)
    {
        try {
            $request->validate([
                'role' => [new Enum(UserRole::class)]
            ]);

            $user->role = $request->role;
            $user->save();

            return response()->json(['status' => 'ok', 'role' => $user->role]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function destroy(User $user)
    {
        // Проверка через value, чтобы избежать ошибок типизации
        if ($user->role instanceof UserRole) {
            $roleValue = $user->role->value;
        } else {
            $roleValue = $user->role;
        }

        if ($roleValue === 'superadmin') {
            return response()->json(['error' => 'Нельзя удалить главного админа'], 403);
        }

        $user->delete();
        return response()->json(['status' => 'deleted']);
    }
}
