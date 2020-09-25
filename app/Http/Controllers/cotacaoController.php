<?php

namespace App\Http\Controllers;
use App\Models\conversao;
use Illuminate\Http\Request;

class cotacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $conversoes = new conversao([
            'email' => $user->email,
            'value_before_convertion' => $request->get('value_before_convertion'),
            'currency_origin'=>$request->get('currency_origin'),
            'target_currency'=>$request->get('target_currency'),
            'value_after_convertion'=>$request->get('value_after_convertion'),
            'target_currency_quote'=>$request->get('target_currency_quote'),
            'source_currency_quote'=>$request->get('source_currency_quote'),
        ]);

        $conversoes->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conversoes = conversao::where('email',$id)->paginate(5);
        return response()->json($conversoes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
