<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', '就労支援サービス'); ?></title>
    <style>
        body {
            background-color: #f6f7fa;
            margin: 0;
            padding: 0;
            font-family: 'Noto Sans JP', 'Noto Sans Devanagari', Arial, sans-serif;
            color: #222;
        }
        .header {
            width: 100%;
            background-color: #ffffffe6;
            padding: 24px 0 16px 0;
            box-shadow: 0 2px 8px rgba(180,180,180,0.05);
            position: relative;
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .logo-section {
            text-align: center;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
        }
        .logo-main {
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 0.07em;
        }
        .logo-link {
            text-decoration: none;
            color: inherit;
            display: inline-block;
            transition: opacity 0.2s;
        }
        .logo-link:hover {
            opacity: 0.7;
        }
        .logo-sub {
            display: block;
            font-size: 0.92rem;
            color: #888;
            margin-top: 2px;
        }
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            flex-direction: column;
            gap: 5px;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        .hamburger-btn span {
            display: block;
            width: 24px;
            height: 2px;
            background-color: #1160E6;
            transition: all 0.3s;
        }
        .hamburger-btn.active span:nth-child(1) {
            transform: rotate(45deg) translate(7px, 7px);
        }
        .hamburger-btn.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }
        .nav-menu {
            display: flex;
            justify-content: center;
            gap: 0;
            flex-wrap: wrap;
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
        }
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .mobile-menu.active {
            max-height: 100vh;
            overflow-y: auto;
        }
        .mobile-menu .nav-item {
            display: block;
            width: 100%;
            padding: 12px 20px;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 0;
            min-width: auto;
            text-align: left;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .mobile-menu .nav-item:not(:last-child)::after {
            display: none;
        }
        .mobile-menu .nav-item-main {
            flex: 1;
        }
        .mobile-menu .nav-item-sub {
            margin-left: 12px;
            font-size: 0.75rem;
        }
        .nav-item {
            text-decoration: none;
            color: #4b5563;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s;
            position: relative;
            min-width: 100px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .nav-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 24px;
            background-color: #e5e7eb;
        }
        .nav-item:hover {
            background-color: #f3f4f6;
            color: #1160E6;
        }
        .nav-item.active {
            background-color: #1160E6;
            color: #fff;
            font-weight: 600;
        }
        .nav-item.active:hover {
            background-color: #0346b0;
        }
        .nav-item-main {
            display: block;
        }
        .nav-item-sub {
            display: block;
            font-size: 0.7rem;
            margin-top: 2px;
            opacity: 0.8;
            font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        }
        .nav-links {
            position: absolute;
            top: 24px;
            right: 20px;
            display: flex;
            gap: 12px;
            align-items: center;
            z-index: 100;
        }
        .nav-link {
            color: #1160E6;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s;
            cursor: pointer;
            display: inline-block;
            position: relative;
            pointer-events: auto;
        }
        .nav-link:hover {
            background-color: #f0f4ff;
        }
        a.nav-link {
            text-decoration: none;
            color: #1160E6;
        }
        a.nav-link:hover {
            text-decoration: none;
            color: #1160E6;
        }
        .nav-link-btn {
            background-color: #1160E6;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
        }
        .nav-link-btn:hover {
            background-color: #0346b0;
        }
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 40px 20px 120px 20px;
        }
        .footer {
            width: 100%;
            background-color: #ffffffe6;
            padding: 12px 0;
            box-shadow: 0 -2px 8px rgba(180,180,180,0.05);
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 100;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .ad-slider {
            position: relative;
            width: 100%;
            height: 80px;
            overflow: hidden;
            border-radius: 8px;
            background-color: #f3f4f6;
        }
        .ad-slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }
        .ad-slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ad-slide a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            text-decoration: none;
        }
        .ad-slide img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
        }
        .ad-indicators {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }
        .ad-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .ad-indicator.active {
            background-color: #1160E6;
        }
        @media (max-width: 768px) {
            .main-content {
                padding: 40px 20px 100px 20px;
            }
            .ad-slider {
                height: 70px;
            }
            .ad-indicator {
                width: 6px;
                height: 6px;
            }
            .footer {
                padding: 10px 0;
            }
        }
        @media (max-width: 768px) {
            .nav-links {
                position: static;
                justify-content: center;
                margin-bottom: 16px;
                flex-wrap: wrap;
            }
            .header {
                padding: 16px 0;
            }
            .logo-section {
                justify-content: center;
                padding: 0 20px 0 60px;
                margin-bottom: 0;
                text-align: center;
                position: relative;
            }
            .logo-main {
                font-size: 1.5rem;
            }
            .hamburger-btn {
                display: flex;
            }
            .nav-menu {
                display: none;
            }
            .mobile-menu {
                display: block;
            }
        }
        @media (max-width: 550px) {
            .logo-main {
                font-size: 1.25rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600&family=Noto+Sans+JP:wght@400;600&display=swap" rel="stylesheet">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="nav-links">
                <?php if(auth()->guard()->check()): ?>
                    <span class="nav-link"><?php echo e(Auth::user()->name); ?></span>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="nav-link-btn">ログアウト<span class="block text-xs" style="font-size: 0.7rem; opacity: 0.9;">लगआउट</span></button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="nav-link" style="display: inline-block; text-decoration: none; cursor: pointer; pointer-events: auto;">ログイン<span class="block text-xs" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">लगइन</span></a>
                    <a href="<?php echo e(route('register')); ?>" class="nav-link-btn" style="display: inline-block; text-decoration: none; cursor: pointer; pointer-events: auto;">新規登録<span class="block text-xs" style="font-size: 0.7rem; opacity: 0.9;">दर्ता</span></a>
                <?php endif; ?>
            </div>
            <div class="logo-section">
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="メニュー">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <a href="<?php echo e(route('home')); ?>" class="logo-link">
                    <span class="logo-main">就労支援サービス
                        <span class="logo-sub">रोजगार सहायता सेवा</span>
                    </span>
                </a>
            </div>
            <nav class="nav-menu" id="desktopMenu">
                <a href="<?php echo e(route('home')); ?>" class="nav-item <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                    <span class="nav-item-main">トップページ</span>
                    <span class="nav-item-sub">मुख्य पृष्ठ</span>
                </a>
                <a href="<?php echo e(route('rental')); ?>" class="nav-item <?php echo e(request()->routeIs('rental') ? 'active' : ''); ?>">
                    <span class="nav-item-main">賃貸</span>
                    <span class="nav-item-sub">भाडा</span>
                </a>
                <a href="<?php echo e(route('parttime')); ?>" class="nav-item <?php echo e(request()->routeIs('parttime') ? 'active' : ''); ?>">
                    <span class="nav-item-main">アルバイト</span>
                    <span class="nav-item-sub">अंशकालिक</span>
                </a>
                <a href="<?php echo e(route('job')); ?>" class="nav-item <?php echo e(request()->routeIs('job') ? 'active' : ''); ?>">
                    <span class="nav-item-main">就職</span>
                    <span class="nav-item-sub">रोजगार</span>
                </a>
                <a href="<?php echo e(route('bank')); ?>" class="nav-item <?php echo e(request()->routeIs('bank') ? 'active' : ''); ?>">
                    <span class="nav-item-main">銀行口座</span>
                    <span class="nav-item-sub">बैंक खाता</span>
                </a>
                <a href="<?php echo e(route('internet')); ?>" class="nav-item <?php echo e(request()->routeIs('internet') ? 'active' : ''); ?>">
                    <span class="nav-item-main">ネット回線</span>
                    <span class="nav-item-sub">इन्टरनेट</span>
                </a>
                <a href="<?php echo e(route('sim')); ?>" class="nav-item <?php echo e(request()->routeIs('sim') ? 'active' : ''); ?>">
                    <span class="nav-item-main">SIM</span>
                    <span class="nav-item-sub">सिम</span>
                </a>
                <a href="<?php echo e(route('resume.index')); ?>" class="nav-item <?php echo e(request()->routeIs('resume.*') ? 'active' : ''); ?>">
                    <span class="nav-item-main">履歴書作成</span>
                    <span class="nav-item-sub">बायोडाटा</span>
                </a>
                <a href="<?php echo e(route('career.index')); ?>" class="nav-item <?php echo e(request()->routeIs('career.*') ? 'active' : ''); ?>">
                    <span class="nav-item-main">職務経歴書作成</span>
                    <span class="nav-item-sub">कामको अनुभव</span>
                </a>
            </nav>
            <nav class="mobile-menu" id="mobileMenu">
                <a href="<?php echo e(route('home')); ?>" class="nav-item <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                    <span class="nav-item-main">トップページ</span>
                    <span class="nav-item-sub">मुख्य पृष्ठ</span>
                </a>
                <a href="<?php echo e(route('rental')); ?>" class="nav-item <?php echo e(request()->routeIs('rental') ? 'active' : ''); ?>">
                    <span class="nav-item-main">賃貸</span>
                    <span class="nav-item-sub">भाडा</span>
                </a>
                <a href="<?php echo e(route('parttime')); ?>" class="nav-item <?php echo e(request()->routeIs('parttime') ? 'active' : ''); ?>">
                    <span class="nav-item-main">アルバイト</span>
                    <span class="nav-item-sub">अंशकालिक</span>
                </a>
                <a href="<?php echo e(route('job')); ?>" class="nav-item <?php echo e(request()->routeIs('job') ? 'active' : ''); ?>">
                    <span class="nav-item-main">就職</span>
                    <span class="nav-item-sub">रोजगार</span>
                </a>
                <a href="<?php echo e(route('bank')); ?>" class="nav-item <?php echo e(request()->routeIs('bank') ? 'active' : ''); ?>">
                    <span class="nav-item-main">銀行口座</span>
                    <span class="nav-item-sub">बैंक खाता</span>
                </a>
                <a href="<?php echo e(route('internet')); ?>" class="nav-item <?php echo e(request()->routeIs('internet') ? 'active' : ''); ?>">
                    <span class="nav-item-main">ネット回線</span>
                    <span class="nav-item-sub">इन्टरनेट</span>
                </a>
                <a href="<?php echo e(route('sim')); ?>" class="nav-item <?php echo e(request()->routeIs('sim') ? 'active' : ''); ?>">
                    <span class="nav-item-main">SIM</span>
                    <span class="nav-item-sub">सिम</span>
                </a>
                <a href="<?php echo e(route('resume.index')); ?>" class="nav-item <?php echo e(request()->routeIs('resume.*') ? 'active' : ''); ?>">
                    <span class="nav-item-main">履歴書作成</span>
                    <span class="nav-item-sub">बायोडाटा</span>
                </a>
                <a href="<?php echo e(route('career.index')); ?>" class="nav-item <?php echo e(request()->routeIs('career.*') ? 'active' : ''); ?>">
                    <span class="nav-item-main">職務経歴書作成</span>
                    <span class="nav-item-sub">कामको अनुभव</span>
                </a>
            </nav>
        </div>
    </header>
    <main class="main-content">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <footer class="footer">
        <div class="footer-content">
            <div class="ad-slider">
                <div class="ad-slides" id="adSlides">
                    <div class="ad-slide">
                        <a href="<?php echo e(route('advertisement.create')); ?>">
                            <img src="<?php echo e(asset('images/ads/ad1.jpg')); ?>" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/1160E6/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    <?php if(file_exists(public_path('images/ads/ad2.jpg'))): ?>
                    <div class="ad-slide">
                        <a href="<?php echo e(route('advertisement.create')); ?>">
                            <img src="<?php echo e(asset('images/ads/ad2.jpg')); ?>" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/0346b0/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if(file_exists(public_path('images/ads/ad3.jpg'))): ?>
                    <div class="ad-slide">
                        <a href="<?php echo e(route('advertisement.create')); ?>">
                            <img src="<?php echo e(asset('images/ads/ad3.jpg')); ?>" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/3E5387/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if(file_exists(public_path('images/ads/ad4.jpg'))): ?>
                    <div class="ad-slide">
                        <a href="<?php echo e(route('advertisement.create')); ?>">
                            <img src="<?php echo e(asset('images/ads/ad4.jpg')); ?>" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/6b7280/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="ad-indicators" id="adIndicators">
                    <span class="ad-indicator active" data-slide="0"></span>
                    <?php if(file_exists(public_path('images/ads/ad2.jpg'))): ?>
                    <span class="ad-indicator" data-slide="1"></span>
                    <?php endif; ?>
                    <?php if(file_exists(public_path('images/ads/ad3.jpg'))): ?>
                    <span class="ad-indicator" data-slide="2"></span>
                    <?php endif; ?>
                    <?php if(file_exists(public_path('images/ads/ad4.jpg'))): ?>
                    <span class="ad-indicator" data-slide="3"></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (hamburgerBtn && mobileMenu) {
                hamburgerBtn.addEventListener('click', function() {
                    hamburgerBtn.classList.toggle('active');
                    mobileMenu.classList.toggle('active');
                });
                
                // メニュー項目をクリックしたらメニューを閉じる
                const menuItems = mobileMenu.querySelectorAll('.nav-item');
                menuItems.forEach(item => {
                    item.addEventListener('click', function() {
                        hamburgerBtn.classList.remove('active');
                        mobileMenu.classList.remove('active');
                    });
                });
            }

            // 広告スライドショー
            const adSlides = document.getElementById('adSlides');
            const adIndicators = document.getElementById('adIndicators');
            const indicators = adIndicators.querySelectorAll('.ad-indicator');
            let currentSlide = 0;
            const totalSlides = indicators.length;
            const slideInterval = 4000; // 4秒ごとにスライド

            function showSlide(index) {
                adSlides.style.transform = `translateX(-${index * 100}%)`;
                
                // インジケーターを更新
                indicators.forEach((indicator, i) => {
                    if (i === index) {
                        indicator.classList.add('active');
                    } else {
                        indicator.classList.remove('active');
                    }
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                showSlide(currentSlide);
            }

            // インジケーターをクリックしたらそのスライドに移動
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    currentSlide = index;
                    showSlide(currentSlide);
                });
            });

            // 自動スライド
            setInterval(nextSlide, slideInterval);
        });
    </script>
</body>
</html>

<?php /**PATH /Users/ni/Desktop/hamro-life-japan.com/resources/views/layouts/main.blade.php ENDPATH**/ ?>