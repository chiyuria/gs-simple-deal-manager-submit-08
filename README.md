# README

## ① 課題名

**Simple Deal Manager v1.1 – PHP & MySQL CRUD App**

---

## ② 課題内容（どんな作品か）

顧客情報と案件（Deal）データを登録・管理できる  
**シンプルな業務データ管理アプリ**です。

本課題では、PHPとMySQLを用いたCRUD処理の理解に加え、
処理ごとの責務分離を意識したファイル構成・実装整理にも注力しました。

DB接続処理、データ取得・更新処理、表示ロジックを明確に分離し、
機能追加や修正時にも影響範囲を限定できる構成としています。

特に v1.1 では、
- DB接続処理の関数化
- 編集画面と更新処理の分離
- 処理専用PHPファイルへの役割分担

を行い、**「動く」だけでなく「保守しやすいCRUD構成」**を意識した設計にアップデートしました。

---

## ③ アプリのデプロイURL

**アプリURL**  
https://www.logic-craft.jp/bookmark-app/index.php

---

## ④ アプリにログイン情報がある場合

なし

---

## ⑤ こだわった点

### ■ 処理ごとの責務分離を意識したファイル構成（v1.1）

本アプリでは、
**「1ファイル＝1責務」** を意識してPHPファイルを整理しています。

特に v1.1 では、CRUD一連の流れを整理し直し、
**役割が曖昧になりやすい処理を明示的に分離**しました。

### ■ DB接続処理の関数化（db_conn） --v1.1 Update
DB接続処理を `inc/functions.php` の `db_conn()` に関数化し、  
各処理ファイルから共通で呼び出せるようにしました。  
接続情報（定数）は `config/db.php` に集約し、役割分離を意識しています。

### ■ 案件の更新（UPDATE）機能の追加 --v1.1 Update
一覧（index）から編集リンクで `deal_edit.php?d_id=...` に遷移し、  
該当データをフォームに初期表示 → `deal_update_action.php` へPOST → UPDATE の流れで更新処理を追加しました。  
更新対象IDは hidden で渡し、WHERE句で対象レコードを限定しています。

### ■ データの関連性を意識したDB設計（JOINの活用）

顧客テーブルと案件テーブルを分離し、  
一覧表示時に JOIN を用いてデータを取得しています。

これにより、  
片方のデータ構造や内容を変更した場合でも  
他方のデータを破壊しない設計を意識しました。

データの関連性を  
**DB設計とSQLで担保する**ことで、  
表示ロジックをシンプルに保っています。

---

### ■ PHP処理の役割分離

* DB接続処理
* フォーム送信・受信処理
* データ登録処理
* 一覧表示処理
* 削除処理

をファイル単位で分離し、  
処理の流れが追いやすい構成を意識しました。

---

### ■ include を用いた共通コンポーネント化

共通ヘッダーを `include` で読み込み、  
HTML構造の重複を避けています。

---

### ■ CSSのコンポーネント分割

CSSを以下のように役割ごとに分割しています。

* 共通スタイル・変数定義
* フォームUI
* ボタンUI
* テーブルUI

UIの一貫性と保守性を意識した構成にしています。

---

## ⑥ 難しかった点・次回トライしたいこと

### ■ 難しかった点

* CRUD処理の責務整理（DB接続処理の関数化、編集画面と更新処理の分離）
* 編集画面での初期値反映（value / selected / hidden を用いたフォーム制御）
---

### ■ 次回トライしたいこと

* バリデーションの強化
* ソート・フィルタ機能の実装
* 認証付きの管理画面
* DB設計の拡張（外部キー制約など）

---

## ⑦ フリー項目

今回は  
登録・一覧表示だけで終わらせず、
編集（EDIT）・更新（UPDATE）まで含めたCRUD一連の流れを実装しました。

DB接続処理の関数化や、
編集画面と更新処理の分離など、
「処理ごとの責務をどう分けるか」を意識することで、
機能追加や修正に強い構成を目指しています。

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

🔹 **V1.1では、処理ごとの責務分離を意識してファイル構成を再整理し、
編集・更新（UPDATE）機能を含むCRUD一連の操作を実装しました。**

---

## 🎯 テーマ・学習目的

* PHPによるフォーム送信・受信処理
* MySQL（PDO）を用いたデータベース操作
* CRUD（Create / Read / Update / Delete）の基本実装
* 処理ごとの責務分離を意識したファイル設計
* include を用いた共通コンポーネントの分離
* CSSのコンポーネント設計によるUI整理

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

---

## 🔧 設計・構成のポイント

本アプリでは、
**処理ごとの責務分離と可読性**を重視した構成を採用しています。

### 主な設計意図

* DB接続情報は `config/db.php` に集約
* DB接続処理を `db_conn()` として関数化し、`inc/functions.php` に切り出し
* XSS対策用のエスケープ関数を共通関数として管理
* HTMLヘッダーを共通コンポーネントとして include
* CSSはUIの役割ごとに分割（button / form / table など）
* 顧客テーブルと案件テーブルを分離し、
  一覧表示時は **JOIN を用いてデータの関連性をDB側で担保**

表示ロジックは取得済みデータの描画に専念させることで、
保守性と拡張性を意識した設計としています。

---

## 🛠 技術スタック（Tech Stack）

* HTML
* CSS
* PHP
* MySQL

---

## 🗂 ディレクトリ構成

```
assets/
└─ css/
   ├─ buttons.css      // ボタンUI
   ├─ form.css         // フォームUI
   ├─ responsive.css   // レスポンシブ対応
   ├─ scroll.css       // スクロールUI
   ├─ style.css        // 共通スタイル
   └─ table.css        // テーブルUI

config/
├─ .htaccess
└─ db.php              // DB接続情報

inc/
├─ functions.php       // 共通関数（h(), db_conn(), redirect()）
└─ header.html         // 共通ヘッダー

index.php                  // 案件一覧（JOIN / 編集・削除導線）
customers_list.php         // 顧客一覧
customer_create_action.php // 顧客登録処理
deals_list.php             // 案件一覧
deal_edit.php              // 案件編集画面（V1.1）
deal_update_action.php     // 案件更新処理（V1.1）
deal_create_action.php     // 案件登録処理
deal_delete_action.php     // 案件削除処理
```

---

## ▶ 使い方（How to Use）

1. ローカル環境でPHPとMySQLを起動（XAMPP 等）
2. データベースを作成し、テーブルを準備
3. ブラウザで `index.php` にアクセス
4. 顧客・案件データを登録
5. 一覧画面から内容の確認・編集・削除を実行

---

## 📘 学習ポイント（Learning）

* PHPによるフォーム処理の基本
* PDOを用いた安全なDB操作
* CRUD処理における責務分離の考え方
* 編集画面と更新処理を分離した設計
* include を用いたコード再利用
* UIとロジックの整理

---

## 📄 注意事項

* 本プロジェクトは **学習目的** で制作しています
* セキュリティ・バリデーションは最小限の実装です

---

# 🗂 Simple Deal Manager – README

## 📝 Overview

**Simple Deal Manager** is a simple business data management application
that allows users to register and manage **customers** and **deal records**.

The primary goal of this project is to practice
**database operations (CRUD) using PHP and MySQL**,
while keeping the structure minimal, readable, and maintainable.

The application covers the full workflow from form input
to database insertion, list display, editing, and deletion.

🔹 **In version 1.1, the file structure was reorganized with a clear separation of responsibilities,
and edit/update (UPDATE) functionality was added to complete the CRUD cycle.**

---

## 🎯 Learning Objectives

* Handling form submission with PHP
* Database operations using MySQL (PDO)
* Basic implementation of CRUD (Create / Read / Update / Delete)
* Designing PHP files with clear responsibility separation
* Reusing common components with `include`
* Organizing UI using component-based CSS design

---

## 📋 Features

### ▼ Customer Management

* Register customer information
* Display a customer list
* Insert customer data into the database
* Dedicated action file for create processing

### ▼ Deal Management

* Register deal data associated with a customer
* Customer selection using a `<select>` element
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

---

## 🔧 Design & Architecture Notes

This application is structured with a strong focus on
**clear separation of responsibilities and code readability**.

### Key design points:

* Database connection settings are centralized in `config/db.php`
* Database connection logic is encapsulated in a reusable `db_conn()` function
  defined in `inc/functions.php`
* XSS protection helper functions are managed as shared utilities
* The HTML header is implemented as a shared component using `include`
* CSS is split by role (button / form / table / responsive, etc.)
* Customer and deal data are stored in separate tables
* Deal list views retrieve data using **SQL JOINs**, ensuring that
  data relationships are enforced at the database level

By maintaining data relationships in SQL rather than view logic,
the application remains simple, extensible, and resilient to change.

---

## 🛠 Tech Stack

* HTML
* CSS
* PHP
* MySQL

---

## 🗂 Directory Structure

```
assets/
└─ css/
   ├─ buttons.css      // Button UI styles
   ├─ form.css         // Form UI styles
   ├─ responsive.css   // Responsive layout
   ├─ scroll.css       // Scrollbar customization
   ├─ style.css        // Base styles and variables
   └─ table.css        // Table UI styles

config/
├─ .htaccess
└─ db.php              // Database configuration

inc/
├─ functions.php       // Shared helper functions (XSS protection, db_conn)
└─ header.html         // Shared header component

index.php                  // Main entry / deal list (JOIN, edit & delete links)
customers_list.php         // Customer list view
customer_create_action.php // Customer create processing

deals_list.php             // Deal list view
deal_edit.php              // Deal edit screen (v1.1)
deal_create_action.php     // Deal create processing
deal_update_action.php     // Deal update processing (v1.1)
deal_delete_action.php     // Deal delete processing
```

---

## ▶ How to Use

1. Start PHP and MySQL in a local environment (e.g. XAMPP)
2. Create a database and required tables
3. Access `index.php` in your browser
4. Register customers and deals
5. View, edit, update, or delete records from the list screen

---

## 📘 Key Learnings

* Basic form handling with PHP
* Safe database operations using PDO
* Separation of responsibilities in CRUD processing
* Clear distinction between UI files and action files
* Code reuse with `include`
* Structuring UI and logic for long-term maintainability

---

## 📄 Notes

* This project is created **for learning purposes**
* Security measures and validation are intentionally minimal

---