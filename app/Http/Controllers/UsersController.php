<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

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
}
