<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="#">
            <img src="" class="header-brand-img desktop-logo" alt="logo">
            <img src="" class="header-brand-img toggle-logo" alt="logo">
            <img src="" class="header-brand-img light-logo" alt="logo">
            <img src="" class="header-brand-img light-logo1" alt="logo">
        </a>
        <!-- LOGO -->
    </div>
    <ul class="side-menu">
        <li><h3>Elements</h3></li>
        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="icon icon-home side-menu__icon"></i>
                <span class="side-menu__label">الصفوف الدراسيه</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="icon icon-home side-menu__icon"></i>
                <span class="side-menu__label">المواد</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="{{ route('seasons.index') }}">
                <i class="fe fe-git-commit side-menu__icon"></i>
                <span class="side-menu__label">{{ trans('admin.seasons') }}</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('terms.index') }}">
                <i class="fe fe-git-commit side-menu__icon"></i>
                <span class="side-menu__label">{{ trans('admin.terms') }}</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-git-commit side-menu__icon"></i>
                <span class="side-menu__label">الدروس</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-git-commit side-menu__icon"></i>
                <span class="side-menu__label">محاضرات الدروس</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-zap side-menu__icon"></i>
                <span class="side-menu__label">اكواد الطلاب</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-zap side-menu__icon"></i>
                <span class="side-menu__label">الطلاب</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-users side-menu__icon"></i>
                <span class="side-menu__label">قسم قاعات الامتحانات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="icon icon-menu side-menu__icon"></i>
                <span class="side-menu__label">تنبيهات الامتحانات الورقيه</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="icon icon-handbag side-menu__icon"></i>
                <span class="side-menu__label">الاشعارات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="ti-face-smile side-menu__icon"></i>
                <span class="side-menu__label">ارقام التواصل</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-watch side-menu__icon"></i>
                <span class="side-menu__label">الاعدادات</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-arrow-down-left side-menu__icon"></i>
                <span class="side-menu__label">الاعلانات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-tag side-menu__icon"></i>
                <span class="side-menu__label">فيديوهات المحاضرات</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="{{ route('countries.index') }}">
                <i class="fe fe-tag side-menu__icon"></i>
                <span class="side-menu__label">{{ trans('admin.countries') }}</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-paperclip side-menu__icon"></i>
                <span class="side-menu__label">Corporations</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-calendar side-menu__icon"></i>
                <span class="side-menu__label">Days Capacity</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-users side-menu__icon"></i>
                <span class="side-menu__label">Clients</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="fe fe-hash side-menu__icon"></i>
                <span class="side-menu__label">Offers</span><i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                <li><a href="#" class="slide-item">Show Offers</a></li>
                <li><a href="#" class="slide-item">Offers Items</a></li>
            </ul>
        </li>


        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="fe fe-user-plus side-menu__icon"></i>
                <span class="side-menu__label">Employees</span><i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                <li><a href="#" class="slide-item" style="font-size: 14px">Employees List</a>
                </li>
                <li><a href="#" class="slide-item" style="font-size: 14px">Roles</a></li>
            </ul>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-mail side-menu__icon"></i>
                <span class="side-menu__label">Contact Us
                    <span id="contact-span">

                    </span>
                </span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-settings side-menu__icon"></i>
                <span class="side-menu__label">Setting</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-camera side-menu__icon"></i>
                <span class="side-menu__label">Sliders</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-camera side-menu__icon"></i>
                <span class="side-menu__label">Prices & Opening hours</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-camera side-menu__icon"></i>
                <span class="side-menu__label">Obstacle Courses</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="#">
                <i class="fe fe-info side-menu__icon"></i>
                <span class="side-menu__label">About Page</span>
            </a>
        </li>


        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="fe fe-file-text side-menu__icon"></i>
                <span class="side-menu__label">جزء الامتحانات</span><i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                <li><a href="#" class="slide-item">امتحان شامل علي الفصل</a></li>
                <li><a href="#" class="slide-item">امتحان شامل جميع الفصول</a></li>
                <li><a href="#" class="slide-item">امتحان جزئي</a></li>
                <li><a href="#" class="slide-item">اختبار</a></li>

            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="fe fe-file-text side-menu__icon"></i>
                <span class="side-menu__label">جزء الارشادات</span><i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                <li><a href="#" class="slide-item">ارشادات الامتحانات</a></li>

            </ul>
        </li>


    </ul>
</aside>
