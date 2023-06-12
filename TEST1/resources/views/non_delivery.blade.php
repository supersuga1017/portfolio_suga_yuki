<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', '不着登録画面')
@section('modal', '')

    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        
        <!-- 登録完了の表示に使用-->
        @if (session('message'))
            <div class="complete-message system__complete-message">
                {{ session('count') }}件の{{ session('message') }}
            </div>
        @endif

        <!-- 本登録フォーム -->
        <form action="{{ url('/non_delivery') }}" method="POST" class="form-horizontal" id="form_finish" >
            @csrf
            <div class="label__forms">

                <div class="label__row">
                    <label for="">業務名：</label>
                    <select class="label__form" name="gyoumu" form="form_finish" >
                        @foreach ($gyoumu as $gyo)
                            {{-- 例)value="MUBR11" selected(SESSIONと一致していれば)> --}}
                            <option value={{ $gyo->id }} {{ session('gyoumu') == $gyo->id ? 'selected' : '' }}>{{ $gyo->name }} </option>    
                        @endforeach
                    </select>
                </div>

                <div class="label__information non_delivery__label-information">
                    <p>ラベル情報 </p>
                    <p>{{date('Y/m/d')}}の印刷枚数：{{ $today_label_number }}枚</p>
                </div>
    

                <div class="label__row">
                    <label for="">不着登録日：</label>
                    <input type="date" name="non_delivery_date" form="form_finish" class="label__form" value="{{ session()->has('non_delivery_date') ? session('non_delivery_date') : date('Y-m-d') }}">
                </div>

                <div class="label__row">
                    <label for="">返戻理由：</label>
                    <select class="label__form" name="return_reason" form="form_finish" >
                        @foreach ($return_reason as $re)
                            <option value={{ $re->id }} {{ session('return_reason') == $re->id ? 'selected' : '' }}>{{ $re->name }}</option>    
                        @endforeach
                      
                    </select>
                    
                </div>

                
                <button class="label__submit modal-open">
                    読取開始
                </button>
            </div>
            
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
        
        </form>
    </div>
    <!-- Book: 既に登録されてる本のリスト -->

@endsection 