<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <span class="simple-text logo-normal">
            Project
        </span>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'home' ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>Home</p>
                </a>
            </li>
        </ul>
    </div>
</div>
