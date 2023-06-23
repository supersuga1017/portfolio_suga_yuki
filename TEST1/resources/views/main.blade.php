<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', '作業メイン')

    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用-->

        <div class="main__buttons">
            <div class="main__button">
                <a href="{{ url('/label') }}">ラベル印刷</a>
            </div>

            <div class="main__button">
                <a href="{{url('/picking')}}">ピッキングリスト出力・照合（未実装）</a>
            </div>

            <div class="main__button">
                <a href="{{url('/non_delivery')}}">不着登録</a>
            </div>

            <div class="main__button">
                <a href="{{url('/non_delivery_data_creation')}}">不着データ生成</a>
            </div>

            <div class="main__button">
                <a href="{{url('/status_search')}}">状態検索（未実装）</a>
            </div>

            <div class="main__button">
                <a href="{{url('/syougou_creation')}}">照合結果データ生成（未実装）</a>
            </div>

            <div class="main__button">
                <a href="{{url('/waste_management')}}">廃棄管理画面（未実装）</a>
            </div>

            

        </div>


        <div class="main__manual">
           
           <div class="main__manual-button">
                <a href="">業務マニュアルはこちら</a>
            </div>
        </div>

    </div>
    <!-- Book: 既に登録されてる本のリスト -->

@endsection