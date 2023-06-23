<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', 'ピッキングリスト出力画面')

    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用-->
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <!-- 本登録フォーム -->
        <form action="{{ url('/label/register') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="label__forms">

            <div class="label__row">
                <label for="">指示登録日：</label>
                <input type="date" name="non_delivery_data" class="label__form" value="{{ date('Y-m-d') }}">
            </div>
            <div class="label__row">

                <label for="">照合：  <span class="">3/10通</span> </label>
                
            </div>
            
            <button type="submit" class="label__submit">
                リスト一括出力
            </button>
            </div>
        
        </form>

        {{-- 照合メニュー --}}
        <div class="system__menu picking__syogo-menu">
            <p>照合メニュー</p>
            <p>指示件数</p>

            <p>総数</p>

            @foreach ($status as $sta)
                <input type="radio" id={{ $sta->id }} name="huutou_status" value={{ $sta->id }} >
                <label for={{ $sta->id }}>{{ $sta->name }}</label><br>

            @endforeach
            
           
            <button class="label__submit">
                ピッキングリスト出力
            </button>
            
            <button class="label__submit modal-open">
                読取開始
            </button>

             <!-- モーダル本体 SESSION(huutous)があればモーダルウインドウをオープン（active）-->
             <div class="modal-container {{ session()->has('start') ? 'active' : '' }}">
                <div class="modal-body">
                    <!-- 閉じるボタン -->
                    <div class="modal-close">×</div>
                    <!-- モーダル内のコンテンツ -->
                    <div class="modal-content">
                        
                        <!-- バリデーションエラーの表示に使用-->
                        @include('common.errors')

                        <!-- 登録完了の表示に使用-->
                        @if (session('message_temporary'))
                            <div class="complete-message system__complete-message">
                                {{ session('message_temporary') }}
                            </div>
                        @endif

                        {{-- FORM --}}
                        <div class="non_delivery_forms forms">
                            <div class="label__row">
                                <label for="">書留番号のバーコードを読み取ってください ：</label><br>
                                <input type="number" name="kakitome_number" class="label__form" value={{ old('kakitome_number') }} form="form_finish">
                            </div>

                            <div class="label__row">
                                <label for="">管理番号のバーコードを読み取ってください ：</label><br>
                                <input type="number" name="manage_number" class="label__form" value={{ old('manage_number') }} form="form_finish">
                            </div>

                            <div class="label__row">
                                <label for="">封筒QRコードを読み取ってください ：</label><br>
                                <input type="number" name="huutou_qr_number" class="label__form" value={{ old('huutou_qr_number') }} form="form_finish">
                            </div>

                            {{-- 違うページへPOST --}}
                            <button type="submit" class="label__submit" formaction="{{ url('/non_delivery/temporary_store') }}">
                                1件完了
                            </button>
                        
                        </div>
                    
                        {{-- 読み取り履歴 --}}

                        <div class="read-history">
                            <table class="table">
                                <thead class="table-header">
                                  <tr>
                                    <th>得意先専用コード</th>
                                    <th>書留番号</th>
                                    <th>管理番号</th>
                                    <th>封筒QR</th>
                                  </tr>
                                </thead>
                                <tbody class="table-body">


                                    @if (session('huutous'))
                                        @foreach (session('huutous') as $huutou)
                                        {{-- 繰り返し --}}
                                        <tr class="table-row">
                                            <td>{{$huutou['kakitome']}}</td>
                                            <td>{{$huutou['kakitome']}}</td>
                                            <td>{{$huutou['manage']}}</td>  
                                            <td>{{$huutou['huutou_qr']}}</td>  
                                        </tr>
                                        @endforeach        
                                    @endif
                                    
                                 
                                </tbody>
                            </table>
                        </div>


                        <button type="submit" class="label__submit" form="form_finish">
                            読取完了
                        </button>

                        

                        <button type="submit" class="label__submit modal-close-two">
                            キャンセル
                        </button>
                    </div>
                </div>
            </div>
        </div>


        {{-- 表 --}}
        <div class="system__table read-content">
            <table class="table">
                <thead class="table-header">
                  <tr>
                    <th>業務ID</th>
                    <th>区分</th>
                    <th>管理番号</th>
                    <th>書留番号</th>
                    <th>不着登録日</th>
                    <th>状態</th>
                    <th>照合</th>
                    <th>廃棄BOXNo.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="table-row">
                    <td>データ1</td>
                    <td>データ2</td>
                    <td>データ3</td>
                    <td>データ1</td>
                    <td>データ2</td>
                    <td>データ1</td>
                    <td>データ2</td>
                    <td>データ3</td>
                  </tr>
                 
                </tbody>
            </table>
              
        </div>
    </div>
    <!-- Book: 既に登録されてる本のリスト -->

@endsection 