# flea_market_app

    フリマサービス
    ！[image](https://github.com/user-attachments/assets/2ad274f3-00d0-4fa7-84d8-ab915ca0b861)

##　目的

    coachtechブランドのアイテムを出品するため

## URL

    git@github.com:shobuhinako/flea_market_app.git

## 機能一覧

    1. 会員登録
    2. ログイン
    3. ログアウト
    4. 商品一覧取得
    5. 商品詳細取得
    6. ユーザー商品お気に入り一覧取得
    7. ユーザー情報取得
    8. ユーザー購入商品一覧取得
    9. ユーザー出品商品一覧取得
    10. プロフィール変更
    11. 商品お気に入り追加
    12. 商品お気に入り削除
    13. 商品コメント追加
    14. 商品コメント削除
    15. 出品
    16. 購入（クレジットカード、銀行振込）
    17. 配送先変更
    18. 商品検索
    19. 管理者作成（管理者のみ）
    20. 出品者への送金額確認（管理者のみ）
    21. お知らせメール送信（管理者のみ）
    22. テスト実施
    23. 住所自動入力
    24. 商品並び替え（金額順）、フィルター（カテゴリ、販売状況）
    25. クーポン発行（管理者のみ）
    26. クーポン使用
    27. 取引評価
    28. パワーセラー表示

## 使用技術

    laravel 8.83.27

## テーブル設計

    ![image](https://github.com/user-attachments/assets/de4f0c70-eb7d-400e-82b2-d6234121cd9e)

## 環境構築

    1. コンテナの起動とビルド
       docker-compose up -d --build
    2. コンテナにアクセス
       docker-compose exec php bash
    3. 依存パッケージのインストール
       composer install
    4. .env.exampleファイルから.envを作成し、環境変数を変更
    5. アプリケーションキーの生成
       php artisan key:generate
    6. データベースのマイグレーション
       php artisan migrate
    7. データベースのシーディング
       php artisan db:seed

## テストアカウント

    パスワードはすべて共通でpassword
    1. admin@gmail.com（管理者アカウント）
    2. tarou@gmail.com（一般ユーザー）
    3. jirou@gmail.com（一般ユーザー）
