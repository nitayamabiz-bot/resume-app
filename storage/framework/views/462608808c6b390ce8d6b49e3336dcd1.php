<?php $__env->startSection('title', '広告募集 - 就労支援サービス'); ?>

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
        margin: 0 auto 2em;
    }
    .page-text-nepali {
        display: block;
        margin-top: 12px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: #6b7280;
        font-size: 0.95rem;
    }
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        text-align: left;
    }
    .form-group {
        margin-bottom: 24px;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #222;
        font-size: 0.95rem;
    }
    .form-label-nepali {
        display: block;
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 4px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }
    .form-input:focus {
        outline: none;
        border-color: #1160E6;
        box-shadow: 0 0 0 3px rgba(17, 96, 230, 0.1);
    }
    .required {
        color: #ef4444;
        margin-left: 4px;
    }
    .submit-btn {
        width: 100%;
        background-color: #1160E6;
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        padding: 14px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s;
        margin-top: 8px;
    }
    .submit-btn:hover {
        background-color: #0346b0;
    }
    .success-message {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        text-align: center;
    }
    .error-message {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        text-align: center;
    }
    @media (max-width: 700px) {
        .page-heading {
            font-size: 1.5rem;
        }
        .form-container {
            padding: 24px 16px;
        }
    }
</style>
<div class="page-content">
    <h1 class="page-heading">
        広告募集
        <span class="page-heading-nepali">विज्ञापन आवेदन</span>
    </h1>
    <div class="page-text">
        当サイトへの広告掲載をご希望の方は、以下のフォームにご記入ください。
        <span class="page-text-nepali">
            यस साइटमा विज्ञापन प्रकाशन चाहनुहुन्छ भने, तलको फारम भर्नुहोस्।
        </span>
    </div>

    <div class="form-container">
        <?php if(session('success')): ?>
            <div class="success-message">
                <?php echo e(session('success')); ?>

                <span class="block text-sm mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">विज्ञापन आवेदन स्वीकार गरियो। धन्यवाद।</span>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="error-message">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('advertisement.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label class="form-label">
                    サービス名<span class="required">*</span>
                    <span class="form-label-nepali">सेवा नाम</span>
                </label>
                <input type="text" name="service_name" class="form-input" value="<?php echo e(old('service_name')); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    代表者名<span class="required">*</span>
                    <span class="form-label-nepali">प्रतिनिधि नाम</span>
                </label>
                <input type="text" name="representative_name" class="form-input" value="<?php echo e(old('representative_name')); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    電話番号<span class="required">*</span>
                    <span class="form-label-nepali">फोन नम्बर</span>
                </label>
                <input type="tel" name="phone" class="form-input" value="<?php echo e(old('phone')); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    メールアドレス<span class="required">*</span>
                    <span class="form-label-nepali">इमेल ठेगाना</span>
                </label>
                <input type="email" name="email" class="form-input" value="<?php echo e(old('email')); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    サイトURL<span class="required">*</span>
                    <span class="form-label-nepali">साइट URL</span>
                </label>
                <input type="url" name="site_url" class="form-input" value="<?php echo e(old('site_url')); ?>" placeholder="https://example.com" required>
            </div>

            <button type="submit" class="submit-btn">
                送信する
                <span class="block text-sm mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif; opacity: 0.9;">पठाउनुहोस्</span>
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ni/Desktop/hamro-life-japan.com/resources/views/advertisement/create.blade.php ENDPATH**/ ?>