<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', 'ラベル印刷画面')
@section('alert', 'ラベル印刷画面')
@section('description', 'こちらの画面では、不着登録（次の工程）で使用するラベル枚数を指定できます。')


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
                <div class="label__row">

                    <label for="">総通数：    </label>
                    <input type="number" name="all_number" class="label__form">通
                </div>

                {{-- <div class="label__information non_delivery__label-information">
                    <p>ラベル情報 </p>
                    <p>{{date('Y/m/d')}}の印刷枚数：{{ $today_label_number }}枚</p>
                </div> --}}
                
                <button type="submit" class="label__submit">
                    登録
                </button>
            </div>
        
        </form>

        <p class="label__table-heading">発行ラベル履歴</p>

        <div class="system__table read-content">
            <table class="table">
                <thead class="table-header">
                  <tr>
                    <th>日付</th>
                    <th>ラベル番号</th>
                    <th>不着登録使用済</th>
    
                   
                  </tr>
                </thead>
                <tbody>
                    @foreach ($gyoumu as $non)
                      <tr class="table-row">
                        {{-- 例)value="MUBR11" selected(SESSIONと一致していれば)> --}}
                        {{-- <option value={{ $gyo->id }} {{ session('gyoumu') == $gyo->id ? 'selected' : '' }}>{{ $gyo->name }} </option>     --}}
                        {{-- <td>{{  \Carbon\Carbon::parse($non->date)->format('Y/m/d')}}</td> --}}
                        <td>{{ $non->name }}</td>
                        <td>{{ $non->name }}</td>
                        <td>{{ $non->name }}</td>
                        
                        
                      </tr>
                    @endforeach
                 
                </tbody>
            </table>
              
        </div>
        <!-- 新規印刷登録フォーム -->
        {{-- <form action="{{ url('/label/new-print') }}" method="POST" class="form-horizontal">
            @csrf
            <p>新規印刷</p>
            <div class="label__forms">
                <div class="label__row">
                    <label for="">業務名：</label>
                    <select class="label__form" id="sort-by" name="sort-by">
                        @foreach ($gyoumu as $gyo)
                            <option value={{ $gyo->id }}>{{ $gyo->name }}</option>    
                        @endforeach
                      
                    </select>
                    
                </div>


                <div class="label__row">

                    <label for="">印刷枚数 ：</label>
                    <input type="number" name="all_number" class="label__form">通
                </div>
                
                <button type="submit" class="label__submit">
                    一括登録
                </button>
            </div>
        
        </form>

        <p>末番削除</p> --}}

    <!-- Book: 既に登録されてる本のリスト -->

@endsection 