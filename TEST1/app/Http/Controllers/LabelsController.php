<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//使うClassを宣言:自分で追加
use App\Models\Label;
use Validator;  //バリデーションを使えるようにする
use Auth;       //認証モデルを使用する


class LabelsController extends Controller
{
    //
    //更新
    public function index(Request $request) {

    }

    //バリデーション
    public function getLabelValidator(Request $request) {
        //バリデーション
       $validator = Validator::make($request->all(), [
           'all_number' => 'required | min:1 | max:3',
       ]);
       return $validator;
    }


    
    //更新
    public function label_register(Request $request) {

        // バリデーションエラーがある場合は次へ進めない
        $validator = $this->getLabelValidator($request);
        //バリデーション:エラー 
        if ($validator->fails()) {
            return redirect('/label')
                ->withInput()
                ->withErrors($validator);
        }


        // ラベルデータを登録
        $labels = new Label;
        $labels->non_delivery_data = $request->non_delivery_data;
        $labels->all_number = $request->all_number;
        $labels->customer_cd = "4";
        $labels->save();

        return redirect('/label')->with(['message'=>'ラベル登録が完了しました。','all_number'=>$request->all_number,'non_delivery_data'=>$request->non_delivery_data ]);
    }
}
