<?php $__env->startSection('title', '履歴書作成 - 就労支援サービス'); ?>

<?php $__env->startPush('head'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* 履歴書ページ専用スタイル - ヘッダーには影響しない */
    .main-content .resume-tabs-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0;
        margin-bottom: 30px;
    }
    
    /* 入力画面のコンテンツのみ1000pxに制限 */
    .main-content .resume-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .main-content .tabs {
        display: flex;
        border-bottom: 2px solid #e5e7eb;
        gap: 0;
    }
    .main-content .tab {
        padding: 12px 24px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        color: #6b7280;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .main-content .tab:hover {
        color: #1160E6;
        background-color: #f3f4f6;
    }
    .main-content .tab.active {
        color: #1160E6;
        border-bottom-color: #1160E6;
        background-color: #fff;
    }
    .main-content .tab-content {
        display: none;
    }
    .main-content .tab-content.active {
        display: block;
    }
    @media (max-width: 768px) {
        .main-content .tabs {
            flex-wrap: wrap;
        }
        .main-content .tab {
            padding: 10px 16px;
            font-size: 0.9rem;
        }
    }
</style>

<!-- タブ部分 -->
<div class="resume-tabs-container">
    <div class="tabs">
        <button class="tab active" onclick="switchTab('form')" id="tab-form">
            履歴書作成 / बायोडाटा तयार गर्नुहोस्
        </button>
        <button class="tab" onclick="switchTab('confirm')" id="tab-confirm" style="display: none;">
            内容確認 / विवरण जाँच गर्नुहोस्
        </button>
    </div>
</div>

<!-- コンテンツ部分（入力エリアは1000pxに制限） -->
<div class="resume-container">
    <div id="content-form" class="tab-content active">
        <?php echo $__env->make('resume._create_form', ['resumeData' => $resumeData ?? null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    
    <div id="content-confirm" class="tab-content">
        <?php echo $__env->make('resume.confirm', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<script>
    function switchTab(tabName) {
        // すべてのタブとコンテンツを非アクティブに
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        
        // 選択されたタブとコンテンツをアクティブに
        const tabEl = document.getElementById('tab-' + tabName);
        const contentEl = document.getElementById('content-' + tabName);
        if (tabEl) {
            tabEl.classList.add('active');
            if (tabName === 'confirm') {
                tabEl.style.display = 'block';
            }
        }
        if (contentEl) {
            contentEl.classList.add('active');
        }
    }
    
    // ページロード時に内容確認画面を表示するかチェック
    document.addEventListener('DOMContentLoaded', function() {
        <?php if(isset($showConfirm) && $showConfirm): ?>
            switchTab('confirm');
        <?php endif; ?>
    });
    
    // グローバル関数として定義
    window.showConfirm = showConfirm;
    window.backToForm = backToForm;
    
    // 内容確認画面に遷移する関数
    function showConfirm() {
        switchTab('confirm');
        document.getElementById('tab-confirm').style.display = 'block';
    }
    
    // 戻るボタンで入力画面に戻る
    function backToForm() {
        switchTab('form');
        // フォームデータを復元
        if (typeof restoreFormData === 'function') {
            restoreFormData();
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ni/Desktop/hamro-life-japan.com/resources/views/resume/index.blade.php ENDPATH**/ ?>