# README

## ① 課題名

**Simple Deal Manager v1.3 – PHP & MySQL CRUD + Data Visualization + Login Auth App**

---

## ② 課題内容（どんな作品か）

顧客情報と案件（Deal）データを登録・管理できる
**シンプルな業務データ管理アプリ**です。

本課題では、PHPとMySQLを用いたCRUD処理の理解に加え、
処理ごとの責務分離を意識したファイル構成・実装整理にも注力しました。

DB接続処理、データ取得・更新処理、表示ロジックを明確に分離し、
機能追加や修正時にも影響範囲を限定できる構成としています。

特に v1.1 では、

* DB接続処理の関数化
* 編集画面と更新処理の分離
* 処理専用PHPファイルへの役割分担

を行い、**「動く」だけでなく「保守しやすいCRUD構成」**を意識した設計にアップデートしました。

また v1.2 では、案件・顧客データを **集計・可視化する機能** を追加しました。
顧客マスタと案件テーブルを JOIN し、顧客別売上を集計した結果を
**Chart.js を用いたグラフ表示ページとして独立実装**しています。

そして v1.3 では、
**ログイン認証・権限制御（管理者専用画面）** を追加しました。

* セッションによるログイン状態管理（ログイン必須ページ制御）
* 権限フラグ（`u_role_flg`）による管理者専用ページ制御
* ユーザー有効/無効（`u_life_flg`）によるログイン可否判定
* **ユーザー管理画面（admin_users.php）** の追加

---

## ③ アプリのデプロイURL

**アプリURL**
[https://www.logic-craft.jp/bookmark-app/index.php](https://www.logic-craft.jp/bookmark-app/index.php)

---

## ④ アプリにログイン情報がある場合

あり（v1.3でログイン機能を追加）

本アプリでは、`user_master` テーブルに登録された
ユーザーID／パスワードを用いてログインします。
権限フラグおよび有効／無効フラグによって、アクセス可能な画面を制御しています。

### テスト用アカウント

* **管理者権限アカウント**
  ID：`test1` / PW：`test1`

* **一般権限アカウント**
  ID：`test2` / PW：`test2`

* **一般権限アカウント（無効ユーザー）**
  ID：`test3` / PW：`test3`
  ※有効フラグが無効のため、ログイン不可

---

## ⑤ こだわった点

### ■ 処理ごとの責務分離を意識したファイル構成（v1.1）

本アプリでは、**「1ファイル＝1責務」** を意識してPHPファイルを整理しています。
特に v1.1 ではCRUD一連の流れを整理し直し、**役割が曖昧になりやすい処理を明示的に分離**しました。

---

### ■ DB接続処理の関数化（db_conn） -- v1.1 Update

DB接続処理を `inc/functions.php` の `db_conn()` に関数化し、
各処理ファイルから共通で呼び出せるようにしました。
接続情報（定数）は `config/db.php` に集約し、役割分離を意識しています。

---

### ■ 案件の更新（UPDATE）機能の追加 -- v1.1 Update

一覧から編集リンクで `deal_edit.php?d_id=...` に遷移し、
該当データをフォームに初期表示 → `deal_update_action.php` へPOST → UPDATE の流れで更新処理を追加しました。
更新対象IDは hidden で渡し、WHERE句で対象レコードを限定しています。

---

### ■ データ集計・可視化ページの追加 -- v1.2 Update

v1.2 では顧客別売上を集計・可視化するためのグラフ専用ページ（`sales_chart.php`）を追加しました。

顧客マスタ（customer_master）と案件テーブル（deal_master）を **LEFT JOIN** し、
売上が未登録の顧客も含めて集計しています。
これにより「売上がまだ発生していない顧客」も 0 円として可視化できます。

---

### ■ グラフ描画における責務分離 -- v1.2 Update

* PHP：データ取得・集計・JSON化（`window.salesChartData` として渡す）
* JavaScript：Chart.js による描画（module）
* CSS：グラフ専用レイアウト（`chart.css`）

と役割分担して実装しています。

JavaScript は `assets/js/renderSalesChart.js` として切り出し、
`sales_chart.php` 側で `<script type="module">` により import し、描画関数を呼び出しています。

---

### ■ ログイン認証・権限制御（管理者専用画面） -- v1.3 Update

v1.3 では、ログイン画面（`login.php`）と認証処理（`login_action.php`）を追加し、
**セッションを用いたログイン状態管理**を実装しました。

基本設計として、ログイン必須ページに `require_login()` を適用し、
**URL直接アクセス（直叩き）を制御**しています。

さらに管理者専用ページについては `require_admin()` を用いて制御し、

* **サーバー側**：`require_admin()` による権限チェック
  （`require_login()` を内包し、ログイン未済も同時に遮断）
* **UI側**：権限フラグ（`u_role_flg`）に応じて管理者専用メニューを非表示

という **二段構え** にしています。

これにより、
「画面表示の制御」と「サーバー側のアクセス制御」を分離し、
**UI操作・URL直接指定の両方から不正アクセスを防ぐ構成**としています。

---

### ■ 管理者向け：ユーザー管理画面の追加（v1.3 Update）

管理者のみアクセス可能な **ユーザー管理画面（`admin_users.php`）** を追加しました。
`user_master` テーブルのユーザー情報（ID／ログインID／ロール／状態）を一覧表示し、
権限制御（Admin / User）と状態（Active / Disabled）の確認を可能にしています。

---

### ■ 共通ヘッダーの部品化（header.php）

共通UIとしてヘッダーを `inc/header.php` にまとめ、各ページから `include` で再利用しています。
これにより、ナビゲーションの追加・修正を1箇所で管理できるようにしています。

また、スマホ表示ではヘッダー内ボタンが潰れないように
ヘッダーが折り返し可能な設計に調整しました（flex-wrap対応）。  

---

## ⑥ 難しかった点・次回トライしたいこと

### ■ 難しかった点

* CRUD処理の責務整理（DB接続処理の関数化、編集画面と更新処理の分離）
* 編集画面での初期値反映（value / selected / hidden を用いたフォーム制御）
* JOINによる一覧表示・集計処理の整理
* ログイン認証（セッション管理）と権限制御の設計（v1.3）
* 管理者専用画面の導線と制御（ユーザー管理画面追加）

---

### ■ 次回トライしたいこと

* バリデーションの強化
* ソート・フィルタ機能の拡張
* 認証の強化（CSRF対策、ログイン失敗回数制限など）
* DB設計の拡張（外部キー制約など）
* 可視化ページの拡張（期間フィルタ、ランキング表示など）

---

## ⑦ フリー項目

今回は登録・一覧表示だけで終わらせず、
編集（EDIT）・更新（UPDATE）まで含めたCRUD一連の流れを実装しました。

また v1.2 で集計・可視化ページを追加し、
v1.3 でログイン認証・権限制御（管理者専用画面／ユーザー管理画面）まで拡張することで、
業務アプリとしての基本構成を段階的に広げています。

---

---

# 🗂 Simple Deal Manager – README

## 📝 概要（Overview）

**Simple Deal Manager** は、顧客情報と案件（Deal）データを登録・管理する
**シンプルな業務データ管理アプリ**です。

本課題では、
**PHPとMySQLを用いたデータベース操作（CRUD）の理解**を主目的とし、
フォーム入力からDB登録、一覧表示、編集、削除までの一連の流れを
最小構成で実装しています。

🔹 **V1.1**
責務分離を意識してファイル構成を再整理し、CRUD一連の操作（UPDATE含む）を実装。

🔹 **V1.2**
顧客別売上を集計し、**Chart.js による可視化ページを追加**。

🔹 **V1.3**
ログイン認証を導入し、**ログイン必須ページ・管理者専用ページ制御**を実装。
さらに、管理者向けの **ユーザー管理画面（admin_users.php）** を追加し、
権限・状態の一覧表示を可能にしました。

---

## 🎯 テーマ・学習目的

* PHPによるフォーム送信・受信処理
* MySQL（PDO）を用いたデータベース操作
* CRUD（Create / Read / Update / Delete）の基本実装
* 処理ごとの責務分離を意識したファイル設計
* include を用いた共通コンポーネントの分離
* CSSのコンポーネント設計によるUI整理
* 集計結果の可視化（Chart.js）
* ログイン認証・権限制御の基本設計（V1.3）

---

## 📋 機能一覧（Features）

### ▼ Deal管理（Deal）

* 案件データの登録
* 顧客 × 案件のリレーションを意識した設計
* 一覧表示（JOIN）
* 編集／更新（UPDATE）
* チェックボックスによる複数削除

### ▼ Customer管理（Admin Only）

* 顧客情報の登録
* 顧客一覧表示
  ※管理者のみアクセス可能（`require_admin()`）

### ▼ 顧客別売上グラフ（V1.2）

* 顧客別売上の集計（LEFT JOIN）
* 売上0の顧客も含めて表示
* Chart.js によるグラフ描画
* JS描画ロジックを `assets/js/renderSalesChart.js` に分離

### ▼ ログイン認証・権限制御（V1.3）

* ログイン画面によるユーザー認証
* セッションでログイン状態管理
* 有効ユーザー（`u_life_flg = 0`）のみログイン可能
* 権限フラグ（`u_role_flg`）による管理者専用ページ制御

### ▼ ユーザー管理画面（Admin Only / V1.3）

* `user_master` のユーザー情報を一覧表示
* ロール（Admin / User）と状態（Active / Disabled）を表示
  ※管理者のみアクセス可能（`require_admin()`）

---

## 🔧 設計・構成のポイント

本アプリでは、**処理ごとの責務分離と可読性**を重視した構成を採用しています。

* DB接続情報は `config/db.php` に集約
* DB接続処理は `db_conn()` として関数化（`inc/functions.php`）
* XSS対策の `h()` など共通関数を集中管理
* ヘッダーを `inc/header.php` として共通化
* CSSはUIの役割ごとに分割（button / form / table / chart / login）
* スマホ時のヘッダー崩れを防ぐため折り返し設計を調整  
* Chart描画は「PHP集計 → JS描画 → CSSレイアウト」で責務分離
* テーブルUIは共通スタイルとして管理（deal/usersで調整） 
* UIトークン（root変数）による一括デザイン制御 

---

## 🛠 技術スタック（Tech Stack）

* HTML
* CSS
* PHP
* MySQL
* Chart.js

---

## 🗂 ディレクトリ構成

```
assets/
├─ css/
│  ├─ buttons.css          // ボタンUI
│  ├─ chart.css            // グラフ専用スタイル（v1.2）
│  ├─ form.css             // フォームUI
│  ├─ login.css            // ログイン画面専用スタイル（v1.3）
│  ├─ responsive.css       // レスポンシブ対応
│  ├─ scroll.css           // スクロールUI
│  ├─ style.css            // 共通スタイル（root変数含む）
│  └─ table.css            // テーブルUI
└─ js/
   └─ renderSalesChart.js  // Chart描画モジュール（v1.2）

config/
├─ .htaccess
└─ db.php                  // DB接続情報

inc/
├─ functions.php           // 共通関数（h(), db_conn(), redirect(), 認証系require_*）
└─ header.php              // 共通ヘッダー（旧 header.html）

tools/                     // ※ignore（開発補助）
└─ make_hash.php           // パスワードハッシュ生成

deals_list.php             // 案件管理（登録・一覧・編集導線・削除）
deal_create_action.php     // 案件登録処理
deal_edit.php              // 案件編集画面（v1.1）
deal_update_action.php     // 案件更新処理（v1.1）
deal_delete_action.php     // 案件削除処理

customers_list.php         // 顧客管理（管理者専用）
customer_create_action.php // 顧客登録処理

sales_chart.php            // 顧客別売上グラフ（v1.2）

admin_users.php            // ユーザー管理（管理者専用 / v1.3）

login.php                  // ログイン画面（v1.3）
login_action.php           // ログイン処理
logout_action.php          // ログアウト処理
```

---

## ▶ 使い方（How to Use）

1. ローカル環境でPHPとMySQLを起動（XAMPP 等）
2. データベースを作成し、テーブルを準備
3. ブラウザで `deals_list.php`（または `index.php`）にアクセス
4. ログインして顧客・案件データを登録
5. 一覧画面でCRUD操作を実行
6. グラフページで顧客別売上を確認

---

## 📄 注意事項

* 本プロジェクトは **学習目的** で制作しています
* セキュリティ・バリデーションは最小限の実装です

---

---

# 🗂 Simple Deal Manager – README

## 📝 Overview

**Simple Deal Manager** is a simple business data management application
for registering and managing **customers** and **deal records**.

The primary goal of this project is to understand
**database operations (CRUD) using PHP and MySQL**,
by implementing the full workflow from form input to
database insertion, list display, editing, and deletion
with a minimal and readable structure.

🔹 **Version 1.1**
The file structure was reorganized with a clear separation of responsibilities,
and edit/update (UPDATE) functionality was added to complete the CRUD cycle.

🔹 **Version 1.2**
A dedicated chart page was added to visualize aggregated sales data by customer using **Chart.js**.

🔹 **Version 1.3**
Login authentication and role-based access control were implemented.
Administrator-only pages were added, including a **User Management screen (`admin_users.php`)**.

---

## 🎯 Learning Objectives

* Handling form submission with PHP
* Database operations using MySQL (PDO)
* Basic implementation of CRUD (Create / Read / Update / Delete)
* Designing PHP files with clear responsibility separation
* Reusing common components with `include`
* Organizing UI using component-based CSS design
* Visualizing aggregated data with Chart.js
* Designing basic login authentication and role-based access control (v1.3)

---

## 📋 Features

### ▼ Deal Management

* Register deal records linked to customers
* List view using SQL JOIN
* Edit & update (UPDATE)
* Multi-select delete via checkboxes

### ▼ Customer Management (Admin Only)

* Register customers
* Display customer list
* Admin access control via `require_admin()`

### ▼ Customer Sales Chart (Added in v1.2)

* Aggregate customer sales using **LEFT JOIN**
* Include customers with no sales as zero-value data
* Visualize results with **Chart.js**
* Rendering logic separated into an ES module:
  `assets/js/renderSalesChart.js`

### ▼ Login Authentication & Authorization (Added in v1.3)

* User login screen
* Session-based login state management
* Only active users (`u_life_flg = 0`) can log in
* Role-based access control using `u_role_flg`

### ▼ User Management Screen (Admin Only / v1.3)

* Display user list from `user_master`
* Show role (Admin / User) and status (Active / Disabled)
* Admin-only access control via `require_admin()`

---

## 🔧 Design & Architecture Notes

This application is structured with a strong focus on
**clear separation of responsibilities and readability**.

* Database configuration is centralized in `config/db.php`
* DB connection logic is encapsulated in `db_conn()` (`inc/functions.php`)
* Shared helper functions like `h()` (escape) are centralized
* Common header is implemented as `inc/header.php`
* CSS is split by role (button / form / table / chart / login)
* Mobile header layout is adjusted to prevent button collapse  
* Table styles are shared and extended for users/deals lists 
* UI tokens (root variables) are used for consistent design control 

---

## 🛠 Tech Stack

* HTML
* CSS
* PHP
* MySQL
* Chart.js

---

## 🗂 Directory Structure

```
assets/
├─ css/
│  ├─ buttons.css
│  ├─ chart.css
│  ├─ form.css
│  ├─ login.css
│  ├─ responsive.css
│  ├─ scroll.css
│  ├─ style.css
│  └─ table.css
└─ js/
   └─ renderSalesChart.js

config/
└─ db.php

inc/
├─ functions.php
└─ header.php

deals_list.php
deal_create_action.php
deal_edit.php
deal_update_action.php
deal_delete_action.php

customers_list.php
customer_create_action.php

sales_chart.php

admin_users.php

login.php
login_action.php
logout_action.php
```

---

## 📄 Notes

* This project is created **for learning purposes**
* Security measures and validation are intentionally minimal

---
