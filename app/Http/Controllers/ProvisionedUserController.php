<?php

namespace App\Http\Controllers;

use App\Models\ProvisionedUser;
use Illuminate\Http\Request;

class ProvisionedUserController extends Controller
{
    public function index()
    {
        $users = ProvisionedUser::paginate(10);

        if($users->isEmpty()) {
            return response()->json(['message' => 'No provisioned users found'], 404);
        }

        return response()->json($users);
    }
}
