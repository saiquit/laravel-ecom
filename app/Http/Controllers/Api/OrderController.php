<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('assign.guard:customers');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user  = $this->authGuard('customers');
        if ($user === null) return response()->json([
            'message' => 'Unauthorize'
        ], 401);
        return $user->orders()->with('product')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->authGuard('customers');

        $request->validate([
            'product_id' => 'required',
            'amount' => 'numeric|required',
            'quantity' => 'integer|required',
            'status' => 'string'
        ]);

        return  $user->orders()->create([
            'product_id' => $request['product_id'],
            'amount' => $request['amount'],
            'quantity' => $request['quantity'],
            'status' => $request['status']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, $id)
    {
        $user = $user = $this->authGuard('customers');
        if ($user === null) return response()->json([
            'message' => 'Unauthorize'
        ], 401);

        return $user->orders()->with('product')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order, $id)
    {
        $user = $this->authGuard('customers');


        $request->validate([
            'product_id' => 'required',
            'amount' => 'numeric|required',
            'quantity' => 'integer|required',
            'status' => 'string'
        ]);

        return  $user->orders()->findOrFail($id)->update([
            'product_id' => $request['product_id'],
            'amount' => $request['amount'],
            'quantity' => $request['quantity'],
            'status' => $request['status']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
