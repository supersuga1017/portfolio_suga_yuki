<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', '指示データ作成画面')
@section('alert', 'ラベル印刷画面')

        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')

        <!-- 登録完了の表示に使用-->
        @if (session('message'))
            <div class="complete-message system__complete-message">
                {{ session('non_delivery_data') }}に{{ session('all_number') }}件の{{ session('message') }}
                {{-- @yield('alert') --}}
            </div>
        @endif

        <!-- 登録フォーム -->
        <form action="{{ url('/label/register') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="label__forms">
                <div class="label__row">
                    <label for="">不着登録日：</label>
                    <input type="date" name="non_delivery_data" class="label__form" value="{{ date('Y-m-d') }}">
                </div>
              
                
                <button type="submit" class="label__submit">
                    登録
                </button>
            </div>
        
        </form>

    <!-- Book: 既に登録されてる本のリスト -->

@endsection 