# 本気タスク
ユーザーのやる気を後押しするタスク管理アプリです。  
カレンダーと連携したタスクリスト項目を作成し、期日内に達成できないとユーザー情報が削除されます。  
(レスポンシブ対応されているため、PC・タブレット・スマホからでも利用できます。)  

# 作成した目的
職業訓練校で学んだスキルを活かしたいと考え、制作しました。  
私生活やビジネスシーンでの、「結局やらず仕舞いに終わってしまう」のを防ぐことを目的としています。  

# 使い方
## トップページ
![top_pc](https://user-images.githubusercontent.com/86467534/124408308-e3a92e80-dd80-11eb-8b76-91ded6db8f9c.png)  
ユーザー名とパスワードを入力してログインします。  
ユーザー登録をしていない方は、アカウントをお持ちでない方はこちらから登録ページに飛ぶことができます。  

## マイページ
![localhost_task_list_mypage php](https://user-images.githubusercontent.com/86467534/124408571-72b64680-dd81-11eb-85f1-0808f509097b.png)
タスク入力し期日を設定して登録ボタンを押すと、下に登録タスクの一覧として表示されます。  
期日までの残り時間がカウントダウンで表示され、残り時間が０になるまでに達成ボタンを押すと登録タスク一覧から消えます。  
残り時間が０になるまでに達成ボタンを押さないと、強制的にお叱りページに遷移されます。

# 使用言語
- HTML/CSS  
- JavaScript
- PHP 7.4
- MySQL 5.7

# データベース
loginテーブル  
![スクリーンショット 2021-06-24 11 47 25](https://user-images.githubusercontent.com/86467534/124408147-9200a400-dd80-11eb-9249-3d4e1dd7d966.png)  

tasklistテーブル  
![スクリーンショット 2021-06-24 13 47 27](https://user-images.githubusercontent.com/86467534/124408264-cc6a4100-dd80-11eb-9392-d52fdfac03e4.png)
