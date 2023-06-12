<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
@section('title', '照合結果データ作成画面')
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

       
    </div>
    <!-- Book: 既に登録されてる本のリスト -->

@endsection 