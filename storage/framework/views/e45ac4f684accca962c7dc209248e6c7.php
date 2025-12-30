<?php $__env->startSection('title', '履歴書作成 - 就労支援サービス'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .page-content {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
    }
    .page-heading {
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 0.5em;
    }
    .page-heading-nepali {
        font-size: 1.05rem;
        color: #3E5387;
        display: block;
        margin-bottom: 2em;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    .page-text {
        color: #4b5563;
        line-height: 1.8;
        margin-bottom: 3em;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    .page-text-nepali {
        display: block;
        margin-top: 12px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: #6b7280;
        font-size: 0.95rem;
    }
    .buttons-row {
        display: flex;
        flex-direction: row;
        gap: 28px;
        justify-content: center;
        flex-wrap: nowrap;
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
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
        .page-heading {
            font-size: 1.5rem;
        }
        .buttons-row {
            flex-wrap: wrap;
            width: 100%;
            padding: 0;
        }
    }
    @media (max-width: 550px) {
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
<div class="page-content">
    <h1 class="page-heading">
        履歴書作成
        <span class="page-heading-nepali">बायोडाटा तयार गर्नुहोस्</span>
    </h1>
    <div class="page-text">
        就職活動に必要な履歴書と職務経歴書を作成できます。フォームに必要事項を入力するだけで、簡単に作成できます。
        <span class="page-text-nepali">
            रोजगारको लागि आवश्यक बायोडाटा र कामको अनुभव तयार गर्न सकिन्छ। फारममा आवश्यक जानकारी भर्नाले सजिलैसँग तयार गर्न सकिन्छ।
        </span>
    </div>
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


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ni/Desktop/resume-app/resources/views/resume/index.blade.php ENDPATH**/ ?>