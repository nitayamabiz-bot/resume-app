<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminProcedureController extends Controller
{
    public function __invoke(Request $request): View
    {
        $categories = [
            [
                'id' => 'visa',
                'title_jp' => 'ビザの維持・更新',
                'title_np' => 'भिसा कायम राख्ने / नवीकरण',
                'description' => "在留カードの更新、在留期間の更新、資格外活動許可など、ビザを維持するために必要な主な手続きです。\nभिसा कायम राख्न र नवीकरण गर्न आवश्यक मुख्य प्रक्रिया यहाँ समेटिएका छन्।",
                'icon' => 'id-card',
                'color' => 'blue',
                'procedures' => [
                    [
                        'name_jp' => '在留期間の更新',
                        'name_np' => 'बसोबास अवधि नवीकरण',
                        'documents' => [
                            ['label_jp' => 'パスポート', 'label_np' => 'पासपोर्ट'],
                            ['label_jp' => '在留カード', 'label_np' => 'रेजिडेन्स कार्ड'],
                            ['label_jp' => '在留期間更新許可申請書', 'label_np' => 'बसोबास अवधि नवीकरणको फारम'],
                        ],
                        'source' => 'immigration',
                        'place_jp' => '在留地を管轄する出入国在留管理局の窓口（学校や会社がオンラインで申請を代行する場合もあります）',
                        'place_np' => 'तपाईं बस्ने क्षेत्रको इमिग्रेसन कार्यालय (केही अवस्थामा स्कुल वा कम्पनीले अनलाइनबाट तपाईंको तर्फबाट आवेदन दिन सक्छ)',
                        'note_jp' => 'オンライン申請が利用できるかどうかは、在籍している学校や勤務先によって異なります。まず学校・会社の国際担当や人事担当に確認してください。',
                        'note_np' => 'अनलाइनबाट बसाइँ अवधि नवीकरण गर्न मिल्ने/नमिल्ने कुरा तपाईंको स्कुल वा कम्पनीमा निर्भर हुन्छ। सुरुमा स्कुलको अन्तर्राष्ट्रिय काउन्टर वा कम्पनीको HR विभागसँग सोधेर जानकारी लिनुहोस्。',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [
                            [
                                'label_jp' => '在留期間更新許可申請書',
                                'label_np' => 'बसोबास अवधि नवीकरण फारम',
                                'path' => 'documents/admin/immigration/extension_sample.pdf',
                            ],
                        ],
                    ],
                    [
                        'name_jp' => '資格外活動許可申請書',
                        'name_np' => 'योग्यताको बाहिरको काम अनुमति आवेदन',
                        'documents' => [
                            ['label_jp' => 'パスポート', 'label_np' => 'पासपोर्ट'],
                            ['label_jp' => '在留カード', 'label_np' => 'रेजिडेन्स कार्ड'],
                            ['label_jp' => '資格外活動許可申請書', 'label_np' => 'योग्यताबाहिर कामको आवेदन फारम'],
                        ],
                        // 書類自体はこのサイトで作成可能だが、提出先は入管
                        'source' => 'immigration',
                        'place_jp' => '在留地を管轄する出入国在留管理局の窓口（多くの場合、学校の国際担当窓口を通じてまとめて提出）',
                        'place_np' => 'तपाईंको बसोबास क्षेत्रको इमिग्रेसन कार्यालय (धेरै विद्यार्थीले स्कुलको अन्तर्राष्ट्रिय काउन्टरमार्फत सामूहिक रूपमा आवेदन दिन्छन्)',
                        'note_jp' => 'このサイトで作成した申請書を印刷し、パスポート・在留カードと一緒に入管窓口または学校の国際担当窓口へ提出します。許可を受けた後も、アルバイト時間は原則として週28時間以内に収める必要があります。',
                        'note_np' => 'यस साइटबाट तयार गरिएको आवेदन फारम प्रिन्ट गरेर, पासपोर्ट र रेजिडेन्स कार्डसँगै इमिग्रेसन वा स्कुलको अन्तर्राष्ट्रिय काउन्टरमा बुझाउनुहोस्। अनुमति पाएपछि पनि हप्तामा २८ घण्टाभन्दा बढी काम गर्न मिल्दैन।',
                        'can_generate_pdf' => true,
                        'generate_route' => 'work-permit',
                        'downloads' => [
                            [
                                'label_jp' => '資格外活動許可申請書',
                                'label_np' => 'योग्यताबाहिर कामको आवेदन फारम',
                                'path' => 'documents/admin/immigration/shikakugai_blank.pdf',
                            ],
                        ],
                    ],
                    [
                        'name_jp' => '在留カードの更新・再交付',
                        'name_np' => 'रेजिडेन्स कार्ड नवीकरण / पुन: जारी',
                        'documents' => [
                            ['label_jp' => 'パスポート', 'label_np' => 'पासपोर्ट'],
                            ['label_jp' => '現在の在留カード', 'label_np' => 'हालको रेजिडेन्स कार्ड'],
                            ['label_jp' => '在留カード再交付申請書', 'label_np' => 'रेजिडेन्स कार्ड पुन: जारी फारम'],
                        ],
                        'source' => 'immigration',
                        'place_jp' => '最寄りの出入国在留管理局・支局・出張所の窓口',
                        'place_np' => 'नजिकको इमिग्रेशन कार्यालय (मुख्य, शाखा वा कार्यालय)',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [
                            [
                                'label_jp' => '在留カード再交付申請書',
                                'label_np' => 'रेजिडेन्स कार्ड पुन: जारी फारम',
                                'path' => 'documents/admin/immigration/card_reissue.pdf',
                            ],
                        ],
                    ],
                    [
                        'name_jp' => '在留カードを紛失・盗難したとき',
                        'name_np' => 'रेजिडेन्स कार्ड हरायो वा चोरी भयो भने',
                        'documents' => [
                            ['label_jp' => 'パスポート', 'label_np' => 'पासपोर्ट'],
                            ['label_jp' => '紛失・盗難を証明する書類（警察の受理番号など）', 'label_np' => 'हराएको/चोरी भएको भनी प्रहरीमा दिएको जानकारी (स्वीकृति नम्बर आदि)'],
                            ['label_jp' => '在留カード再交付申請書', 'label_np' => 'रेजिडेन्स कार्ड पुन: जारी आवेदन फारम'],
                        ],
                        'source' => 'immigration',
                        'place_jp' => '警察での届出 → その後、出入国在留管理局の窓口',
                        'place_np' => 'पहिले प्रहरीमा हराएको/चोरी भएको जानकारी दिनु, त्यसपछि इमिग्रेशन कार्यालयमा जानु',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [
                            [
                                'label_jp' => '在留カード再交付申請書',
                                'label_np' => 'रेजिडेन्स कार्ड पुन: जारी फारम',
                                'path' => 'documents/admin/immigration/card_loss_reissue.pdf',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'id' => 'family',
                'title_jp' => '家族を呼ぶ',
                'title_np' => 'परिवारलाई बोलाउने',
                'description' => "家族滞在ビザや在留資格認定証明書（COE）など、日本に家族を呼ぶときの手続きをまとめています。\nपरिवारलाई जापान बोलाउँदा चाहिने भिसा र COE (बसोबास योग्यता प्रमाणपत्र) सम्बन्धी प्रक्रिया हो।",
                'icon' => 'family',
                'color' => 'green',
                'procedures' => [
                    [
                        'name_jp' => '在留資格認定証明書（COE）の申請',
                        'name_np' => 'बसोबास योग्यता प्रमाणपत्र (COE) को आवेदन',
                        'documents' => [
                            ['label_jp' => '申請人・家族のパスポート', 'label_np' => 'आवेदक र परिवारको पासपोर्ट'],
                            ['label_jp' => '身元保証書', 'label_np' => 'जिम्मेवार व्यत्तिको ग्यारेन्टी पत्र'],
                            ['label_jp' => '理由書（日本語・英語など）', 'label_np' => 'कारण पत्र (जापानी / अङ्ग्रेजी)'],
                        ],
                        'source' => 'immigration',
                        'place_jp' => '管轄の出入国在留管理局',
                        'place_np' => 'तपाईंको बसोबास क्षेत्रको इमिग्रेशन कार्यालय',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [
                            [
                                'label_jp' => '身元保証書',
                                'label_np' => 'जिम्मेवार व्यत्तिको ग्यारेन्टी पत्र',
                                'path' => 'documents/admin/family/guarantee_template.pdf',
                            ],
                        ],
                    ],
                    [
                        'name_jp' => '家族滞在ビザの申請',
                        'name_np' => 'परिवार बसोबास भिसा आवेदन',
                        'documents' => [
                            ['label_jp' => '在留資格認定証明書（原本）', 'label_np' => 'COE (मूल)'],
                            ['label_jp' => '婚姻・出生証明書（翻訳付き）', 'label_np' => 'विवाह / जन्म प्रमाणपत्र (अनुवाद सहित)'],
                            ['label_jp' => '保証人の在留カードコピー', 'label_np' => 'जिम्मेवारको रेजिडेन्स कार्डको प्रतिलिपि'],
                        ],
                        'source' => 'immigration',
                        'place_jp' => '管轄の出入国在留管理局',
                        'place_np' => 'तपाईंको क्षेत्रको इमिग्रेशन कार्यालय',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [],
                    ],
                ],
            ],
            [
                'id' => 'change-status',
                'title_jp' => '転職・卒業したとき',
                'title_np' => 'रोजगार परिवर्तन वा स्नातक भएपछि',
                'description' => "転職・退職・卒業などで学校や会社が変わったときに必要な届出や在留資格変更の手続きです。\nकाम/स्कुल परिवर्तन वा स्नातक भएपछि इमिग्रेशनमा दिनुपर्ने सूचना र योग्यता परिवर्तन सम्बन्धी प्रक्रिया हो।",
                'icon' => 'briefcase',
                'color' => 'amber',
                'procedures' => [
                    [
                        'name_jp' => '所属機関変更の届出',
                        'name_np' => 'संस्था परिवर्तनको सूचना',
                        'documents' => [
                            ['label_jp' => '在留カード', 'label_np' => 'रेजिडेन्स कार्ड'],
                            ['label_jp' => '新しい会社・学校の情報', 'label_np' => 'नयाँ कम्पनी/स्कुलको विवरण'],
                            ['label_jp' => '届出書（所属機関変更）', 'label_np' => 'संस्था परिवर्तनको फारम'],
                        ],
                        'source' => 'immigration',
                        'place_jp' => '出入国在留管理局（長期在留を扱う窓口）',
                        'place_np' => 'इमिग्रेशन कार्यालय (दीर्घकालीन बसोबास सम्बन्धित खिड्की)',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [
                            [
                                'label_jp' => '所属機関変更届出書',
                                'label_np' => 'संस्था परिवर्तन सूचना फारम',
                                'path' => 'documents/admin/status/change_employer.pdf',
                            ],
                        ],
                    ],
                    [
                        'name_jp' => '在留資格の変更（留学→就労など）',
                        'name_np' => 'बसोबास योग्यता परिवर्तन (विद्यार्थी → रोजगारी आदि)',
                        'documents' => [
                            ['label_jp' => '在留資格変更許可申請書', 'label_np' => 'बसोबास योग्यता परिवर्तन आवेदन फारम'],
                            ['label_jp' => '卒業証明書または内定通知書', 'label_np' => 'स्नातक प्रमाणपत्र वा रोजगारी स्वीकृति पत्र'],
                            ['label_jp' => '会社の登記事項証明書など', 'label_np' => 'कम्पनी दर्ता प्रमाण आदि'],
                        ],
                        'source' => 'immigration',
                        'place_jp' => '出入国在留管理局',
                        'place_np' => 'इमिग्रेशन कार्यालय',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [
                            [
                                'label_jp' => '在留資格変更許可申請書',
                                'label_np' => 'बसोबास योग्यता परिवर्तन फारम',
                                'path' => 'documents/admin/status/change_status_sample.pdf',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'id' => 'long-term',
                'title_jp' => '長期定住',
                'title_np' => 'दीर्घकालीन बसोबास',
                'description' => "永住許可申請や特定技能ビザなど、日本に長く住み続けるための手続きをまとめています。\nजापानमा दीर्घकालसम्म बस्नका लागि 永住 र 特定技能 जस्ता प्रक्रियाहरु यहाँ समेटिएका छन्।",
                'icon' => 'home',
                'color' => 'purple',
                'procedures' => [
                    [
                        'name_jp' => '永住許可申請',
                        'name_np' => 'स्थायी बसोबास (永住) को आवेदन',
                        'documents' => [
                            ['label_jp' => '永住許可申請書', 'label_np' => '永住 अनुमति आवेदन फारम'],
                            ['label_jp' => '理由書', 'label_np' => 'कारण पत्र'],
                            ['label_jp' => '課税・納税証明書', 'label_np' => 'कर सम्बन्धी प्रमाणपत्र'],
                        ],
                        'source' => 'immigration',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [
                            [
                                'label_jp' => '永住許可申請書',
                                'label_np' => '永住 आवेदन फारम',
                                'path' => 'documents/admin/longterm/permanent_residence.pdf',
                            ],
                        ],
                    ],
                    [
                        'name_jp' => '特定技能ビザの申請',
                        'name_np' => 'विशेष सीप (特定技能) भिसा आवेदन',
                        'documents' => [
                            ['label_jp' => '特定技能評価試験合格証', 'label_np' => 'विशेष सीप परीक्षाको प्रमाणपत्र'],
                            ['label_jp' => '雇用契約書', 'label_np' => 'रोजगार सम्झौता पत्र'],
                            ['label_jp' => '在留資格変更許可申請書', 'label_np' => 'बसोबास योग्यता परिवर्तन फारम'],
                        ],
                        'source' => 'immigration',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [],
                    ],
                ],
            ],
            [
                'id' => 'city-hall',
                'title_jp' => '役所の手続き',
                'title_np' => 'नगरपालिका / वडा कार्यालयका प्रक्रिया',
                'description' => "住所変更の届出や国民健康保険・年金の加入・脱退など、市区町村役所で行う基本的な手続きです。\nठेगाना परिवर्तन, स्वास्थ्य बीमा, पेन्सन आदि सम्बन्धी प्रक्रिया नगरपालिकामा पूरा गर्नुपर्छ।",
                'icon' => 'building',
                'color' => 'teal',
                'procedures' => [
                    [
                        'name_jp' => '住所変更の届出（転入・転出・転居）',
                        'name_np' => 'ठेगाना परिवर्तनको सूचना (सर्ने / बसाइँसराइ)',
                        'documents' => [
                            ['label_jp' => '在留カード', 'label_np' => 'रेजिडेन्स कार्ड'],
                            ['label_jp' => 'パスポート', 'label_np' => 'पासपोर्ट'],
                            ['label_jp' => '転出証明書（他市区町村から引越しのとき）', 'label_np' => 'बसाइँसराइ प्रमाणपत्र'],
                        ],
                        'source' => 'city-hall',
                        'place_jp' => '現在住んでいる市区町村の役所（市役所・区役所など）の住民窓口',
                        'place_np' => 'तपाईं बस्नु हुने शहर/नगरपालिकाको कार्यालय (市役所/区役所 आदि)',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [],
                    ],
                    [
                        'name_jp' => '国民健康保険の加入・脱退',
                        'name_np' => 'राष्ट्रिय स्वास्थ्य बीमा (加入/रद्द)',
                        'documents' => [
                            ['label_jp' => '在留カード', 'label_np' => 'रेजिडेन्स कार्ड'],
                            ['label_jp' => 'マイナンバー（通知カード等）', 'label_np' => 'माईनम्बर (सूचना कार्ड आदि)'],
                            ['label_jp' => '雇用保険等の証明書（必要な場合）', 'label_np' => 'रोजगार बीमा आदिको प्रमाणपत्र (आवश्यक भएमा)'],
                        ],
                        'source' => 'city-hall',
                        'place_jp' => '住所地の市区町村役所（保険年金担当窓口）',
                        'place_np' => 'बसोबास ठेगानाको नगरपालिकाको बीमा/पेन्सन खिड्की',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [],
                    ],
                    [
                        'name_jp' => '国民年金の手続き',
                        'name_np' => 'राष्ट्रिय पेन्सन सम्बन्धी प्रक्रिया',
                        'documents' => [
                            ['label_jp' => '在留カード', 'label_np' => 'रेजिडेन्स कार्ड'],
                            ['label_jp' => '基礎年金番号のわかるもの', 'label_np' => 'पेन्सन नम्बर देखिने कागज'],
                        ],
                        'source' => 'city-hall',
                        'place_jp' => '市区町村役所、または年金事務所',
                        'place_np' => 'नगरपालिका वा पेन्सन कार्यालय',
                        'can_generate_pdf' => false,
                        'generate_route' => null,
                        'downloads' => [],
                    ],
                ],
            ],
        ];

        return view('admin-procedures.index', compact('categories'));
    }
}
