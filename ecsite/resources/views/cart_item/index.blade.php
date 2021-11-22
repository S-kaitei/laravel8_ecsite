@extends('layouts.app')

@section('content')
    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @foreach ($cart_items as $cart_item)
                        <div class="card-header">
                            <a href="/item/{{ $cart_item->item_id }}">{{ $cart_item->name }}</a>
                        </div>
                        <div class="card-body">
                            <div>
                                {{ $cart_item->amount }}円
                            </div>
                            <div class="form-inline">
                                <!-- 数量を更新するフォームに変更 -->
                                <form method="POST" action="/cart_item/{{ $cart_item->id }}">
                                    @method('PUT')
                                    @csrf
                                    <input type="text" class="form-control" name="quantity" value="{{ $cart_item->quantity }}">
                                    個
                                    <button type="submit" class="btn btn-primary">更新</button>
                                </form>
                                <!-- 削除フォームを追加 -->
                                <form method="POST" action="/cart_item/{{ $cart_item->id }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-primary ml-1">カートから削除する</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        小計
                    </div>
                    <div class="card-body">
                        <div>
                        {{ $subtotal }}円
                        </div>
                        <div>
                            <a class="btn btn-primary" href="/buy" role="button">
                                レジに進む
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
