# 封筒在庫管理システム
封筒管理アプリについて

概要）
一度発送したが、住所不在などで届かなかった封筒をシステム上に登録し**在庫管理を行う**。
また、得意先からの指示データに合わせて**再発送・廃棄**などの指示を受ける

目指した課題解決）
・封筒を在庫管理する
・得意先（クライアント）が封筒ごとに再発送、廃棄を設定することができる

サイトURL）<br>
http://myservice-web.com/

システム図解：<br>
![システム図解](/yago.png)


## 基本機能<br>
ラベルデータ作成：枚数を入力すると、対応するラベルデータが登録される<br>
不着登録：封筒1通1通の情報を登録する<br>
不着データ生成：封筒データの登録を完了させる<br>
封筒状態参照：封筒を検索できる<br>
指示データ作成：不着データ生成された封筒に再発送、保管、廃棄の3種類の指示が来る<br>
再発送処理：封筒を再発送状態にする<br>
廃棄処理：封筒を廃棄状態にする<br>

## 開発環境
<br>・**フロントエンド**<br>
    - HTML/CSS<br>
    - JQuery<br>
<br>・**バックエンド**<br>
    - PHP(8.2.4)<br>
    - Laravel(10.9.0)<br>
    - MySQL(8.0.23)<br>
<br>・**インフラ**<br>
    - AWS(Routes53/EC2/VPC)<br>
<br>・ **バージョン管理**<br>
    - Git/GitHub<br>
<br>・**開発環境**<br>
    - VScode<br>

## システム構成図

## 画面遷移図

![画面遷移図](/画面遷移図.jpg)

## ER図


長文にも関わらず最後までご覧いただき、ありがとうございました。
