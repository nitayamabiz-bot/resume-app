<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['rankings']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['rankings']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<style>
    .ranking-section {
        max-width: 1000px;
        margin: 3em auto 0;
        padding: 0 20px;
    }
    .ranking-title {
        font-size: 1.8rem;
        font-weight: 600;
        text-align: center;
        margin-bottom: 2em;
        color: #222;
    }
    .ranking-title-nepali {
        display: block;
        font-size: 1rem;
        color: #3E5387;
        margin-top: 8px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    .ranking-item {
        margin-bottom: 2.5em;
        background-color: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    .ranking-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .rank-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1160E6;
        margin-right: 16px;
        min-width: 50px;
    }
    .rank-1 {
        color: #FFD700;
    }
    .rank-2 {
        color: #C0C0C0;
    }
    .rank-3 {
        color: #CD7F32;
    }
    .crown-container {
        position: relative;
        display: flex;
        align-items: center;
        margin-right: 16px;
        gap: 16px;
    }
    .crown-icon {
        font-size: 2.5rem;
        color: #FFD700;
        filter: drop-shadow(0 2px 4px rgba(255, 215, 0, 0.3));
        flex-shrink: 0;
    }
    .ribbon {
        position: relative;
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        color: #fff;
        padding: 8px 24px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: 0 2px 6px rgba(255, 215, 0, 0.3);
        white-space: nowrap;
    }
    .ribbon::before {
        content: '';
        position: absolute;
        left: -10px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 10px 10px 10px 0;
        border-color: transparent #FFA500 transparent transparent;
    }
    .ribbon::after {
        content: '';
        position: absolute;
        right: -10px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent #FFA500;
    }
    .site-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #222;
        margin-left: 16px;
    }
    .ranking-content {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }
    .ranking-image {
        flex: 0 0 300px;
        width: 300px;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .ranking-ad-container {
        flex: 0 0 300px;
        width: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .ranking-ad-container a {
        display: inline-block;
    }
    .ranking-ad-container img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        display: block;
    }
    .ranking-article {
        flex: 1;
        color: #4b5563;
        line-height: 1.7;
    }
    .ranking-article-short {
        display: inline;
    }
    .ranking-article-full {
        display: none;
    }
    .ranking-article-full.expanded {
        display: inline;
    }
    .read-more-link {
        color: #1160E6;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.9rem;
        margin-left: 4px;
        display: inline-block;
        border-bottom: 1px solid #1160E6;
        transition: opacity 0.2s;
    }
    .read-more-link:hover {
        opacity: 0.7;
    }
    .ranking-article-nepali {
        display: block;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: #4b5563;
        font-size: 0.95rem;
        line-height: 1.7;
    }
    .ranking-article-nepali-short {
        display: block;
        line-height: 1.4;
        margin: 0;
        padding: 0;
    }
    .ranking-article-nepali-short br {
        display: block;
        margin: 0;
        padding: 0;
        line-height: 1.4;
        height: 0;
    }
    .ranking-article-nepali-full {
        display: none;
        margin-top: 0;
        padding-top: 0;
        line-height: 1.7;
    }
    .ranking-article-nepali-full br {
        display: block;
        margin: 0;
        padding: 0;
        line-height: 1.7;
    }
    .ranking-article-nepali-full.expanded {
        display: block;
    }
    @media (max-width: 768px) {
        .ranking-content {
            flex-direction: column;
        }
        .ranking-image,
        .ranking-ad-container {
            width: 100%;
            flex: none;
        }
        .ranking-header {
            flex-wrap: wrap;
        }
        .crown-container {
            margin-bottom: 12px;
        }
        .ribbon {
            font-size: 0.95rem;
            padding: 6px 16px;
        }
    }
</style>

<div class="ranking-section">
    <h2 class="ranking-title">
        おすすめサイトランキング
        <span class="ranking-title-nepali">सिफारिस गरिएको साइटहरू</span>
    </h2>

    <?php $__currentLoopData = $rankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ranking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="ranking-item">
            <div class="ranking-header">
                <?php if($index === 0): ?>
                    <div class="crown-container">
                        <span class="crown-icon">👑</span>
                        <div class="ribbon"><?php echo e($ranking['name']); ?></div>
                    </div>
                <?php else: ?>
                    <span class="rank-number rank-<?php echo e($index + 1); ?>"><?php echo e($index + 1); ?>位</span>
                    <span class="site-name"><?php echo e($ranking['name']); ?></span>
                <?php endif; ?>
            </div>
            <div class="ranking-content">
                <?php if(isset($ranking['ad_code'])): ?>
                    <div class="ranking-ad-container">
                        <?php echo $ranking['ad_code']; ?>

                    </div>
                <?php else: ?>
                    <img src="<?php echo e($ranking['image']); ?>" alt="<?php echo e($ranking['name']); ?>" class="ranking-image">
                <?php endif; ?>
                <div class="ranking-article">
                    <div class="ranking-article-nepali">
                        <?php if(isset($ranking['description_nepali_short'])): ?>
                            <span class="ranking-article-nepali-short" id="desc-nepali-short-<?php echo e($index); ?>">
                                <?php echo nl2br(e($ranking['description_nepali_short'])); ?>

                            </span>
                            <a class="read-more-link" onclick="toggleDescription(<?php echo e($index); ?>)" id="read-more-<?php echo e($index); ?>">
                                続きを読む
                            </a>
                            <span class="ranking-article-nepali-full" id="desc-nepali-full-<?php echo e($index); ?>">
                                <?php echo nl2br(e($ranking['description_nepali'])); ?>

                            </span>
                        <?php else: ?>
                            <?php echo e($ranking['description_nepali'] ?? ''); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<script>
function toggleDescription(index) {
    const fullNepali = document.getElementById('desc-nepali-full-' + index);
    const readMoreLink = document.getElementById('read-more-' + index);
    
    if (fullNepali.classList.contains('expanded')) {
        fullNepali.classList.remove('expanded');
        readMoreLink.textContent = '続きを読む';
    } else {
        fullNepali.classList.add('expanded');
        readMoreLink.textContent = '閉じる';
    }
}
</script>

<?php /**PATH /Users/ni/Desktop/resume-app/resources/views/components/ranking-section.blade.php ENDPATH**/ ?>