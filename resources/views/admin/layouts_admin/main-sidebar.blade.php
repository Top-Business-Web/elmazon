<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="#">
            <img src="{{ asset('assets/admin/images/logo-mazon.png') }}" class="header-brand-img desktop-logo"
                alt="logo">
            <img src="{{ asset('assets/admin/images/logo-mazon.png') }}" class="header-brand-img toggle-logo"
                alt="logo">
            <img src="{{ asset('assets/admin/images/logo-mazon.png') }}" class="header-brand-img light-logo"
                alt="logo">
            <img src="{{ asset('assets/admin/images/logo-mazon.png') }}" class="header-brand-img light-logo1"
                alt="logo">
        </a>
        <!-- LOGO -->
    </div>
    <ul class="side-menu">
        <li>
            <h3>Elements</h3>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{ route('seasons.index') }}">
                <i class="fa fa-save side-menu__icon"></i>
                <span class="side-menu__label">الصفوف الدراسيه</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="{{ route('subjectsClasses.index') }}">
                <i class="fa fa-book-reader side-menu__icon"></i>
                <span class="side-menu__label">الوحدات</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="{{ route('terms.index') }}">
                <i class="fa fa-list-ol side-menu__icon"></i>
                <span class="side-menu__label">الترم</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="{{ route('lessons.index') }}">
                <i class="fe fe-book side-menu__icon"></i>
                <span class="side-menu__label">الدروس</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="{{ route('users.index') }}">
                <i class="icon icon-screen-users side-menu__icon"></i>
                <span class="side-menu__label">الطلاب</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="{{ route('notifications.index') }}">
                <i class="icon icon-bell side-menu__icon"></i>
                <span class="side-menu__label">الاشعارات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('videosParts.index') }}">
                <i class="icon icon-control-play side-menu__icon"></i>
                <span class="side-menu__label">اقسام الفيديوهات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('monthlyPlans.index') }}">
                <i class="icon icon-calendar side-menu__icon"></i>
                <span class="side-menu__label">الخطة الشهرية</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('suggestions.index') }}">
                <i class="fe fe-message-circle side-menu__icon"></i>
                <span class="side-menu__label">الاقتراحات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('onlineExam.index') }}">
                <i class="fa fa-scroll side-menu__icon"></i>
                <span class="side-menu__label">امتحانات الاونلاين</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('lifeExam.index') }}">
                <i class="fa fa-headset side-menu__icon"></i>
                <span class="side-menu__label">امتحانات اللايف</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('papelSheetExam.index') }}">
                <i class="fa fa-paper-plane side-menu__icon"></i>
                <span class="side-menu__label">امتحانات الورقية</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('allExam.index') }}">
                <i class="fa fa-scroll side-menu__icon"></i>
                <span class="side-menu__label">كل الامتحانات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('phoneCommunications.index') }}">
                <i class="icon icon-phone side-menu__icon"></i>
                <span class="side-menu__label">الاتصالات الهاتفية</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('onBoarding.index') }}">
                <i class="fa fa-images side-menu__icon"></i>
                <span class="side-menu__label">الشاشات الافتتاحيه</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('slider.index') }}">
                <i class="fa fa-images side-menu__icon"></i>
                <span class="side-menu__label">سلايدر</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('section.index') }}">
                <i class="fa fa-place-of-worship side-menu__icon"></i>
                <span class="side-menu__label">القاعات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('setting.index') }}">
                <i class="fa fa-wrench side-menu__icon"></i>
                <span class="side-menu__label">الاعدادات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('guide.index') }}">
                <i class="icon icon-note side-menu__icon"></i>
                <span class="side-menu__label">الدليل</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="{{ route('pdf.index') }}">
                <i class="fa fa-file-pdf side-menu__icon"></i>
                <span class="side-menu__label">ملفات ورقية</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('questions.index') }}">
                <i class="icon icon-question side-menu__icon"></i>
                <span class="side-menu__label">بنك الأسئلة</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="{{ route('subscribe.index') }}">
                <i class="fa fa-box side-menu__icon"></i>
                <span class="side-menu__label">الباقات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('countries.index') }}">
                <i class="fa fa-globe side-menu__icon"></i>
                <span class="side-menu__label">المدن</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('comment.index') }}">
                <i class="fa fa-comments side-menu__icon"></i>
                <span class="side-menu__label">التعليقات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('ads.index') }}">
                <i class="fa fa-ad side-menu__icon"></i>
                <span class="side-menu__label">الاعلانات</span>
            </a>
        </li>

{{--        <li class="slide">--}}
{{--            <a class="side-menu__item" href="{{ route('contactUs.index') }}">--}}
{{--                <i class="fa fa-globe side-menu__icon"></i>--}}
{{--                <span class="side-menu__label">تواصل معنا</span>--}}
{{--            </a>--}}
{{--        </li>--}}


    </ul>
</aside>
