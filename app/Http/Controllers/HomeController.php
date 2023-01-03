<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $actions = Action::orderByDesc('start_time')->get();

        return view('home', compact('actions'));
    }

    public function update(Request $request, Action $action)
    {
        Validator::make($request->all(), [
            'ip' => 'required',
            'username' => 'required',
            'time' => 'required',
        ])->validated();

        $action->update([
            'ip' => $request->ip,
            'username' => $request->username,
            'login_time' => $request->time
        ]);

        return response()->json(true);
    }

    public function changeStatus(Request $request, Action $action)
    {
        Validator::make($request->all(), [
            'status' => 'required|in:0,1,2,3'
        ])->validated();

        $array = ['status' => $request->status];
        if ($request->status == 0 || $request->status == 1) {
            $array['end_time'] = now();
        }
        $action->update($array);

        return response()->json(true);
    }
}
