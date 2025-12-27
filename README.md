# README

## ① 課題名

**Simple Deal Manager – PHP & MySQL CRUD App**

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

* PHPでのフォームデータの受け取りとバリデーション
* PDOを用いたSQL実装
* テーブルを分けた上での JOIN によるデータ取得
* CRUD処理の責務整理

---

### ■ 次回トライしたいこと

* 更新処理（UPDATE）の追加
* バリデーションの強化
* ソート・フィルタ機能の実装
* 認証付きの管理画面
* DB設計の拡張（外部キー制約など）

---

## ⑦ フリー項目

今回は  
**PHPとデータベース処理の基礎を確実に理解すること**を最優先にし、  
あえて機能を盛りすぎず、  
CRUDの基本的な流れを中心に実装しました。

単にデータを表示するだけでなく、  
「データ同士の関係性をどう保つか」  
「一部の変更が他に影響しない構成とは何か」  
といった点を意識しながら設計しています。

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

---

## 🎯 テーマ・学習目的

* PHPによるフォーム送信・受信処理
* MySQL（PDO）を用いたデータベース操作
* CRUD（Create / Read / Delete）の基本実装
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

### ▼ 削除機能

* 登録データの削除処理
* 削除処理専用PHPファイルによる責務分離

---

## 🔧 設計・構成のポイント

本アプリでは、  
**処理ごとの責務分離と可読性**を意識した構成を採用しています。

### 主な設計意図

* DB接続処理は `config/db.php` に集約
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
├─ style.css        // 共通スタイル・変数定義
├─ form.css         // フォームUI
├─ buttons.css      // ボタンコンポーネント
├─ table.css        // テーブルUI
└─ scroll.css       // スクロール調整

config/
└─ db.php              // DB接続設定

inc/
├─ header.html         // 共通ヘッダー
└─ functions.php      // 共通関数（XSS対策）

index.php              // 一覧表示
c_register.php         // 顧客登録
c_manage.php           // 顧客管理
d_register.php         // 案件登録
d_delete.php           // データ削除

```

---

## ▶ 使い方（How to Use）

1. ローカル環境でPHPとMySQLを起動（XAMPP 等）
2. データベースを作成し、テーブルを準備
3. ブラウザで `index.php` にアクセス
4. 顧客・案件データを登録
5. 一覧画面で内容を確認・削除

---

## 📘 学習ポイント（Learning）

* PHPによるフォーム処理の基本
* PDOを用いた安全なDB操作
* CRUD処理の役割分離
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
It implements the full flow from form input to database insertion,  
list display, and deletion using a minimal and clear structure.

---

## 🎯 Learning Objectives

- Handling form submission with PHP
- Database operations using MySQL (PDO)
- Basic implementation of CRUD (Create / Read / Delete)
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

### ▼ Delete Function

- Delete registered records
- Dedicated PHP file for delete processing to separate responsibilities

---

## 🔧 Design & Architecture Notes

This application is structured with a focus on  
**clear separation of responsibilities and readability**.

### Key design points:

- Database connection logic is centralized in `config/db.php`
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
├─ style.css        // Base styles and variables
├─ form.css         // Form UI styles
├─ buttons.css      // Button components
├─ table.css        // Table UI styles
└─ scroll.css       // Scrollbar customization

config/
└─ db.php              // Database connection

inc/
├─ header.html         // Shared header
└─ functions.php      // Common helper functions (XSS protection)

index.php              // List view
c_register.php         // Customer registration
c_manage.php           // Customer management
d_register.php         // Deal registration
d_delete.php           // Data deletion

```

---

## ▶ How to Use

1. Start PHP and MySQL in a local environment (e.g. XAMPP)
2. Create a database and required tables
3. Access `index.php` in your browser
4. Register customers and deals
5. View and delete records from the list screen

---

## 📘 Key Learnings

- Basic form handling with PHP
- Safe database operations using PDO
- Responsibility separation in CRUD processing
- Code reuse with `include`
- Structuring UI and logic for maintainability

---

## 📄 Notes

- This project is created **for learning purposes**
- Security measures and validation are implemented at a minimal level

---
