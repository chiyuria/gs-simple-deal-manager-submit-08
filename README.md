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

また v1.2 では、
案件・顧客データを **集計・可視化する機能** を追加しました。
顧客マスタと案件テーブルを JOIN し、顧客別売上を集計した結果を
**Chart.js を用いたグラフ表示ページとして独立実装**しています。

そして v1.3 では、
**ログイン認証・権限制御（管理者専用画面）** を追加しました。
セッションによるログイン状態管理に加え、権限フラグ（`u_role_flg`）で
管理者のみが顧客管理画面へアクセスできるよう制御しています。

---

## ③ アプリのデプロイURL

**アプリURL**
[https://www.logic-craft.jp/bookmark-app/index.php](https://www.logic-craft.jp/bookmark-app/index.php)

---

## ④ アプリにログイン情報がある場合

あり（v1.3でログイン機能を追加）

本アプリでは、`user_master` テーブルに登録された
ユーザーID／パスワードを用いてログインします。
権限フラグおよび有効／無効フラグによって、
アクセス可能な画面を制御しています。

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
特に v1.1 ではCRUD一連の流れを整理し直し、
**役割が曖昧になりやすい処理を明示的に分離**しました。

### ■ DB接続処理の関数化（db_conn） -- v1.1 Update

DB接続処理を `inc/functions.php` の `db_conn()` に関数化し、
各処理ファイルから共通で呼び出せるようにしました。
接続情報（定数）は `config/db.php` に集約し、役割分離を意識しています。

### ■ 案件の更新（UPDATE）機能の追加 -- v1.1 Update

一覧（index / deals_list）から編集リンクで `deal_edit.php?d_id=...` に遷移し、
該当データをフォームに初期表示 → `deal_update_action.php` へPOST → UPDATE の流れで更新処理を追加しました。
更新対象IDは hidden で渡し、WHERE句で対象レコードを限定しています。

### ■ データ集計・可視化ページの追加 -- v1.2 Update

v1.2 では顧客別売上を集計・可視化するための
グラフ専用ページ（sales_chart.php）を追加しました。

顧客マスタ（customer_master）と案件テーブル（deal_master）を LEFT JOIN し、
売上が未登録の顧客も含めて集計しています。
これにより「売上がまだ発生していない顧客」も 0 円として可視化できます。

### ■ グラフ描画における責務分離 -- v1.2 Update

・PHP：データ取得・集計・JSON化
・JavaScript：Chart.js による描画（module）
・CSS：グラフ専用レイアウト（chart.css）

と、役割を分離して実装しています。
JavaScript は `assets/js/renderChart.js` に切り出し、
`sales_chart.php` 側で `<script type="module">` による import で読み込み、描画関数を呼び出しています。

---

### ■ ログイン認証・権限制御（管理者専用画面） -- v1.3 Update

v1.3 では、ログイン画面（`login.php`）と認証処理（`login_action.php`）を追加し、
**セッションを用いたログイン状態管理**を実装しました。

基本設計として、
すべてのログイン必須ページに対して
`require_login()` を用いた **直アクセス（URL直接叩き）制御** を行っています。

そのうえで、顧客管理画面については **管理者のみアクセス可能** とし、

* サーバー側：
  `require_admin()` による管理者権限チェック
  （`require_login()` を内包し、URL直接アクセスを防止）

* UI側：
  権限フラグ（`u_role_flg`）に応じて
  管理者専用ボタンを非表示
  （一般ユーザーに管理画面への導線を出さない）

という **二段構えの制御** を行っています。

これにより、
「画面表示の制御」と「サーバー側でのアクセス制御」を分離し、
**UI操作・URL直接指定のどちらからも不正アクセスを防ぐ構成**としています。

---

### ■ データの関連性を意識したDB設計（JOINの活用）

顧客テーブルと案件テーブルを分離し、一覧表示時に JOIN を用いてデータを取得しています。
データの関連性を **DB設計とSQLで担保する**ことで、表示ロジックをシンプルに保っています。

---

## ⑥ 難しかった点・次回トライしたいこと

### ■ 難しかった点

* CRUD処理の責務整理（DB接続処理の関数化、編集画面と更新処理の分離）
* 編集画面での初期値反映（value / selected / hidden を用いたフォーム制御）
* JOINによる一覧表示・集計処理の整理
* ログイン認証（セッション管理）と権限制御の設計（v1.3）

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

また、v1.2で集計・可視化ページを追加し、
v1.3でログイン認証・権限制御（管理者専用画面）まで拡張することで、
業務アプリとしての基本構成を段階的に広げています。

---

# 🗂 Simple Deal Manager – README

## 📝 概要（Overview）

**Simple Deal Manager** は、
顧客情報と案件（Deal）データを登録・管理する
**シンプルな業務データ管理アプリ**です。

本課題では、
**PHPとMySQLを用いたデータベース操作（CRUD）の理解**を主目的とし、
フォーム入力からDB登録、一覧表示、編集、削除までの一連の流れを
最小構成で実装しています。

🔹 **V1.1**
処理ごとの責務分離を意識してファイル構成を再整理し、
編集・更新（UPDATE）機能を含むCRUD一連の操作を実装しました。

🔹 **V1.2**
顧客・案件データを集計し、
**顧客別売上をグラフとして可視化する専用ページを追加**しました。
CRUD機能に加え、**「データを俯瞰する画面」**を導入することで、
業務アプリとしての構成を一段拡張しています。


🔹 **V1.3**
ログイン認証機能を追加し、
**ログイン必須ページ・管理者専用ページの制御を実装**しました。
ユーザーの有効／無効フラグ（`u_life_flg`）や
権限フラグ（`u_role_flg`）を用いた判定を共通関数として切り出し、
業務アプリとしての 基本的な認証・認可構造 を組み込んでいます。

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

### ▼ 顧客管理機能（Customer）

* 顧客情報の登録
* 顧客一覧の表示
* DBへのINSERT処理

### ▼ 案件管理機能（Deal）

* 顧客と紐づく案件データの登録
* 顧客 × 案件のリレーションを意識した設計

### ▼ 一覧表示機能

* 顧客名・案件情報をJOINで取得し一覧表示
* 複数データを想定したテーブルレイアウト
* 横スクロール対応テーブルUI
* 編集・削除処理への導線

### ▼ 編集・更新機能（V1.1追加）

* 一覧画面から編集対象を選択
* 対象案件データを取得し、フォームに初期値として表示
* hidden要素でIDを保持し、更新処理を実行
* 編集画面と更新処理を別ファイルで分離

### ▼ 削除機能

* チェックボックスによる複数選択削除
* 削除処理専用PHPファイルによる責務分離

### ▼ 顧客別売上グラフ表示（V1.2追加）

* 顧客マスタと案件テーブルを **LEFT JOIN** して売上を集計
* 売上未登録の顧客も 0 円として可視化
* 集計結果を Chart.js で棒グラフ表示
* グラフ専用ページとして独立実装
* JavaScriptは `assets/js/renderChart.js` を **ES Modules** として読み込み描画

### ▼ ログイン認証・権限制御（V1.3追加）

* ログイン画面によるユーザー認証
* セッションを用いたログイン状態の管理
* 有効ユーザー（`u_life_flg = 0`）のみログイン可能
* 管理者権限フラグ（`u_role_flg`）によるページアクセス制御
* 認証・認可処理を共通関数として切り出し、各ページで再利用

---

## 🔧 設計・構成のポイント

本アプリでは、
**処理ごとの責務分離と可読性**を重視した構成を採用しています。

### 主な設計意図

* DB接続情報は `config/db.php` に集約
* DB接続処理を `db_conn()` として関数化し、`inc/functions.php` に切り出し
* XSS対策用のエスケープ関数を共通関数として管理
* HTMLヘッダーを共通コンポーネントとして include
* CSSはUIの役割ごとに分割（button / form / table / chart / login）
* ログイン画面専用のCSSを `login.css` として分離し、例外UIを局所化
* グラフ描画は「PHP(集計) → JS(module描画) → CSS(レイアウト)」で役割分担
* 顧客テーブルと案件テーブルを分離し、
  一覧表示・集計時は **JOIN を用いてデータの関連性をDB側で担保**

CRUD画面・可視化画面・認証画面を分離することで、
表示ロジック・集計処理・UI構造の役割を明確にしています。

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
│  ├─ buttons.css       // ボタンUI
│  ├─ chart.css         // グラフ専用スタイル（v1.2）
│  ├─ form.css          // フォームUI
│  ├─ login.css         // ログイン画面専用スタイル（v1.3）
│  ├─ responsive.css    // レスポンシブ対応
│  ├─ scroll.css        // スクロールUI
│  ├─ style.css         // 共通スタイル
│  └─ table.css         // テーブルUI
└─ js/
   └─ renderChart.js    // Chart描画モジュール（v1.2）

config/
├─ .htaccess
└─ db.php               // DB接続情報

inc/
├─ functions.php        // 共通関数（h(), db_conn(), redirect(), 認証系require_*）
└─ header.html          // 共通ヘッダー

tools/                  // ※ignore（開発補助）
└─ make_hash.php        // パスワードハッシュ生成

index.php                   // 案件一覧（JOIN / 編集・削除導線）
customers_list.php          // 顧客一覧
customer_create_action.php  // 顧客登録処理

deals_list.php              // 案件一覧
deal_create_action.php      // 案件登録処理
deal_edit.php               // 案件編集画面（v1.1）
deal_update_action.php      // 案件更新処理（v1.1）
deal_delete_action.php      // 案件削除処理

sales_chart.php             // 顧客別売上グラフ（v1.2）

login.php                   // ログイン画面（v1.3）
login_action.php            // ログイン処理
logout_action.php           // ログアウト処理
```

---

## ▶ 使い方（How to Use）

1. ローカル環境でPHPとMySQLを起動（XAMPP 等）
2. データベースを作成し、テーブルを準備
3. ブラウザで `index.php` にアクセス
4. 顧客・案件データを登録
5. 一覧画面でCRUD操作を実行
6. グラフページで顧客別売上を確認

---

## 📘 学習ポイント（Learning）

* PHPによるフォーム処理の基本
* PDOを用いた安全なDB操作
* CRUD処理における責務分離の考え方
* 編集画面と更新処理を分離した設計
* include を用いたコード再利用
* 集計データの可視化とUI整理
* JavaScriptモジュール（ES Modules）での描画ロジック分離
* セッションを用いたログイン認証の実装
* 権限フラグによるページアクセス制御

---

## 📄 注意事項

* 本プロジェクトは **学習目的** で制作しています
* セキュリティ・バリデーションは最小限の実装です

---

# 🗂 Simple Deal Manager – README

## 📝 Overview

**Simple Deal Manager** is a simple business data management application
for registering and managing **customers** and **deal records**.

The primary goal of this project is to understand
**database operations (CRUD) using PHP and MySQL**,
by implementing the complete workflow from form input to
database insertion, list display, editing, and deletion
with a minimal and readable structure.

🔹 **Version 1.1**
The file structure was reorganized with a clear separation of responsibilities,
and edit/update (UPDATE) functionality was added to complete the CRUD cycle.

🔹 **Version 1.2**
A dedicated page was added to visualize aggregated sales data by customer.
In addition to CRUD operations, the application now includes
an **overview screen for data analysis**, extending it toward
a more business-oriented structure.

🔹 **Version 1.3**
Login authentication was introduced, along with access control for
login-required pages and administrator-only pages.
User status flags (`u_life_flg`) and role flags (`u_role_flg`) are used
to determine access permissions, and the authentication/authorization logic
is implemented as reusable shared functions.

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

### ▼ Customer Management

* Register customer information
* Display a customer list
* Insert customer data into the database

### ▼ Deal Management

* Register deal data associated with a customer
* Designed with customer–deal relationships in mind

### ▼ List View

* Display customer and deal data using SQL JOINs
* Table layout designed for multiple records
* Horizontally scrollable table UI
* Clear navigation to edit and delete actions

### ▼ Edit & Update Function (Added in v1.1)

* Select a target deal from the list view
* Fetch the selected deal data and prefill the edit form
* Preserve the record ID using a hidden field
* Execute UPDATE processing via a dedicated action file
* Clear separation between edit (UI) and update (logic)

### ▼ Delete Function

* Delete deal records
* Support for selecting multiple records using checkboxes
* Dedicated PHP file for delete processing

### ▼ Customer Sales Chart (Added in v1.2)

* Aggregate deal sales per customer using **LEFT JOIN**
* Include customers with no sales as zero-value data
* Visualize aggregated results using **Chart.js**
* Implemented as an independent page for clear responsibility separation
* Chart rendering logic is separated into an ES module:
  `assets/js/renderChart.js`

### ▼ Login Authentication & Authorization (Added in v1.3)

* User authentication via a login screen
* Session-based login state management
* Only active users (`u_life_flg = 0`) are allowed to log in
* Role-based page access control using `u_role_flg`
* Authentication and authorization logic centralized as shared functions

---

## 🔧 Design & Architecture Notes

This application is structured with a strong focus on
**clear separation of responsibilities and code readability**.

### Key design points

* Database connection settings are centralized in `config/db.php`
* Database connection logic is encapsulated in a reusable `db_conn()` function
  defined in `inc/functions.php`
* XSS protection helper functions are managed as shared utilities
* The HTML header is implemented as a shared component using `include`
* CSS is split by role (button / form / table / chart / login)
* Login-specific UI styles are isolated in `login.css` to avoid polluting global styles
* Chart rendering is separated by responsibility:

  * PHP: aggregate data
  * JavaScript: render charts via an ES module
  * CSS: handle chart-specific layout
* Customer and deal data are stored in separate tables
* List views and aggregation logic retrieve data using **SQL JOINs**,
  ensuring data relationships are enforced at the database level

By separating CRUD screens, visualization screens, and authentication screens,
the application maintains a clear structure and remains easy to extend.

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
│  ├─ buttons.css       // Button UI styles
│  ├─ chart.css         // Chart-specific styles (v1.2)
│  ├─ form.css          // Form UI styles
│  ├─ login.css         // Login screen styles (v1.3)
│  ├─ responsive.css   // Responsive layout
│  ├─ scroll.css       // Scrollbar customization
│  ├─ style.css        // Base styles and variables
│  └─ table.css        // Table UI styles
└─ js/
   └─ renderChart.js    // Chart rendering module (v1.2)

config/
├─ .htaccess
└─ db.php               // Database configuration

inc/
├─ functions.php        // Shared helper functions (db_conn, redirect, auth guards)
└─ header.html          // Shared header component

tools/                  // Ignored directory (development utilities)
└─ make_hash.php        // Password hash generator

index.php                   // Deal list (JOIN, edit & delete links)
customers_list.php          // Customer list view
customer_create_action.php  // Customer create processing

deals_list.php              // Deal list view
deal_create_action.php      // Deal create processing
deal_edit.php               // Deal edit screen (v1.1)
deal_update_action.php      // Deal update processing (v1.1)
deal_delete_action.php      // Deal delete processing

sales_chart.php             // Customer sales chart (v1.2)

login.php                   // Login screen (v1.3)
login_action.php            // Login processing
logout_action.php           // Logout processing
```

---

## ▶ How to Use

1. Start PHP and MySQL in a local environment (e.g. XAMPP)
2. Create a database and required tables
3. Access `index.php` in your browser
4. Register customers and deals
5. Perform CRUD operations from the list screen
6. View aggregated customer sales on the chart page

---

## 📘 Key Learnings

* Basic form handling with PHP
* Safe database operations using PDO
* Separation of responsibilities in CRUD processing
* Clear distinction between UI files and action files
* Code reuse with `include`
* Aggregating and visualizing data for business insight
* Session-based login authentication
* Role-based access control using flags

---

## 📄 Notes

* This project is created **for learning purposes**
* Security measures and validation are intentionally minimal

---
