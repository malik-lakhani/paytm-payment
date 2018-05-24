<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use View;
use Session;
use Redirect;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $ticketsItemList = [10, 20, 30, 40, 50];
        $itemsPerPage = $request->perPage ? $request->perPage : 10;
        $filter = $request->has('search') ? $request->get('search') : '';

        $tickets = Ticket::where('status', '=', 2);

        if ($filter = $request->get('search')) {
            $tickets->where(function ($query) use ($filter) {
                $query->where('tickets.adhar_no', 'LIKE','%'.$filter.'%')
                    ->orwhere('tickets.ticket_unique_id', 'LIKE', '%'.$filter.'%')
                    ->orWhere('name', 'LIKE', '%'.$filter.'%')
                    ->orWhere('email', 'LIKE', '%'.$filter.'%')
                    ->orWhere('mobile_no', 'LIKE', '%'.$filter.'%');
            });
        }

        $tickets = $tickets->paginate($itemsPerPage);

        // $searchString = '';
        // if ($request->search != null) {
        //     $searchString = $request->search;
        // }

        return view('users', compact('tickets', 'filter', 'ticketsItemList', 'itemsPerPage'));
    }

    public function login()
    {
        if (Session::has('username') && Session::get('username') == config('app.admin_username')) {
            return redirect('manage/users');
        }

        return View::make('adminLogin');
    }

    public function processLogin(Request $request)
    {
        if ($request->username == config('app.admin_username') && $request->password == config('app.admin_password')) {

            $request->session()->put('username', 'admin');
            return redirect('manage/users');

        } else {
            return Redirect::to('manage/login')->with('error', 'Invalid username or password.');
        }
    }

    public function logout(Request $request)
    {
        session()->forget('username');
        return redirect('manage/login');
    }
}
