<?php

namespace App\Http\Controllers;

use App\Models\Cart_items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart_items = Cart_items::select('cart_items.*', 'items.name', 'items.amount')
            ->where('user_id', Auth::id())
            ->join('items', 'items.id', '=', 'cart_items.item_id')
            ->get();

        $subtotal = 0;
        foreach($cart_items as $cart_item){
            $subtotal += $cart_item->amount * $cart_item->quantity;
        }

        return view('cart_item/index', ['cart_items' => $cart_items, 'subtotal' => $subtotal]);
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
        Cart_items::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'item_id' => $request->post('item_id'),
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->post('quantity')),
            ]
        );
        return redirect('/')->with('flash_message', 'カートに追加しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart_items  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart_items $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart_items  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart_items $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart_items  $cart_items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cart_item = Cart_items::findOrFail($id);

        $cart_item->update([
            'quantity' => $request->post('quantity'),
        ]);

        return redirect('cart_item')->with('flash_message', 'カートを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart_items  $cart_items
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart_item = Cart_items::findOrFail($id);

        $cart_item->delete();

        return redirect('cart_item')->with('flash_message', 'カートから削除しました');
    }

    public function buy()
    {
        $cart_items = Cart_items::select('cart_items.*', 'items.name', 'items.amount')
                                    ->where('user_id', Auth::id())
                                    ->join('items', 'items.id', '=', 'cart_items.item_id')
                                    ->get();
        $subtotal = 0;
        foreach($cart_items as $cart_item){
            $subtotal += $cart_item->amount * $cart_item->quantity;
        }

        return view('buy/index', ['cart_items' => $cart_items, 'subtotal' => $subtotal]);
    }

    public function buy_store(Request $request)
    {
        if($request->has('post') ){
            Cart_items::where('user_id', Auth::id())->delete();
            return view('buy/complete');
        }

        $request->flash();
        return $this->index();
    }
}
