<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Retrieve paginated users
     *
     * @return bool @status
     * @return array @data
     */
    public function users()
    {
        $users = User::paginate(10);

        return response()->json([
            'status' => true,
            'data' => $users
        ], 200);
    }
}
