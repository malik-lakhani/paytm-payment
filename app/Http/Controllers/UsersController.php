<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {

        $filter = $request->has('search') ? $request->get('search') : '';

        $users = User::with('tickets');

        if ($filter = $request->get('search')) {
            $users->where(function ($query) use ($filter) {
                $query->where('users.adhar_no', 'LIKE','%'.$filter.'%')
                    ->orwhere('users.name', 'LIKE','%'.$filter.'%')
                    ->orwhere('users.email', 'LIKE','%'.$filter.'%')
                    ->orwhere('users.mobile_no', 'LIKE','%'.$filter.'%');
            });
        }

        $users = $users->paginate(10);
        // return $users;
        return view('users', compact('users','filter'));
    }
}
