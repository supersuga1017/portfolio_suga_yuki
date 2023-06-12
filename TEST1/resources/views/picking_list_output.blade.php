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

        <div class="system__menu picking__syogo-menu">
            <p>照合メニュー</p>
            <p>指示件数</p>

            <p>総数</p>

            @foreach ($status as $sta)
                <input type="radio" id={{ $sta->id }} name="huutou_status" value={{ $sta->id }} >
                <label for={{ $sta->id }}>{{ $sta->name }}</label><br>

            @endforeach
            
           
            
            
        </div>

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