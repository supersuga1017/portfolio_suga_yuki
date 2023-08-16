<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', '封筒管理システム：作業メイン画面')
@section('description', '封筒を登録し、在庫管理、状態管理ができるシステムです。こちらメイン画面です。')

    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用-->

        <div class="main__buttons">
            <div class="main__button">
                <a href="{{ url('/label') }}">0:ラベル印刷</a>
                <p class="tooltip">不着登録（次の工程）で使用するラベル枚数を指定できます。</p>
            </div>

            {{-- <div class="main__button">
                <a href="{{url('/picking')}}">ピッキングリスト出力・照合（未実装）</a>
            </div> --}}

            <div class="main__button">
                <a href="{{url('/non_delivery')}}">1:不着登録</a>
                <p class="tooltip">不着封筒をまとめて登録できます。</p>
            </div>

            <div class="main__button">
                <a href="{{url('/non_delivery_data_creation')}}">2:不着データ生成</a>
                <p class="tooltip">不着登録済みの封筒（一時登録）を登録完了状態にし、指示データを受け取れるようになります。</p>
            </div>


            <div class="main__button">
                <a href="{{url('/order')}}">3:指示データ受領</a>
                <p class="tooltip">不着データ生成が完了したデータが表示され、指示データ（再発送 or 廃棄 or 保管）を取得できます。</p>
            </div>

            <div class="main__button">
                <a href="{{url('/resend')}}">4:再発送処理画面</a>
                <p class="tooltip">「再発送」の指示データを受けた封筒を「再発送完了」にできます。</p>
            </div>

            <div class="main__button">
                <a href="{{url('/waste')}}">4:廃棄処理画面</a>
                <p class="tooltip">「廃棄」の指示データを受けた封筒を「廃棄完了」にできます。</p>
            </div>

            <div class="main__button">
                <a href="{{url('/status_search')}}">状態検索</a>
                <p class="tooltip">封筒全ての状態を参照できます。</p>

            </div>
            


            {{-- <div class="main__button">
                <a href="{{url('/syougou_creation')}}">照合結果データ生成（未実装）</a>
            </div> --}}

            {{-- <div class="main__button">
                <a href="{{url('/waste_management')}}">廃棄管理画面（未実装）</a>
            </div> --}}

        </div>


        <div class="main__manual">
           <div class="main__manual-image">
                <img src="{{ asset('images/all-frow.jpg') }}" alt="マニュアル画像">
           </div>
           <div class="main__manual-button">
                <a href="https://github.com/supersuga1017/portfolio_suga_yuki/tree/master">業務マニュアルはこちら!</a>
            </div>
        </div>

    </div>
    <!-- Book: 既に登録されてる本のリスト -->

@endsection