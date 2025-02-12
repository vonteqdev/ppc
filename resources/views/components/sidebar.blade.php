<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ url('dashboard-default') }}">
            <img src="{{ URL::asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-3 font-weight-bold">Vonteq</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                @impersonating()
                    <li class="nav-item text-center">
                        <a href="{{ route('users.stop-impersonate') }}" class="btn btn-warning btn-sm">Stop Impersonating</a>
                    </li>
                @endImpersonating
                <x-sidebar.general-management />
                @role('admin')
                <x-sidebar.admin-menu />
                @endrole
                <x-sidebar.products-management />
                <x-sidebar.performance />
                <x-sidebar.feed-management />
                <x-sidebar.account-management />


                <!-- ✅ GENERAL MANAGEMENT -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="ni ni-tv-2 text-primary"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('quick-insights.index') }}">
                        <i class="ni ni-bulb-61 text-info"></i>
                        <span class="nav-link-text">Quick Insights</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('budget-monitoring') }}">
                        <i class="ni ni-money-coins text-success"></i>
                        <span class="nav-link-text">Budget Monitoring</span>
                    </a>
                </li>

                <!-- ✅ PERFORMANCE REPORTS -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#performanceMenu">
                        <i class="ni ni-chart-bar-32 text-warning"></i>
                        <span class="nav-link-text">Performance Reports</span>
                    </a>
                    <ul id="performanceMenu" class="collapse">
                        <li class="nav-item"><a class="nav-link" href="{{ route('performance.google-ads') }}">Google Ads</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('performance.meta-ads') }}">Meta Ads</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('performance.tiktok-ads') }}">TikTok Ads</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('performance.ga4') }}">Google Analytics (GA4)</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('performance.gsc') }}">Google Search Console (GSC)</a></li>
                    </ul>
                </li>

                <!-- ✅ FEED MANAGEMENT -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#feedManagementMenu">
                        <i class="ni ni-folder-17 text-danger"></i>
                        <span class="nav-link-text">Feed Management</span>
                    </a>
                    <ul id="feedManagementMenu" class="collapse">
                        <li class="nav-item"><a class="nav-link" href="{{ route('feed-management.index') }}">Import Feeds</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('feed-management.export-options') }}">Export Feeds</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('feed-management.labeling-dashboard') }}">Product Labeling</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('product-labels.index') }}">
                                <i class="ni ni-tag text-primary"></i>
                                <span class="nav-link-text">Product Labels</span>
                            </a>
                        </li>



                    </ul>
                </li>

                <!-- ✅ PPC INSIGHTS & REPORTS -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ppc-insights.index') }}">
                        <i class="ni ni-chart-pie-35 text-primary"></i>
                        <span class="nav-link-text">PPC Insights</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('reports.index') }}">
                        <i class="ni ni-single-copy-04 text-secondary"></i>
                        <span class="nav-link-text">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('reports.label-performance') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Report Label Performance</span>
                    </a>
                </li>

                <!-- ✅ USER & ROLE MANAGEMENT -->
                @role('admin')
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#adminManagement">
                            <i class="ni ni-single-02 text-dark"></i>
                            <span class="nav-link-text">User & Role Management</span>
                        </a>
                        <ul id="adminManagement" class="collapse">
                            <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">Roles</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('permissions.index') }}">Permissions</a></li>
                        </ul>
                    </li>
                @endrole

                <!-- ✅ SYSTEM SETUP & API INTEGRATIONS -->
                @role('admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('setup.index') }}">
                            <i class="ni ni-settings-gear-65 text-success"></i>
                            <span class="nav-link-text">System Setup</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </div>
        <div class="sidenav-footer mx-3 mt-3 pt-3">
            <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
                <div class="full-background" style="background-image: url('assets/img/curved-images/white-curved.jpeg')"></div>
                <div class="card-body text-start p-3 w-100">
                    <div class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                        <i class="ni ni-diamond text-dark text-gradient text-lg top-0" aria-hidden="true" id="sidenavCardIcon"></i>
                    </div>
                    <div class="docs-info">
                    <h6 class="text-white up mb-0">Ai nevoie de ajutor?</h6>
                        <p class="text-xs font-weight-bold">Please check our docs</p>
                        <a href="/documentation/getting-started/overview.html" target="_blank" class="btn btn-white btn-sm w-100 mb-0">Documentation</a>
                    </div>
                </div>
            </div>
        </div>
</aside>
