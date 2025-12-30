# PDFテンプレート配置

このディレクトリに、JIS規格履歴書のPDFテンプレート（`01_A4_format.pdf`）を配置してください。

## ファイル配置

1. `01_A4_format.pdf` をこのディレクトリ（`storage/app/templates/`）に配置してください。
2. PDFテンプレートはA4サイズで、JIS規格履歴書のフォーマットである必要があります。
3. **重要**: PDFは非圧縮形式である必要があります。圧縮形式のPDFはFPDIの無料版では処理できません。

## PDFを非圧縮形式に変換する方法

### 方法1: Adobe Acrobatを使用（推奨）
1. Adobe AcrobatでPDFを開く
2. 「ファイル」→「名前を付けて保存」→「最適化されたPDF」
3. 「最適化設定」で「圧縮」のチェックを外す
4. 保存

### 方法2: Ghostscriptを使用（コマンドライン）
```bash
gs -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile=output.pdf input.pdf
```

### 方法3: オンラインツール
- SmallPDF (https://smallpdf.com/compress-pdf) で圧縮を解除
- または、PDFを一度印刷してPDFとして保存し直す

### 方法4: macOSの場合
1. PDFをプレビューで開く
2. 「ファイル」→「書き出す」
3. 「Quartzフィルタ」を「なし」に設定
4. 保存

## 日本語フォントの配置

日本語フォント（IPAexゴシック）を `storage/app/fonts/` ディレクトリに配置してください。

1. IPAexゴシックフォント（`ipaexg.ttf`）をダウンロード
   - 公式サイト: https://ipafont.ipa.go.jp/
2. `storage/app/fonts/ipaexg.ttf` として配置

フォントが配置されていない場合、PDF生成時に日本語が正しく表示されない可能性があります。

