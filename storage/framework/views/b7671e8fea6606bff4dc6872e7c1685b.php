<?php $__env->startSection('title', 'マイページ - 就労支援サービス'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .center-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 1000px;
        margin: 0 auto;
    }
    .main-heading {
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 0.35em;
        text-align: center;
        line-height: 1.22;
    }
    .heading-nepali {
        font-size: 1.05rem;
        color: #3E5387;
        margin-bottom: 2em;
        display: block;
        text-align: center;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    .success-message {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        text-align: center;
        max-width: 800px;
        width: 100%;
    }
    .buttons-row {
        display: flex;
        flex-direction: row;
        gap: 28px;
        justify-content: center;
        flex-wrap: nowrap;
        width: 100%;
        max-width: 800px;
        box-sizing: border-box;
    }
    .action-btn {
        background-color: #1160E6;
        color: #fff;
        font-size: 1.25rem;
        font-weight: 600;
        border: none;
        border-radius: 999px;
        padding: 20px 38px;
        box-shadow: 0 3px 12px rgba(50,90,180,0.04);
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 220px;
        cursor: pointer;
        transition: background 0.16s;
        position: relative;
        text-decoration: none;
    }
    .action-btn:hover {
        background-color: #0346b0;
    }
    .btn-main-text {
        font-size: 1.15em;
    }
    .btn-sub-text {
        font-size: 0.92em;
        color: #e0eaff;
        margin-top: 6px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        font-weight: 400;
    }

    @media (max-width: 700px) {
        .center-content {
            margin: 30px 8px 0 8px;
            padding: 0;
        }
        .main-heading {
            font-size: 1.3rem;
        }
        .buttons-row {
            flex-wrap: wrap;
            width: 100%;
            padding: 0;
        }
    }
    @media (max-width: 550px) {
        .center-content {
            margin: 30px 0 0 0;
            padding: 0 16px;
        }
        .buttons-row {
            flex-direction: column;
            gap: 14px;
            align-items: stretch;
            width: 100%;
            padding: 0;
        }
        .action-btn {
            width: 100%;
            min-width: 0;
            font-size: 1.06rem;
            padding: 16px 20px;
            margin-bottom: 0;
            box-sizing: border-box;
        }
    }
</style>
<div class="center-content">
    <h1 class="main-heading">
        マイページ
        <span class="heading-nepali">मेरो पृष्ठ</span>
    </h1>
    <?php if(session('success')): ?>
        <div class="success-message">
            <?php echo e(session('success')); ?>

            <span class="block text-sm mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">बायोडाटा सफलतापूर्वक बचत गरियो।</span>
        </div>
    <?php endif; ?>
    <div class="buttons-row">
        <a href="<?php echo e(route('resume.create')); ?>" class="action-btn">
            <span class="btn-main-text">履歴書を作成する</span>
            <span class="btn-sub-text">बायोडाटा तयार गर्नुहोस्</span>
        </a>
        <button class="action-btn">
            <span class="btn-main-text">職務経歴書を作成する</span>
            <span class="btn-sub-text">कामको अनुभव तयार गर्नुहोस्</span>
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ni/Desktop/hamro-life-japan.com/resources/views/dashboard.blade.php ENDPATH**/ ?>