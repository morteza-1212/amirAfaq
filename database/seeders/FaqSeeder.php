<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqTranslation;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [

            /* =========================================================
               ۱. سلام و احوال‌پرسی
            ========================================================= */
            [
                'slug'     => 'greeting',
                'priority' => 100,
                'translations' => [
                    'fa' => [
                        'question' => 'سلام',
                        'answer'   => 'سلام و درود! 🌱 به شرکت امیر آفاق گستر پارس خوش آمدید. چطور می‌توانم به شما کمک کنم؟ می‌توانید درباره محصولات، صادرات، واردات یا همکاری سوال بپرسید.',
                        'keywords' => ['سلام', 'درود', 'خوبی', 'چطوری', 'احوال', 'وقت بخیر'],
                    ],
                    'en' => [
                        'question' => 'Hello',
                        'answer'   => 'Hello and welcome to Amir Afaq Gostar Pars! 🌱 How can I help you today? Feel free to ask about our products, export, import, or partnership opportunities.',
                        'keywords' => ['hello', 'hi', 'hey', 'greetings', 'good morning', 'good evening'],
                    ],
                    'ar' => [
                        'question' => 'مرحبا',
                        'answer'   => 'مرحباً بكم في شركة أمير آفاق كستر بارس! 🌱 كيف يمكنني مساعدتك اليوم؟ يمكنك السؤال عن المنتجات أو التصدير أو الاستيراد أو فرص التعاون.',
                        'keywords' => ['مرحبا', 'أهلا', 'السلام عليكم', 'صباح الخير', 'مساء الخير'],
                    ],
                ],
            ],

            /* =========================================================
               ۲. تشکر و خداحافظی
            ========================================================= */
            [
                'slug'     => 'thanks-farewell',
                'priority' => 99,
                'translations' => [
                    'fa' => [
                        'question' => 'ممنون',
                        'answer'   => 'خواهش می‌کنم! 🌸 اگر سوال دیگری دارید، در خدمتیم. روز خوبی داشته باشید.',
                        'keywords' => ['ممنون', 'مرسی', 'تشکر', 'سپاس', 'خداحافظ', 'خدانگهدار', 'بای'],
                    ],
                    'en' => [
                        'question' => 'Thank you',
                        'answer'   => 'You\'re welcome! 🌸 If you have any other questions, feel free to ask. Have a great day!',
                        'keywords' => ['thanks', 'thank you', 'bye', 'goodbye', 'cheers'],
                    ],
                    'ar' => [
                        'question' => 'شكرا',
                        'answer'   => 'على الرحب والسعة! 🌸 إذا كان لديك أي سؤال آخر، فلا تتردد في السؤال. أتمنى لك يوماً سعيداً!',
                        'keywords' => ['شكرا', 'شكراً', 'مع السلامة', 'وداعا'],
                    ],
                ],
            ],

            /* =========================================================
               ۳. معرفی شرکت
            ========================================================= */
            [
                'slug'     => 'about-company',
                'priority' => 95,
                'translations' => [
                    'fa' => [
                        'question' => 'شرکت شما چه کاری انجام می‌دهد؟',
                        'answer'   => 'شرکت امیر آفاق گستر پارس در زمینه صادرات و واردات محصولات کشاورزی، لبنی و غذایی فعالیت می‌کند. ما محصولات باکیفیت ایرانی را به بازارهای جهانی صادر می‌کنیم و محصولات مورد نیاز داخلی را وارد می‌کنیم. 🌍',
                        'keywords' => ['شرکت', 'معرفی', 'کاری', 'فعالیت', 'زمینه', 'چه کار', 'درباره'],
                    ],
                    'en' => [
                        'question' => 'What does your company do?',
                        'answer'   => 'Amir Afaq Gostar Pars is active in the export and import of agricultural, dairy, and food products. We export high-quality Iranian products to global markets and import needed goods. 🌍',
                        'keywords' => ['company', 'about', 'business', 'what do you do', 'activity'],
                    ],
                    'ar' => [
                        'question' => 'ماذا تفعل شركتكم؟',
                        'answer'   => 'تعمل شركة أمير آفاق كستر بارس في تصدير واستيراد المنتجات الزراعية والألبان والغذائية. نصدر المنتجات الإيرانية عالية الجودة إلى الأسواق العالمية. 🌍',
                        'keywords' => ['شركة', 'ماذا', 'تعمل', 'نشاط', 'عن'],
                    ],
                ],
            ],

            /* =========================================================
               ۴. هزینه ارسال
            ========================================================= */
            [
                'slug'     => 'shipping-cost',
                'priority' => 90,
                'translations' => [
                    'fa' => [
                        'question' => 'هزینه ارسال چقدر است؟',
                        'answer'   => 'هزینه ارسال بسته به مقصد، وزن و روش حمل (دریایی، زمینی، هوایی) محاسبه می‌شود. برای مشاوره دقیق لطفاً با کارشناسان ما تماس بگیرید: ۰۹۱۵۷۱۱۸۵۶۵ 🚚',
                        'keywords' => ['هزینه', 'ارسال', 'پست', 'کرایه', 'حمل', 'کرایه حمل'],
                    ],
                    'en' => [
                        'question' => 'How much is the shipping cost?',
                        'answer'   => 'Shipping cost depends on destination, weight, and shipping method (sea, land, air). For an accurate quote, please contact our experts: +98 915 718 5655 🚚',
                        'keywords' => ['shipping', 'cost', 'delivery', 'price', 'freight'],
                    ],
                    'ar' => [
                        'question' => 'كم تكلفة الشحن؟',
                        'answer'   => 'تعتمد تكلفة الشحن على الوجهة والوزن وطريقة الشحن (بحري، بري، جوي). للحصول على عرض دقيق، يرجى الاتصال بخبرائنا: ‎+98 915 718 5655 🚚',
                        'keywords' => ['الشحن', 'التكلفة', 'التوصيل', 'سعر'],
                    ],
                ],
            ],

            /* =========================================================
               ۵. روش‌های پرداخت
            ========================================================= */
            [
                'slug'     => 'payment-methods',
                'priority' => 89,
                'translations' => [
                    'fa' => [
                        'question' => 'روش‌های پرداخت کدامند؟',
                        'answer'   => 'برای معاملات داخلی: پرداخت آنلاین با تمام کارت‌های شتاب، کارت به کارت و پرداخت در محل. برای معاملات بین‌المللی: حواله بانکی (SWIFT)، LC (اعتبار اسنادی) و پیش‌پرداخت. 💳',
                        'keywords' => ['پرداخت', 'کارت', 'آنلاین', 'درگاه', 'حواله', 'LC'],
                    ],
                    'en' => [
                        'question' => 'What payment methods do you accept?',
                        'answer'   => 'For domestic: online payment with all Shetab cards, card-to-card transfer, cash on delivery. For international: bank wire (SWIFT), LC (Letter of Credit), and prepayment. 💳',
                        'keywords' => ['payment', 'card', 'online', 'gateway', 'swift', 'lc'],
                    ],
                    'ar' => [
                        'question' => 'ما هي طرق الدفع المتاحة؟',
                        'answer'   => 'للمعاملات المحلية: الدفع الإلكتروني، التحويل البطاقي، الدفع عند الاستلام. للمعاملات الدولية: الحوالة البنكية (SWIFT)، الاعتماد المستندي (LC)، والدفع المسبق. 💳',
                        'keywords' => ['الدفع', 'بطاقة', 'إلكتروني', 'حوالة', 'اعتماد'],
                    ],
                ],
            ],

            /* =========================================================
               ۶. شرایط بازگشت کالا
            ========================================================= */
            [
                'slug'     => 'return-policy',
                'priority' => 85,
                'translations' => [
                    'fa' => [
                        'question' => 'شرایط بازگشت کالا چیست؟',
                        'answer'   => 'برای معاملات داخلی تا ۷ روز پس از دریافت، در صورت سالم بودن بسته‌بندی و برچسب، امکان بازگشت وجود دارد. برای صادرات/واردات، شرایط در قرارداد مشخص می‌شود. 💝',
                        'keywords' => ['بازگشت', 'مرجوعی', 'تعویض', 'پس دادن', 'استرداد'],
                    ],
                    'en' => [
                        'question' => 'What is your return policy?',
                        'answer'   => 'For domestic orders: within 7 days of receipt, provided packaging and tags are intact. For export/import, terms are specified in the contract. 💝',
                        'keywords' => ['return', 'refund', 'exchange', 'policy'],
                    ],
                    'ar' => [
                        'question' => 'ما هي سياسة الإرجاع؟',
                        'answer'   => 'للطلبات المحلية: خلال 7 أيام من الاستلام، بشرط سلامة التغليف والعلامات. للتصدير/الاستيراد: تُحدد الشروط في العقد. 💝',
                        'keywords' => ['إرجاع', 'استرداد', 'تبديل', 'سياسة'],
                    ],
                ],
            ],

            /* =========================================================
               ۷. ساعات کاری
            ========================================================= */
            [
                'slug'     => 'working-hours',
                'priority' => 80,
                'translations' => [
                    'fa' => [
                        'question' => 'ساعات کاری شما چیست؟',
                        'answer'   => 'شنبه تا چهارشنبه: ۹ صبح تا ۱۸ عصر. پنجشنبه: ۹ صبح تا ۱۳. جمعه‌ها تعطیل هستیم. ⏰',
                        'keywords' => ['ساعت', 'کاری', 'زمان', 'تعطیل', 'ساعات کاری'],
                    ],
                    'en' => [
                        'question' => 'What are your working hours?',
                        'answer'   => 'Saturday to Wednesday: 9 AM to 6 PM. Thursday: 9 AM to 1 PM. Closed on Fridays. ⏰',
                        'keywords' => ['hours', 'working', 'time', 'schedule'],
                    ],
                    'ar' => [
                        'question' => 'ما هي ساعات العمل؟',
                        'answer'   => 'من السبت إلى الأربعاء: 9 صباحاً حتى 6 مساءً. الخميس: 9 صباحاً حتى 1 ظهراً. الجمعة مغلق. ⏰',
                        'keywords' => ['ساعات', 'عمل', 'وقت', 'دوام'],
                    ],
                ],
            ],

            /* =========================================================
               ۸. تماس با ما
            ========================================================= */
            [
                'slug'     => 'contact-us',
                'priority' => 79,
                'translations' => [
                    'fa' => [
                        'question' => 'چطور می‌توانم با شما تماس بگیرم؟',
                        'answer'   => '📞 تلفن: ۰۹۱۵۷۱۱۸۵۶۵ — ۰۲۱۸۸۷۷۶۶۵۵\n📧 ایمیل: info@amirafaq.ir\n🌐 وب‌سایت: amirafaq.ir\n📍 آدرس: تهران، ایران',
                        'keywords' => ['تماس', 'شماره', 'ایمیل', 'ارتباط', 'تلفن', 'آدرس'],
                    ],
                    'en' => [
                        'question' => 'How can I contact you?',
                        'answer'   => '📞 Phone: +98 915 718 5655 — +98 21 8877 6655\n📧 Email: info@amirafaq.ir\n🌐 Website: amirafaq.ir\n📍 Address: Tehran, Iran',
                        'keywords' => ['contact', 'phone', 'email', 'address', 'reach'],
                    ],
                    'ar' => [
                        'question' => 'كيف يمكنني الاتصال بكم؟',
                        'answer'   => '📞 الهاتف: ‎+98 915 718 5655 — ‎+98 21 8877 6655\n📧 البريد: info@amirafaq.ir\n🌐 الموقع: amirafaq.ir\n📍 العنوان: طهران، إيران',
                        'keywords' => ['اتصال', 'هاتف', 'بريد', 'عنوان', 'تواصل'],
                    ],
                ],
            ],

            /* =========================================================
               ۹. محصولات صادراتی
            ========================================================= */
            [
                'slug'     => 'export-products',
                'priority' => 78,
                'translations' => [
                    'fa' => [
                        'question' => 'چه محصولاتی صادر می‌کنید؟',
                        'answer'   => 'ما محصولات کشاورزی (زعفران، پسته، خرما، کشمش، انار، سیب)، لبنیات (پنیر، ماست، کره) و محصولات غذایی را صادر می‌کنیم. 🌾🧀',
                        'keywords' => ['صادرات', 'محصول', 'صادر می‌کنید', 'چه محصولاتی', 'زعفران', 'پسته', 'خرما'],
                    ],
                    'en' => [
                        'question' => 'What products do you export?',
                        'answer'   => 'We export agricultural products (saffron, pistachio, dates, raisins, pomegranate, apples), dairy (cheese, yogurt, butter), and food products. 🌾🧀',
                        'keywords' => ['export', 'products', 'what do you export', 'saffron', 'pistachio', 'dates'],
                    ],
                    'ar' => [
                        'question' => 'ما المنتجات التي تصدرونها؟',
                        'answer'   => 'نصدر المنتجات الزراعية (الزعفران، الفستق، التمور، الزبيب، الرمان، التفاح)، ومنتجات الألبان (الجبن، الزبادي، الزبدة)، والمنتجات الغذائية. 🌾🧀',
                        'keywords' => ['تصدير', 'منتجات', 'ماذا تصدرون', 'زعفران', 'فستق', 'تمر'],
                    ],
                ],
            ],

            /* =========================================================
               ۱۰. محصولات وارداتی
            ========================================================= */
            [
                'slug'     => 'import-products',
                'priority' => 77,
                'translations' => [
                    'fa' => [
                        'question' => 'چه محصولاتی وارد می‌کنید؟',
                        'answer'   => 'ما مواد اولیه صنایع غذایی، محصولات کشاورزی خاص، تجهیزات بسته‌بندی و ماشین‌آلات مرتبط با صنایع غذایی و کشاورزی را وارد می‌کنیم. 📦',
                        'keywords' => ['واردات', 'وارد می‌کنید', 'چه محصولاتی', 'مواد اولیه', 'تجهیزات'],
                    ],
                    'en' => [
                        'question' => 'What products do you import?',
                        'answer'   => 'We import raw materials for the food industry, specialty agricultural products, packaging equipment, and machinery related to food and agriculture. 📦',
                        'keywords' => ['import', 'products', 'what do you import', 'raw materials', 'equipment'],
                    ],
                    'ar' => [
                        'question' => 'ما المنتجات التي تستوردونها؟',
                        'answer'   => 'نستورد المواد الخام لصناعة الأغذية، ومنتجات زراعية متخصصة، ومعدات التعبئة، والآلات المتعلقة بالغذاء والزراعة. 📦',
                        'keywords' => ['استيراد', 'منتجات', 'ماذا تستوردون', 'مواد خام', 'معدات'],
                    ],
                ],
            ],

            /* =========================================================
               ۱۱. شرایط همکاری / خرید عمده
            ========================================================= */
            [
                'slug'     => 'wholesale-partnership',
                'priority' => 76,
                'translations' => [
                    'fa' => [
                        'question' => 'شرایط خرید عمده چیست؟',
                        'answer'   => 'برای خرید عمده و همکاری تجاری، لطفاً با کارشناسان ما تماس بگیرید تا شرایط ویژه (قیمت، حجم، زمان تحویل) بررسی شود. 📞 ۰۹۱۵۷۱۱۸۵۶۵',
                        'keywords' => ['خرید عمده', 'همکاری', 'شرایط', 'عمده', 'تخفیف ویژه'],
                    ],
                    'en' => [
                        'question' => 'What are the wholesale terms?',
                        'answer'   => 'For wholesale and business partnership, please contact our experts to discuss special terms (price, volume, delivery time). 📞 +98 915 718 5655',
                        'keywords' => ['wholesale', 'partnership', 'terms', 'bulk', 'b2b'],
                    ],
                    'ar' => [
                        'question' => 'ما هي شروط البيع بالجملة؟',
                        'answer'   => 'للبيع بالجملة والشراكة التجارية، يرجى الاتصال بخبرائنا لمناقشة الشروط الخاصة (السعر، الكمية، وقت التسليم). 📞 ‎+98 915 718 5655',
                        'keywords' => ['بالجملة', 'شراكة', 'شروط', 'كميات كبيرة'],
                    ],
                ],
            ],

            /* =========================================================
               ۱۲. مقاصد صادراتی
            ========================================================= */
            [
                'slug'     => 'export-destinations',
                'priority' => 75,
                'translations' => [
                    'fa' => [
                        'question' => 'به کدام کشورها صادرات دارید؟',
                        'answer'   => 'ما به کشورهای حاشیه خلیج فارس (امارات، قطر، عمان، کویت)، آسیای میانه، روسیه، چین، هند و برخی کشورهای اروپایی صادرات داریم. 🌍',
                        'keywords' => ['کدام کشورها', 'مقصد', 'صادرات به', 'بازار', 'امارات', 'روسیه'],
                    ],
                    'en' => [
                        'question' => 'Which countries do you export to?',
                        'answer'   => 'We export to Persian Gulf countries (UAE, Qatar, Oman, Kuwait), Central Asia, Russia, China, India, and some European countries. 🌍',
                        'keywords' => ['which countries', 'destination', 'export to', 'market', 'uae', 'russia'],
                    ],
                    'ar' => [
                        'question' => 'إلى أي دول تصدرون؟',
                        'answer'   => 'نصدر إلى دول الخليج (الإمارات، قطر، عمان، الكويت)، وآسيا الوسطى، وروسيا، والصين، والهند، وبعض الدول الأوروبية. 🌍',
                        'keywords' => ['أي دول', 'الوجهة', 'تصدير إلى', 'سوق', 'الإمارات'],
                    ],
                ],
            ],

            /* =========================================================
               ۱۳. بسته‌بندی
            ========================================================= */
            [
                'slug'     => 'packaging',
                'priority' => 74,
                'translations' => [
                    'fa' => [
                        'question' => 'بسته‌بندی محصولات چگونه است؟',
                        'answer'   => 'بسته‌بندی ما بر اساس استانداردهای بین‌المللی و مطابق با نیاز مشتری انجام می‌شود: بسته‌بندی صادراتی، برند اختصاصی مشتری (Private Label)، و بسته‌بندی خاص بر اساس درخواست. 📦',
                        'keywords' => ['بسته‌بندی', 'بسته', 'packaging', 'بسته‌بندی صادراتی'],
                    ],
                    'en' => [
                        'question' => 'How is the packaging done?',
                        'answer'   => 'Our packaging follows international standards and customer requirements: export packaging, private label, and custom packaging on request. 📦',
                        'keywords' => ['packaging', 'package', 'private label', 'export packaging'],
                    ],
                    'ar' => [
                        'question' => 'كيف تتم التعبئة والتغليف؟',
                        'answer'   => 'تتم التعبئة وفقاً للمعايير الدولية ومتطلبات العميل: تعبئة التصدير، والعلامة التجارية الخاصة، والتعبئة المخصصة عند الطلب. 📦',
                        'keywords' => ['تعبئة', 'تغليف', 'التعبئة', 'التغليف'],
                    ],
                ],
            ],

            /* =========================================================
               ۱۴. Incoterms
            ========================================================= */
            [
                'slug'     => 'incoterms',
                'priority' => 73,
                'translations' => [
                    'fa' => [
                        'question' => 'چه Incoterms پشتیبانی می‌کنید؟',
                        'answer'   => 'ما از تمام Incoterms رایج پشتیبانی می‌کنیم: FOB، CIF، CFR، EXW، DAP، DDP و ... . شرایط دقیق در قرارداد مشخص می‌شود. 📋',
                        'keywords' => ['اینکوترمز', 'incoterms', 'FOB', 'CIF', 'شرایط تحویل'],
                    ],
                    'en' => [
                        'question' => 'Which Incoterms do you support?',
                        'answer'   => 'We support all common Incoterms: FOB, CIF, CFR, EXW, DAP, DDP, etc. Exact terms are specified in the contract. 📋',
                        'keywords' => ['incoterms', 'fob', 'cif', 'cfr', 'delivery terms'],
                    ],
                    'ar' => [
                        'question' => 'ما هي شروط التجارة الدولية التي تدعمونها؟',
                        'answer'   => 'ندعم جميع شروط الإنكوترمز الشائعة: FOB، CIF، CFR، EXW، DAP، DDP، إلخ. تُحدد الشروط الدقيقة في العقد. 📋',
                        'keywords' => ['إنكوترمز', 'شروط', 'التسليم', 'التجارة الدولية'],
                    ],
                ],
            ],

            /* =========================================================
               ۱۵. مهلت تحویل
            ========================================================= */
            [
                'slug'     => 'delivery-time',
                'priority' => 72,
                'translations' => [
                    'fa' => [
                        'question' => 'مهلت تحویل چقدر است؟',
                        'answer'   => 'مهلت تحویل بسته به نوع محصول، حجم سفارش و مقصد متفاوت است. معمولاً بین ۷ تا ۳۰ روز کاری. برای زمان دقیق با کارشناسان ما هماهنگ کنید. ⏱️',
                        'keywords' => ['مهلت', 'تحویل', 'چه زمانی', 'چند روز', 'زمان تحویل'],
                    ],
                    'en' => [
                        'question' => 'What is the delivery time?',
                        'answer'   => 'Delivery time varies based on product type, order volume, and destination. Typically 7 to 30 working days. Contact our experts for an exact timeframe. ⏱️',
                        'keywords' => ['delivery time', 'lead time', 'how long', 'when'],
                    ],
                    'ar' => [
                        'question' => 'ما هي مدة التسليم؟',
                        'answer'   => 'تختلف مدة التسليم حسب نوع المنتج وحجم الطلب والوجهة. عادةً من 7 إلى 30 يوم عمل. اتصل بخبرائنا للحصول على وقت محدد. ⏱️',
                        'keywords' => ['مدة التسليم', 'وقت التسليم', 'متى'],
                    ],
                ],
            ],

            /* =========================================================
               ۱۶. شکایت و پشتیبانی
            ========================================================= */
            [
                'slug'     => 'complaint-support',
                'priority' => 71,
                'translations' => [
                    'fa' => [
                        'question' => 'می‌خواهم شکایت کنم',
                        'answer'   => 'متأسفیم که ناراضی هستید. 🙏 لطفاً مشکل خود را به‌طور کامل توضیح دهید یا با شماره ۰۹۱۵۷۱۱۸۵۶۵ تماس بگیرید تا در اسرع وقت بررسی شود. پیام شما به کارشناس ارجاع داده می‌شود.',
                        'keywords' => ['شکایت', 'ناراضی', 'مشکل', 'ایراد', 'خرابی'],
                    ],
                    'en' => [
                        'question' => 'I want to file a complaint',
                        'answer'   => 'We\'re sorry for the inconvenience. 🙏 Please describe your issue in detail or call +98 915 718 5655 so we can address it promptly. Your message will be forwarded to a specialist.',
                        'keywords' => ['complaint', 'problem', 'issue', 'damage', 'wrong'],
                    ],
                    'ar' => [
                        'question' => 'أريد تقديم شكوى',
                        'answer'   => 'نأسف لعدم رضاك. 🙏 يرجى وصف مشكلتك بالتفصيل أو الاتصال بالرقم ‎+98 915 718 5655 لمعالجتها في أقرب وقت. سيتم تحويل رسالتك إلى مختص.',
                        'keywords' => ['شكوى', 'مشكلة', 'عيب', 'تلف'],
                    ],
                ],
            ],

            /* =========================================================
               ۱۷. گواهی‌ها و استانداردها
            ========================================================= */
            [
                'slug'     => 'certificates-standards',
                'priority' => 70,
                'translations' => [
                    'fa' => [
                        'question' => 'چه گواهی‌ها و استانداردهایی دارید؟',
                        'answer'   => 'ما دارای گواهی‌های ISO 9001، ISO 22000، HACCP، و گواهی‌های بهداشتی مرتبط با محصولات غذایی و کشاورزی هستیم. تمام محصولات با استانداردهای بین‌المللی مطابقت دارند. ✅',
                        'keywords' => ['گواهی', 'استاندارد', 'ISO', 'HACCP', 'مجوز'],
                    ],
                    'en' => [
                        'question' => 'What certificates and standards do you have?',
                        'answer'   => 'We hold ISO 9001, ISO 22000, HACCP certificates and health certificates related to food and agricultural products. All products comply with international standards. ✅',
                        'keywords' => ['certificate', 'standard', 'iso', 'haccp', 'quality'],
                    ],
                    'ar' => [
                        'question' => 'ما هي الشهادات والمعايير التي لديكم؟',
                        'answer'   => 'نحمل شهادات ISO 9001 و ISO 22000 و HACCP وشهادات صحية متعلقة بالمنتجات الغذائية والزراعية. جميع المنتجات تتوافق مع المعايير الدولية. ✅',
                        'keywords' => ['شهادة', 'معيار', 'أيزو', 'جودة'],
                    ],
                ],
            ],

            /* =========================================================
               ۱۸. درخواست قیمت
            ========================================================= */
            [
                'slug'     => 'request-quote',
                'priority' => 69,
                'translations' => [
                    'fa' => [
                        'question' => 'می‌خواهم قیمت دریافت کنم',
                        'answer'   => 'برای دریافت قیمت دقیق، لطفاً نام محصول، مقدار مورد نیاز، مقصد و زمان تحویل را اعلام کنید. کارشناسان ما در اسرع وقت با شما تماس می‌گیرند. 📩',
                        'keywords' => ['قیمت', 'استعلام', 'نرخ', 'چند', 'هزینه'],
                    ],
                    'en' => [
                        'question' => 'I would like to get a quote',
                        'answer'   => 'To receive an accurate quote, please provide the product name, required quantity, destination, and delivery time. Our experts will contact you shortly. 📩',
                        'keywords' => ['quote', 'price', 'cost', 'inquiry', 'how much'],
                    ],
                    'ar' => [
                        'question' => 'أريد الحصول على عرض سعر',
                        'answer'   => 'للحصول على عرض سعر دقيق، يرجى تقديم اسم المنتج والكمية المطلوبة والوجهة ووقت التسليم. سيتصل بك خبراؤنا قريباً. 📩',
                        'keywords' => ['سعر', 'عرض سعر', 'استفسار', 'كم'],
                    ],
                ],
            ],

        ];

        foreach ($faqs as $data) {
            $faq = Faq::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'is_active'  => true,
                    'sort_order' => $data['priority'],
                ]
            );

            foreach ($data['translations'] as $locale => $translation) {
                FaqTranslation::updateOrCreate(
                    ['faq_id' => $faq->id, 'locale' => $locale],
                    [
                        'question' => $translation['question'],
                        'answer'   => $translation['answer'],
                        'keywords' => $translation['keywords'],
                    ]
                );
            }
        }
    }
}
