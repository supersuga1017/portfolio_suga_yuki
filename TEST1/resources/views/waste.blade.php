<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', '廃棄完了画面')

        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用-->
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('count') }}つの業務での{{ session('message') }}
            </div>
        @endif

        <p>データ作成リミット：12：00</p>

        
        <!-- 登録フォーム -->
        <form action="{{ url('/non_delivery_creation') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="label__forms">
                <div class="label__row">
                    <label for="">不着登録日：</label>
                    <input type="date" name="non_delivery_data" class="label__form" value="{{ date('Y-m-d') }}">
                </div>
                <div class="label__row">
                    <label for="">出力データ総件数：   {{$today_non_delivery_number}}件 </label>
                </div>

                <div class="system__table read-content">
                    <table class="table">
                        <thead class="table-header">
                          <tr>
                            <th>業務ID</th>
                            <th>区分</th>
                            <th>業務名</th>
                            <th>件数</th>
                           
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($non_delivery as $non)
                              <tr class="table-row">
                                {{-- 例)value="MUBR11" selected(SESSIONと一致していれば)> --}}
                                {{-- <option value={{ $gyo->id }} {{ session('gyoumu') == $gyo->id ? 'selected' : '' }}>{{ $gyo->name }} </option>     --}}
                                <td>{{ $non->gyoumu_cd }}</td>
                                <td>2</td>
                                <td>{{ $non->name}}</td>
                                <td>{{ $non->number}}</td>
                              </tr>
                            @endforeach
                         
                        </tbody>
                      </table>
                      
                </div>
                
                <button type="submit" class="label__submit">
                    データ生成（保管→指示待ちへフラグ変更）
                </button>
            </div>
            <input type="hidden" name="non_delivery" value={{$non_delivery}}>
        </form>

     

    <!-- Book: 既に登録されてる本のリスト -->

@endsection 