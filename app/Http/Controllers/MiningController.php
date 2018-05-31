<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MiningRequest;
use App\Mining;
use App\User;

class MiningController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $mining = $user->mining()->first();
        return view('minings.index')
            ->with(compact('user'))
            ->with(compact('mining'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MiningRequest $request)
    {
        $user = auth()->user();
        $userMining = $user->mining()->first();
        $request->validateCreate();
        $request->approve($user);
        return redirect()->back();
    }
    public function stop(MiningRequest $request) {
        $user = auth()->user();
        $userMining = $user->mining()->first();
        $request->validateStop();
        $request->stop($user);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mining  $mining
     * @return \Illuminate\Http\Response
     */
    public function show(Mining $mining)
    {
        //
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mining  $mining
     * @return \Illuminate\Http\Response
     */
    public function edit(Mining $mining)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mining  $mining
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mining $mining)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mining  $mining
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mining $mining)
    {
        //
    }
}
