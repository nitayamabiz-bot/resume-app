<?php $__env->startSection('title', 'アルバイト - 就労支援サービス'); ?>

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
        max-width: 800px;
        margin: 0 auto;
    }
    .page-text-nepali {
        display: block;
        margin-top: 12px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: #6b7280;
        font-size: 0.95rem;
    }
    @media (max-width: 700px) {
        .page-heading {
            font-size: 1.5rem;
        }
    }
</style>
<div class="page-content">
    <h1 class="page-heading">
        アルバイト情報
        <span class="page-heading-nepali">अंशकालिक जानकारी</span>
    </h1>
    <div class="page-text">
        アルバイト情報の検索ページです。準備中です。
        <span class="page-text-nepali">
            अंशकालिक जानकारी खोज्ने पृष्ठ। यो पृष्ठ तयारीमा छ।
        </span>
    </div>
</div>

<?php
$rankings = [
    [
        'name' => 'バイトル',
        'description' => 'バイトルは日本最大級のアルバイト・パート求人情報サイトです。豊富な求人情報と簡単な応募システムで、あなたにぴったりの仕事を見つけることができます。',
        'description_nepali' => 'バイトル जापानको सबैभन्दा ठूलो अंशकालिक र अंशकालिक रोजगार जानकारी साइट हो। धेरै संख्यामा रहेको रोजगार जानकारी र सजिलो आवेदन प्रणालीले तपाईंको लागि उपयुक्त काम फेला पार्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/1160E6/FFFFFF?text=バイトル'
    ],
    [
        'name' => 'タウンワーク',
        'description' => 'タウンワークは地域密着型のアルバイト情報サイトです。駅近や自宅近くの求人を簡単に検索でき、働きやすい環境を見つけることができます。',
        'description_nepali' => 'タウンワーク क्षेत्र-केन्द्रित अंशकालिक जानकारी साइट हो। स्टेशन नजिकै वा घर नजिकैको रोजगार सजिलैसँग खोज्न सकिन्छ, काम गर्न सजिलो वातावरण फेला पार्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/0346b0/FFFFFF?text=タウンワーク'
    ],
    [
        'name' => 'マイナビバイト',
        'description' => 'マイナビバイトは学生や主婦にも人気のアルバイト情報サイトです。柔軟な勤務時間や条件で、ライフスタイルに合わせた仕事を探すことができます。',
        'description_nepali' => 'マイナビバイト विद्यार्थी र गृहिणीहरूमा पनि लोकप्रिय अंशकालिक जानकारी साइट हो। लचिलो कामको समय र अवस्थाहरूले, जीवनशैली अनुसारको काम खोज्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/3E5387/FFFFFF?text=マイナビバイト'
    ]
];
?>

<?php if (isset($component)) { $__componentOriginal669018af70097d0b47b511adda67e330 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal669018af70097d0b47b511adda67e330 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ranking-section','data' => ['rankings' => $rankings]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ranking-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rankings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rankings)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal669018af70097d0b47b511adda67e330)): ?>
<?php $attributes = $__attributesOriginal669018af70097d0b47b511adda67e330; ?>
<?php unset($__attributesOriginal669018af70097d0b47b511adda67e330); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal669018af70097d0b47b511adda67e330)): ?>
<?php $component = $__componentOriginal669018af70097d0b47b511adda67e330; ?>
<?php unset($__componentOriginal669018af70097d0b47b511adda67e330); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ni/Desktop/hamro-life-japan.com/resources/views/pages/parttime.blade.php ENDPATH**/ ?>