<?php $__env->startSection('title', '銀行口座 - 就労支援サービス'); ?>

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
        銀行口座開設
        <span class="page-heading-nepali">बैंक खाता खोल्ने</span>
    </h1>
    <div class="page-text">
        銀行口座開設のサポートページです。準備中です。
        <span class="page-text-nepali">
            बैंक खाता खोल्ने सहायता पृष्ठ। यो पृष्ठ तयारीमा छ।
        </span>
    </div>
</div>

<?php
$rankings = [
    [
        'name' => '三菱UFJ銀行',
        'description' => '三菱UFJ銀行は日本最大の銀行グループです。全国に多くのATMがあり、24時間利用可能なサービスが充実しています。外国人向けのサポートも手厚く、口座開設がスムーズです。',
        'description_nepali' => '三菱UFJ銀行 जापानको सबैभन्दा ठूलो बैंक समूह हो। देशभरि धेरै ATM छन्, 24 घण्टा प्रयोग गर्न सकिने सेवाहरू सम्पूर्ण छन्। विदेशीहरूको लागि सहायता पनि राम्रो छ, खाता खोल्ने सजिलो छ।',
        'image' => 'https://via.placeholder.com/300x200/1160E6/FFFFFF?text=三菱UFJ銀行'
    ],
    [
        'name' => 'みずほ銀行',
        'description' => 'みずほ銀行は全国に支店網を持つ大手銀行です。オンラインサービスが充実しており、スマートフォンアプリで簡単に口座管理ができます。',
        'description_nepali' => 'みずほ銀行 देशभरि शाखा नेटवर्क भएको ठूलो बैंक हो। अनलाइन सेवाहरू सम्पूर्ण छन्, स्मार्टफोन एपले सजिलैसँग खाता व्यवस्थापन गर्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/0346b0/FFFFFF?text=みずほ銀行'
    ],
    [
        'name' => '三井住友銀行',
        'description' => '三井住友銀行は使いやすいサービスと充実したサポートで人気があります。外国人向けの多言語対応もあり、初めての銀行口座開設にも安心です。',
        'description_nepali' => '三井住友銀行 प्रयोग गर्न सजिलो सेवा र सम्पूर्ण सहायताले लोकप्रिय छ। विदेशीहरूको लागि बहुभाषिक समर्थन पनि छ, पहिलो पटक बैंक खाता खोल्नेमा पनि निश्चिन्त छ।',
        'image' => 'https://via.placeholder.com/300x200/3E5387/FFFFFF?text=三井住友銀行'
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


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\diggy\Desktop\hamro-life-japan.com\resources\views/pages/bank.blade.php ENDPATH**/ ?>