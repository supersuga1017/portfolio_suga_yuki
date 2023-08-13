<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', '指示データ受領画面')
@section('alert', 'ラベル印刷画面')
@section('description', 'こちらの画面では、不着データ生成が完了したデータが表示され、指示データ（再発送 or 廃棄 or 保管）を取得できます。')


        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')

        <!-- 登録完了の表示に使用-->
        @if (session('message'))
            <div class="complete-message system__complete-message">
                {{ session('count') }}件の{{ session('message') }}
                {{-- @yield('alert') --}}
            </div>
        @endif

        <!-- 登録フォーム -->
        <form action="{{ url('/order_complete') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="label__forms">
                <button type="submit" class="label__submit order__submit">
                    指示データ受領
                </button>
              

                <div class="system__table read-content">
                    <table class="table">
                        <thead class="table-header">
                          <tr>
                            <th>日付</th>
                            <th>業務CD</th>
                            <th>書留番号</th>
                            <th>管理番号</th>
                            <th>封筒QR</th>
                            <th>状態</th>
                           
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($non_delivery as $non)
                              <tr class="table-row">
                                {{-- 例)value="MUBR11" selected(SESSIONと一致していれば)> --}}
                                {{-- <option value={{ $gyo->id }} {{ session('gyoumu') == $gyo->id ? 'selected' : '' }}>{{ $gyo->name }} </option>     --}}
                                <td>{{  \Carbon\Carbon::parse($non->non_delivery_date)->format('Y/m/d')}}</td>
                                <td>{{ $non->gyoumu_cd }}</td>
                                <td>{{ $non->kakitome_number}}</td>
                                <td>{{ $non->manage_number}}</td>
                                <td>{{ $non->huutou_qr_number}}</td>
                                <td>{{ $non->name}}</td>
                              </tr>
                            @endforeach
                         
                        </tbody>
                      </table>
                      
                </div>
             
            </div>
            {{-- <input type="hidden" name="non_delivery" value={{$non_delivery}}> --}}
        </form>
    
    <!-- Book: 既に登録されてる本のリスト -->

@endsection 