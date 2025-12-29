# PDF生成機能のセットアップガイド（FPDI + TCPDF版）

## 1. Composerの準備

### Composerがインストールされていない場合

プロジェクト直下に `composer.phar` をダウンロードして使用します。

#### Windowsの場合（PowerShell）
```powershell
# プロジェクトディレクトリに移動
cd C:\Users\diggy\Desktop\hamro-life-japan.com

# Composerをダウンロード
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# パッケージをインストール
php composer.phar install

# FPDI-TCPDFパッケージを追加インストール
php composer.phar require setasign/fpdi-tcpdf:^3.0
```

#### Linux/Macの場合
```bash
# プロジェクトディレクトリに移動
cd /path/to/hamro-life-japan.com

# Composerをダウンロード
curl -sS https://getcomposer.org/installer | php

# パッケージをインストール
php composer.phar install

# FPDI-TCPDFパッケージを追加インストール
php composer.phar require setasign/fpdi-tcpdf:^3.0
```

### 必要なパッケージの確認

以下のパッケージがインストールされていることを確認してください：
- `setasign/fpdf`: ^1.8
- `setasign/fpdi`: ^2.6
- `setasign/fpdi-tcpdf`: ^3.0 (新規追加 - FPDIとTCPDFを組み合わせるために必要)
- `tecnickcom/tcpdf`: ^6.10

## 2. 使用方法

### ルート
```
POST /resume/generate-pdf-fpdi
```

### リクエスト
セッションに `resume_data` が保存されている必要があります。

### レスポンス
- `Content-Type: application/pdf`
- ファイル名: `resume.pdf`
- ブラウザに直接ダウンロードされます

## 3. 実装の詳細

### 座標配置（1ページ目：A4縦）
- 日付: (150, 30)
- 氏名（ふりがな）: (40, 40)
- 氏名: (40, 50)
- 生年月日: (40, 60)
- 性別: (120, 60)
- 現住所: (40, 80)
- 電話番号: (160, 100)
- 学歴・職歴: (10, 140) を起点にループ描画

### 座標配置（2ページ目：A4縦）
- 免許・資格: (10, 40) を起点に描画
- 志望動機: (10, 160)
- 本人希望欄: (10, 230)

### 日本語フォント
TCPDF標準の `kozminproregular` を使用します。このフォントはTCPDFに標準で含まれています。

