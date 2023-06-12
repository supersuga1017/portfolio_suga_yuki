<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', '廃棄管理画面')
@section('modal', '')

    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用-->
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('count') }}件の{{ session('message') }}
            </div>
        @endif

        <div class="system__menu picking__syogo-menu">
            

            <p>表示内容</p>

            <input type="radio" id="b" name="huutou_status" value="aaaa">
            <label for="b">マニフェスト依頼未</label><br>           
            
            <input type="radio" id="b" name="huutou_status" value="aaaa">
            <label for="b">廃棄待ち（マニフェスト依頼済）</label><br>           
            

            <input type="radio" id="b" name="huutou_status" value="aaaa">
            <label for="b">廃棄完了</label><br>           
            

            <input type="radio" id="b" name="huutou_status" value="aaaa">
            <label for="b">全て</label><br>           
            
            <button type="submit" class="label__submit">検索</button>
            
        </div>

        <div class="system__menu picking__syogo-menu">
            

            <p>条件</p>

           <div class="non_delivery_forms forms">
            <div class="label__row">
                <label for="">廃棄BOXNo：</label><br>
                <input type="number" name="kakitome_number" class="label__form" form="form_finish">
            </div>

            <div class="label__row">
                <label for="">マニフェスト依頼管理番号</label><br>
                <input type="number" name="manage_number" class="label__form" form="form_finish">
            </div>

            <div class="label__row">
                <label for="">廃棄登録日</label><br>
                <input type="number" name="huutou_qr_number" class="label__form" form="form_finish">
            </div>

          
        
        </div>
            
        </div>


       
    </div>

@endsection 