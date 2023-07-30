<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', '封筒管理システム：作業メイン画面')
@section('description', 'こちらメイン画面です。')

    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用-->

        <div class="main__buttons">
            <div class="main__button">
                <a href="{{ url('/label') }}">0:ラベル印刷</a>
            </div>

            {{-- <div class="main__button">
                <a href="{{url('/picking')}}">ピッキングリスト出力・照合（未実装）</a>
            </div> --}}

            <div class="main__button">
                <a href="{{url('/non_delivery')}}">1:不着登録</a>
            </div>

            <div class="main__button">
                <a href="{{url('/non_delivery_data_creation')}}">2:不着データ生成</a>
            </div>


            <div class="main__button">
                <a href="{{url('/order')}}">3:指示データ作成</a>
            </div>

            <div class="main__button">
                <a href="{{url('/resend')}}">4:再発送処理画面</a>
            </div>

            <div class="main__button">
                <a href="{{url('/waste')}}">4:廃棄処理画面</a>
            </div>

            <div class="main__button">
                <a href="{{url('/status_search')}}">状態検索</a>
            </div>
            


            {{-- <div class="main__button">
                <a href="{{url('/syougou_creation')}}">照合結果データ生成（未実装）</a>
            </div> --}}

            {{-- <div class="main__button">
                <a href="{{url('/waste_management')}}">廃棄管理画面（未実装）</a>
            </div> --}}

        </div>


        <div class="main__manual">
           
           <div class="main__manual-button">
                <a href="https://github.com/supersuga1017/portfolio_suga_yuki/tree/master">業務マニュアルはこちら</a>
            </div>
        </div>

    </div>
    <!-- Book: 既に登録されてる本のリスト -->

@endsection