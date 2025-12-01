<?php
if (!isset($_SESSION['skipit_id'])) {
	header("Location: " . HOME_URI . "/login");
}
$url = $_GET['url'];
$url = explode('/', $url);
$page = $url[0];
$param = $url[1];
$param2 = $url[2];
?>
<div id="menuslaterais" class="hp-sidebar hp-bg-color-black-20 hp-bg-color-dark-90 border-end border-black-40 hp-border-color-dark-80">
    <div class="hp-sidebar-container">
        <div class="hp-sidebar-header-menu">
            <div class="row justify-content-between align-items-end mx-0">
                <div class="w-auto px-0 hp-sidebar-collapse-button hp-sidebar-visible">
                    <div class="hp-cursor-pointer">
                        <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.91102 1.73796L0.868979 4.78L0 3.91102L3.91102 0L7.82204 3.91102L6.95306 4.78L3.91102 1.73796Z" fill="#B2BEC3"></path>
                            <path d="M3.91125 12.0433L6.95329 9.00125L7.82227 9.87023L3.91125 13.7812L0.000224113 9.87023L0.869203 9.00125L3.91125 12.0433Z" fill="#B2BEC3"></path>
                        </svg>
                    </div>
                </div>

                <div class="w-auto px-0">
                    <div class="hp-header-logo d-flex align-items-center">
                        <a href="<?php echo HOME_URI ?>/dashboard" class="position-relative">
                    

                        <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-white.png" alt="logo">
                        <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-dark.png" alt="logo">
                            
                        </a>
                    </div>
                </div>

                <!-- <div class="w-auto px-0 hp-sidebar-collapse-button hp-sidebar-hidden">
                    <div class="hp-cursor-pointer mb-4">
                        <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.91102 1.73796L0.868979 4.78L0 3.91102L3.91102 0L7.82204 3.91102L6.95306 4.78L3.91102 1.73796Z" fill="#B2BEC3"></path>
                            <path d="M3.91125 12.0433L6.95329 9.00125L7.82227 9.87023L3.91125 13.7812L0.000224113 9.87023L0.869203 9.00125L3.91125 12.0433Z" fill="#B2BEC3"></path>
                        </svg>
                    </div>
                </div> -->
            </div>

            <?php require 'views/_include/menu.php'; ?>
        </div>

        <!-- <div class="row justify-content-between align-items-center hp-sidebar-footer mx-0 hp-bg-color-dark-90">
            <div class="divider border-black-40 hp-border-color-dark-70 hp-sidebar-hidden mt-0 px-0"></div>

            <div class="col">
                <div class="row align-items-center">
                    <div class="w-auto px-0">
                        <div class="avatar-item bg-primary-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px;">
                            <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-8.png" height="100%" class="hp-img-cover">
                        </div>
                    </div>

                    <div class="w-auto ms-8 px-0 hp-sidebar-hidden mt-4">
                        <span class="d-block hp-text-color-black-100 hp-text-color-dark-0 hp-p1-body lh-1">Jane Doe</span>
                        <a href="profile-information.html" class="hp-badge-text fw-normal hp-text-color-dark-30">View Profile</a>
                    </div>
                </div>
            </div>

            <div class="col hp-flex-none w-auto px-0 hp-sidebar-hidden">
                <a href="profile-information.html">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="remix-icon hp-text-color-black-100 hp-text-color-dark-0" height="24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M3.34 17a10.018 10.018 0 0 1-.978-2.326 3 3 0 0 0 .002-5.347A9.99 9.99 0 0 1 4.865 4.99a3 3 0 0 0 4.631-2.674 9.99 9.99 0 0 1 5.007.002 3 3 0 0 0 4.632 2.672c.579.59 1.093 1.261 1.525 2.01.433.749.757 1.53.978 2.326a3 3 0 0 0-.002 5.347 9.99 9.99 0 0 1-2.501 4.337 3 3 0 0 0-4.631 2.674 9.99 9.99 0 0 1-5.007-.002 3 3 0 0 0-4.632-2.672A10.018 10.018 0 0 1 3.34 17zm5.66.196a4.993 4.993 0 0 1 2.25 2.77c.499.047 1 .048 1.499.001A4.993 4.993 0 0 1 15 17.197a4.993 4.993 0 0 1 3.525-.565c.29-.408.54-.843.748-1.298A4.993 4.993 0 0 1 18 12c0-1.26.47-2.437 1.273-3.334a8.126 8.126 0 0 0-.75-1.298A4.993 4.993 0 0 1 15 6.804a4.993 4.993 0 0 1-2.25-2.77c-.499-.047-1-.048-1.499-.001A4.993 4.993 0 0 1 9 6.803a4.993 4.993 0 0 1-3.525.565 7.99 7.99 0 0 0-.748 1.298A4.993 4.993 0 0 1 6 12c0 1.26-.47 2.437-1.273 3.334a8.126 8.126 0 0 0 .75 1.298A4.993 4.993 0 0 1 9 17.196zM12 15a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
                        </g>
                    </svg>
                </a>
            </div>
        </div> -->
    </div>
</div>

<div class="hp-main-layout">
    <header>
        <div class="row w-100 m-0">
            <div class="col px-0">
                <div class="row w-100 align-items-center justify-content-between position-relative">
                    <div class="col w-auto hp-flex-none hp-mobile-sidebar-button me-24 px-0" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                        <button type="button" class="btn btn-text btn-icon-only">
                            <i class="ri-menu-fill hp-text-color-black-80 hp-text-color-dark-30 lh-1 lorden"></i>
                        </button>
                    </div>

                    <div class="hp-horizontal-logo-menu d-flex align-items-center w-auto">
                        <div class="col hp-flex-none w-auto hp-horizontal-block">
                            <div class="hp-header-logo d-flex align-items-center">
                            <a href="<?php echo HOME_URI ?>/dashboard" class="position-relative">


                            <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-white.png" alt="logo">
                            <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-dark.png" alt="logo">
                                
                            </a>
                            </div>
                        </div>

                        <div class="col hp-flex-none w-auto hp-horizontal-block hp-horizontal-menu ps-24">
                        <?php require 'views/_include/menu.php'; ?>
                        </div>
                    </div>

                    <div class="col hp-flex-none w-auto pe-0">
                        <div class="row align-items-center justify-content-end">

                            <div class="me-2 hp-basket-dropdown-button w-auto px-0 position-relative">
                                <button type="button" class="btn btn-icon-only bg-transparent border-0 hp-hover-bg-black-10 hp-hover-bg-dark-100 hp-transition d-flex align-items-center justify-content-center munt hp-theme-customizer-container-body-item-svg" data-theme="light">
                                <i class="hp-text-color-dark-0 ri-2x ri-moon-line"></i>
                                </button>

                            </div>
                            
                            <div class="me-2 hp-basket-dropdown-button w-auto px-0 position-relative">
                                <button type="button" class="btn btn-icon-only bg-transparent border-0 hp-hover-bg-black-10 hp-hover-bg-dark-100 hp-transition d-flex align-items-center justify-content-center munt hp-theme-customizer-container-body-item-svg" data-theme="dark">
                                <i class="hp-text-color-dark-0 ri-2x ri-moon-fill"></i>
                                </button>

                            </div>
                            <div class="hover-dropdown-fade w-auto px-0 ms-6 position-relative">
                                <div id="imguser" class="hp-cursor-pointer rounded-4 border hp-border-color-dark-80">
                                    <div class="rounded-3 overflow-hidden m-4 d-flex">
                                        <div class="avatar-item hp-bg-info-4 d-flex bndes">
                                        <img :src="'<?php echo AVATAR ?>/'+listalldata" onerror="this.src='<?php echo AVATAR ?>/placeholder.png';">
                                        
                                        </div>
                                    </div>
                                </div>

                                <div class="hp-header-profile-menu dropdown-fade position-absolute pt-18 nemusa">
                                    <div class="rounded hp-bg-black-0 hp-bg-dark-100 px-18 py-24 text-center">
                                        

                                        <a href="<?php echo HOME_URI ?>/perfil" class="hp-p1-body fw-medium hp-hover-text-color-primary-2">Ver Perfil</a>

                                        <div class="divider mt-18 mb-16"></div>

                                        <div class="row">
                                            
                                            <div class="col-12 mt-24">
                                                <a class="hp-p1-body fw-medium" href="<?php echo HOME_URI ?>/login">Sair</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="nomelogado" class="me-2 hp-basket-dropdown-button w-auto px-6 position-relative">
                                <span class="hp-p1-body mb-0 text-black-80 hp-text-color-dark-30">Olá, {{nome_logado}}</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="offcanvas offcanvas-start hp-mobile-sidebar bg-black-20 hp-bg-dark-90 blobers" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header justify-content-between align-items-center ms-16 me-8 mt-16 p-0">
            <div class="w-auto px-0">
                <div class="hp-header-logo d-flex align-items-center">
                <a href="<?php echo HOME_URI ?>/dashboard" class="position-relative">
                    

                <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-white.png" alt="logo">
                <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-dark.png" alt="logo">
                    
                </a>
                </div>
            </div>

            <div class="w-auto px-0 hp-sidebar-collapse-button hp-sidebar-hidden" data-bs-dismiss="offcanvas" aria-label="Close">
                <button type="button" class="btn btn-text btn-icon-only bg-transparent">
                    <i class="ri-close-fill lh-1 hp-text-color-black-80 lorden"></i>
                </button>
            </div>
        </div>

                <div class="hp-sidebar hp-bg-color-black-20 hp-bg-color-dark-90 border-end border-black-40 hp-border-color-dark-80">
                    <div class="hp-sidebar-container">
                        <div class="hp-sidebar-header-menu">
                            <div class="row justify-content-between align-items-end mx-0">
                                <div class="w-auto px-0 hp-sidebar-collapse-button hp-sidebar-visible">
                                    <div class="hp-cursor-pointer">
                                        <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.91102 1.73796L0.868979 4.78L0 3.91102L3.91102 0L7.82204 3.91102L6.95306 4.78L3.91102 1.73796Z" fill="#B2BEC3"></path>
                                            <path d="M3.91125 12.0433L6.95329 9.00125L7.82227 9.87023L3.91125 13.7812L0.000224113 9.87023L0.869203 9.00125L3.91125 12.0433Z" fill="#B2BEC3"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="w-auto px-0">
                                    <div class="hp-header-logo d-flex align-items-center">
                                        <a href="<?php echo HOME_URI ?>/dashboard" class="position-relative">
                                    

                                        <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-white.png" alt="logo">
                                        <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/logo-com-dark.png" alt="logo">
                                            
                                        </a>
                                    </div>
                                </div>

                                <div class="w-auto px-0 hp-sidebar-collapse-button hp-sidebar-hidden">
                                    <div class="hp-cursor-pointer mb-4">
                                        <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.91102 1.73796L0.868979 4.78L0 3.91102L3.91102 0L7.82204 3.91102L6.95306 4.78L3.91102 1.73796Z" fill="#B2BEC3"></path>
                                            <path d="M3.91125 12.0433L6.95329 9.00125L7.82227 9.87023L3.91125 13.7812L0.000224113 9.87023L0.869203 9.00125L3.91125 12.0433Z" fill="#B2BEC3"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <?php require 'views/_include/menucelular.php'; ?>
                        </div>
                    </div>
                </div>
    </div>