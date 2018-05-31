<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MiningRequest;

use App\Http\Requests\Mining\StopRequest as MiningStopRequest;
use App\Http\Requests\Mining\IncreaseRequest;
use App\Mining;
use App\User;
use DB;

use App\Events\Mining\GrabedIncomeDaily;

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
        //dd($mining);
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

        session()->flash('flash_notification', [
            'message' => 'berhasil memulai mining',
            'level' => 'info'
        ]);
        return redirect()->back()
        ->with([
            'user' => $user,
            'mining' => $userMining,
        ]);
    }
    public function stop(MiningStopRequest $request) {
        
        $user = auth()->user();
        $userMining = $user->mining()->first();
        $request->validateStop($userMining);
        return redirect()->back();
        
    }

    public function dailyIncome() {

        $minings = new Mining();
        $minings = $minings->activeMining()->get();
        
        DB::beginTransaction();
            foreach( $minings as $mining ) {

                $mining->grabIncomeDaily()->save();
                event( new GrabedIncomeDaily( $mining ) );
            }
        DB::commit();
    }

    public function grabIncomeHalfMonth() {

    }
    public function grabIncomeMonthly() {

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
     * Increase the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function increase(IncreaseRequest $request)
    {
        $user = auth()->user();

        if( !$user->hasEnoughCoin($request->mining_power) ) {

            session()->flash('flash_notification',[
                'message' => 'Maaf anda tidak memiliki cukup koin',
                'level'   => 'error'
            ]);

        } else {

            $request->validateIncrease();
            $request->increased( $user );

            session()->flash('flash_notification', [
                'message' => 'Berhasil menambahkan mining power',
                'level' => 'info'
            ]);
            
        }
        return redirect()->back()
            ->with([
                'user' => $user,
                'mining' => $user->mining()->first()
            ]);
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
