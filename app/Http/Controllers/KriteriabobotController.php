<?php

namespace App\Http\Controllers;

use App\Models\KriteriaBobotModel;
use Illuminate\Http\Request;

class KriteriabobotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kriteriabobot = KriteriaBobotModel::get();
        return view('kriteriabobot.index', compact('kriteriabobot'))->with('i', 0);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kriteriabobot.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'bobot' => 'required',
            'description' => 'required',
        ]);

        KriteriaBobotModel::create($request->all());

        return redirect()->route('kriteriabobot.index')
                        ->with('success','Criteria created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kriteriabobot  $kriteriabobot
     * @return \Illuminate\Http\Response
     */
    public function show(KriteriaBobotModel $kriteriabobot)
    {
        // return view('kriteriabobot.show',compact('kriteriabobot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kriteriabobot  $kriteriabobot
     * @return \Illuminate\Http\Response
     */
    public function edit(KriteriaBobotModel $kriteriabobot)
    {
        return view('kriteriabobot.edit',compact('kriteriabobot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\kriteriabobot  $kriteriabobot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KriteriaBobotModel $kriteriabobot)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'bobot' => 'required',
            'description' => 'required',
        ]);

        $kriteriabobot->update($request->all());

        return redirect()->route('kriteriabobot.index')
                        ->with('success','Criteria updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KriteriaBobotModel  $kriteriabobot
     * @return \Illuminate\Http\Response
     */
    public function destroy(KriteriaBobotModel $kriteriabobot)
    {
        $kriteriabobot->delete();

        return redirect()->route('kriteriabobot.index')
                        ->with('success','Criteria deleted successfully');
    }
}
