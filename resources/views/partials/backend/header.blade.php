
<header class="header">
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
            <a href="index.html" class="logo">Triple E Gourmet Catering Services</a>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-6">
            <!-- Header actions start -->
            <ul class="header-actions">
                <li class="dropdown d-none d-sm-block">
                    <a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
                        <img src="{{ asset('assets/img/notification.svg') }}" alt="notifications" class="list-icon" />
                    </a>
                    <div class="dropdown-menu lrg" aria-labelledby="notifications">
                        <div class="dropdown-menu-header">
                            <h5>Notifications</h5>
                            <p class="m-0 sub-title">You have 5 unread notifications</p>
                        </div>	
                        <ul class="header-notifications">
                            <li>
                                <a href="#" class="clearfix">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/img/user.png') }}" alt="avatar" />
                                        <span class="notify-iocn icon-drafts text-danger"></span>
                                    </div>
                                    <div class="details">
                                        <h6>Corey Haggard</h6>
                                        <p>This is so good, I can't stop watching.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="clearfix">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/img/user2.png') }}" alt="avatar" />
                                        <span class="notify-iocn icon-layers text-info"></span>
                                    </div>
                                    <div class="details">
                                        <h6>Eric R. Mortensen</h6>
                                        <p>Eric sent you a file. Download now</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="clearfix">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/img/user3.png') }}" alt="avatar" />
                                        <span class="notify-iocn icon-person_add text-success"></span>
                                    </div>
                                    <div class="details">
                                        <h6>Gleb Kuznetsov</h6>
                                        <p>Stella, Added you as a Friend. Accept.</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @auth
                <li class="dropdown">
                    <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="avatar">NJ<span class="status busy"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                        <div class="header-profile-actions">
                            <div class="header-user-profile">
                                <div class="header-user">
                                    <img src="{{ asset('assets/img/user.png') }}" alt="Reatil Admin" />
                                </div>
                                <h5>{{ auth()->user()->name }}</h5>
                                <p>Balance - $35,000</p>
                            </div>
                            <a href="user-profile.html"><i class="icon-user1"></i> My Profile</a>
                            <a href="pricing.html"><i class="icon-settings1"></i> Account Settings</a>
                            <a href="tasks.html"><i class="icon-activity"></i> Activity Logs</a>
                            <a href="{{ route('logout') }}" 
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" >
                                <i class="icon-log-out1"></i> 
                                Sign Out
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
                @endauth
            </ul>						
            <!-- Header actions end -->
        </div>
    </div>
    <!-- Row end -->
</header>