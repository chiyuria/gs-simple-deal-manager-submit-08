# README

## ① 課題名

**Simple Deal Manager v1.1 – PHP & MySQL CRUD App**

---

## ② 課題内容（どんな作品か）

顧客情報と案件（Deal）データを登録・管理できる  
**シンプルな業務データ管理アプリ**です。

本課題では、  
**PHPとMySQLを用いたデータベース操作（CRUD）の理解**を主目的とし、  
フォーム入力からDB登録、一覧表示、削除までの一連の流れを  
最小構成で実装しています。

顧客と案件を別テーブルで管理し、  
一覧表示時には JOIN を用いてデータを取得することで、  
データの関連性と変更耐性を意識した設計としています。

---

## ③ アプリのデプロイURL

**アプリURL**  
https://www.logic-craft.jp/bookmark-app/index.php

---

## ④ アプリにログイン情報がある場合

なし

---

## ⑤ こだわった点

### ■ DB接続処理の関数化（db_conn） --v1.1 Update
DB接続処理を `inc/functions.php` の `db_conn()` に関数化し、  
各処理ファイルから共通で呼び出せるようにしました。  
接続情報（定数）は `config/db.php` に集約し、役割分離を意識しています。

### ■ 案件の更新（UPDATE）機能の追加 --v1.1 Update
一覧（index）から編集リンクで `d_edit.php?d_id=...` に遷移し、  
該当データをフォームに初期表示 → `d_update.php` へPOST → UPDATE の流れで更新処理を追加しました。  
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
フォーム入力からDB登録、一覧表示、削除までの一連の流れを  
最小構成で実装しています。

🔹 **V1.1では、案件データの編集・更新（UPDATE）処理を追加し、  
CRUD一連の操作を一通り実装しました。**

---

## 🎯 テーマ・学習目的

* PHPによるフォーム送信・受信処理
* MySQL（PDO）を用いたデータベース操作
* CRUD（Create / Read / Delete）の基本実装  
  🔹 **＋ Update（編集・更新）処理の追加**
* include を用いた共通コンポーネントの分離
* CSSのコンポーネント設計によるUI整理

---

## 📋 機能一覧（Features）

### ▼ 顧客登録機能（Customer）

* 顧客情報の入力・登録
* 必須項目の簡易バリデーション
* DBへのINSERT処理

### ▼ 案件（Deal）登録機能

* 顧客と紐づく案件データの登録
* select要素による顧客選択
* 顧客 × 案件のリレーションを意識した設計

### ▼ 一覧表示機能

* 登録済みデータをテーブル形式で表示
* 複数データを想定したレイアウト
* 横スクロール対応テーブルUI
* 🔹 **編集画面への導線（編集リンク）の追加**

### ▼ 編集・更新機能（V1.1追加）

* 一覧画面から編集対象を選択
* 対象案件データを取得し、フォームに初期値として表示
* hidden要素でIDを保持し、更新処理を実行
* UPDATE専用PHPファイルによる責務分離

### ▼ 削除機能

* 登録データの削除処理
* チェックボックスによる複数選択削除
* 削除処理専用PHPファイルによる責務分離

---

## 🔧 設計・構成のポイント

本アプリでは、  
**処理ごとの責務分離と可読性**を意識した構成を採用しています。

### 主な設計意図

* DB接続情報は `config/db.php` に集約
* 🔹 **DB接続処理を `db_conn()` として関数化し、  
  `inc/functions.php` に切り出し**
* XSS対策用関数を `functions.php` に切り出し
* ヘッダー部分は共通コンポーネントとして include
* CSSは役割単位で分割（button / form / table など）
* 顧客テーブルと案件テーブルを分離し、  
  一覧表示時に **JOIN を用いてデータを取得**することで、  
  片方のデータ構造や内容が変更された場合でも  
  **他方のデータを破壊しない設計**を意識しています

データの関連性をDB設計とSQLで担保することで、  
表示ロジック側をシンプルに保ち、  
拡張や変更に耐えられる構成を目指しました。

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
├─ buttons.css
├─ form.css
├─ responsive.css
├─ scroll.css
├─ style.css
└─ table.css

config/
├─ .htaccess
└─ db.php

inc/
├─ functions.php // 共通関数（h(), db_conn()）
└─ header.html // 共通ヘッダー

index.php // 案件一覧（JOIN / 編集導線 / 削除チェック）
c_register.php // 顧客登録
c_manage.php // 顧客管理
d_register.php // 案件登録
d_edit.php // 案件編集（V1.1）
d_update.php // 案件更新（V1.1）
d_delete.php // 案件削除

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
* CRUD処理の役割分離  
  🔹 **編集画面と更新処理の分離設計**
* include によるコード再利用
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

The main purpose of this project is to practice  
**database operations (CRUD) using PHP and MySQL**.  
It implements the flow from form input to database insertion,  
list display, deletion, and editing using a minimal and clear structure.

🔹 **In version 1.1, edit and update (UPDATE) functionality was added,  
completing the basic CRUD cycle.**

---

## 🎯 Learning Objectives

- Handling form submission with PHP
- Database operations using MySQL (PDO)
- Basic implementation of CRUD  
  🔹 **including Update (edit & update processing)**
- Separating common components using `include`
- Organizing UI with component-based CSS design

---

## 📋 Features

### ▼ Customer Registration

- Register customer information
- Simple validation for required fields
- Insert data into the database

### ▼ Deal Registration

- Register deal data associated with a customer
- Customer selection using a `<select>` element
- Designed with customer–deal relationships in mind

### ▼ List View

- Display registered data in a table format
- Layout designed for multiple records
- Horizontally scrollable table UI
- 🔹 **Edit links added for each record**

### ▼ Edit & Update Function (Added in v1.1)

- Select a target record from the list view
- Fetch the selected deal data and prefill the edit form
- Preserve the record ID using a hidden field
- Execute UPDATE processing via a dedicated PHP file
- Clear separation between edit and update responsibilities

### ▼ Delete Function

- Delete registered records
- Support for selecting multiple records using checkboxes
- Dedicated PHP file for delete processing to separate responsibilities

---

## 🔧 Design & Architecture Notes

This application is structured with a focus on  
**clear separation of responsibilities and readability**.

### Key design points:

- Database connection settings are centralized in `config/db.php`
- 🔹 **Database connection logic is encapsulated in a reusable `db_conn()` function  
  defined in `inc/functions.php`**
- XSS protection helper functions are separated into `functions.php`
- The header is implemented as a shared component using `include`
- CSS is split by role (button / form / table, etc.)
- Customer and deal data are stored in separate tables,  
  and retrieved using **SQL JOINs** for the list view.  
  This design ensures that changes to one dataset  
  do not unintentionally affect the other.

By maintaining data relationships at the database and SQL level,  
the display logic remains simple and the application is designed  
to be resilient to future changes and extensions.

---

## 🛠 Tech Stack

- HTML
- CSS
- PHP
- MySQL

---

## 🗂 Directory Structure

```

assets/
└─ css/
├─ style.css // Base styles and variables
├─ form.css // Form UI styles
├─ buttons.css // Button components
├─ table.css // Table UI styles
└─ scroll.css // Scrollbar customization

config/
└─ db.php // Database configuration

inc/
├─ header.html // Shared header
└─ functions.php // Common helper functions (XSS protection, db_conn)

index.php // Deal list view (JOIN / edit links / delete checkboxes)
c_register.php // Customer registration
c_manage.php // Customer management
d_register.php // Deal registration
d_edit.php // Deal edit screen (v1.1)
d_update.php // Deal update processing (v1.1)
d_delete.php // Deal deletion

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

- Basic form handling with PHP
- Safe database operations using PDO
- Clear separation of responsibilities in CRUD processing  
  🔹 **including edit and update workflows**
- Code reuse with `include`
- Structuring UI and logic for maintainability

---

## 📄 Notes

- This project is created **for learning purposes**
- Security measures and validation are implemented at a minimal level

---