<!-- Sidebar -->
<div class="site-overlay"></div>
<div class="site-sidebar">
    <div class="custom-scroll custom-scroll-light">
        <ul class="sidebar-menu">
            {!! dgg_menu('admin')  !!}
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-settings"></i></span>
                    <span class="s-text">Cài đặt</span>
                </a>
                <ul style="display: none;">
                    <li><a href="{{ route('sliders.index') }}">Slider</a></li>
                    <li><a href="utilities-color.html">Color utilities</a></li>
                    <li><a href="utilities-other.html">Other utilities</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
