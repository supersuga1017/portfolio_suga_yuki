<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@inject('status','App\Http\Controllers\StatusSearchController')
@section('content')
@section('title', '状態検索画面')

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
        <form action="{{ url('/status_search') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="label__forms">
                <div class="label__row">
                    <label for="">不着登録日：</label>
                    <input type="date" name="non_delivery_data" class="label__form" value="{{ date('Y-m-d') }}">

                    <label for="">書留番号：</label>
                    <input type="number" name="kakitome_number" class="label__form" value="" placeholder="任意の数字">
                    <br>

                    
                    <label for="">状態：</label>
                    <select class="label__form" id="statuses" name="statuses">
                        <option value="0">全て</option>    
                        @foreach ($statuses as $sta)
                            <option value={{ $sta->id }}>{{ $sta->name }}</option>    
                        @endforeach
                    </select>

                    <label for="">業務CD：</label>
                    <select class="label__form" id="statuses" name="statuses">
                        <option value="0">全て</option>    
                        @foreach ($gyoumu as $gyo)
                            <option value={{ $gyo->id }}>{{ $gyo->name }}</option>    
                        @endforeach
                    </select>


                    <button type="submit" class="label__submit">
                        検索
                    </button>
                </div>
               
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
                            @foreach ($non_delivery_detail as $non)
                              <tr class="table-row">
                                {{-- 例)value="MUBR11" selected(SESSIONと一致していれば)> --}}
                                {{-- <option value={{ $gyo->id }} {{ session('gyoumu') == $gyo->id ? 'selected' : '' }}>{{ $gyo->name }} </option>     --}}
                                <td>{{  \Carbon\Carbon::parse($non->date)->format('Y/m/d')}}</td>
                                <td>{{ $non->gyoumu_cd }}</td>
                                <td>{{ $non->kakitome_number}}</td>
                                <td>{{ $non->manage_number}}</td>
                                <td>{{ $non->huutou_qr_number}}</td>
                                <td class={{ $status-> status_color($non->status_cd) }}>{{ $non->name}}</td>

                              </tr>
                            @endforeach
                         
                        </tbody>
                      </table>
                      
                </div>
                
               
            </div>
            <input type="hidden" name="non_delivery_detail" value={{$non_delivery_detail}}>
        </form>
      

     

    <!-- Book: 既に登録されてる本のリスト -->

@endsection 