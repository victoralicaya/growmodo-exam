<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    /**
     * Unsubscribe
     *
     * @param Request @request
     * @return bool @status
     * @return string @message
     */
    public function unsubscribe(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $user->delete();

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Unsubscribe successfully.'
        ], 200);
    }
}
