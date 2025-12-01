<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Geral | <?php echo TITLE; ?></title>
 
  <?php require_once 'views/_include/head.php'; ?>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    

    <body>


<main class="hp-bg-color-dark-90 d-flex min-vh-100">
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
                        

                                <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logoapp_oficial.png" alt="logo">
                                <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/app5mclaro.png" alt="logo">
                                
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

                <?php require 'views/_include/menu.php'; ?>
            </div>

            <!-- <div class="row justify-content-between align-items-center hp-sidebar-footer mx-0 hp-bg-color-dark-90">
                <div class="divider border-black-40 hp-border-color-dark-70 hp-sidebar-hidden mt-0 px-0"></div>

                <div class="col">
                    <div class="row align-items-center">
                        <div class="w-auto px-0">
                            <div class="avatar-item bg-primary-4 d-flex align-items-center justify-content-center rounded-circle temi">
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

                        <!-- <div class="hp-header-text-info col col-lg-14 col-xl-16 hp-header-start-text d-flex align-items-center hp-horizontal-none">
                            <div class="d-flex overflow-hidden rounded-4 hp-bg-color-black-0 hp-bg-color-dark-100 playon">
                                <img class="rideon" src="https://yoda.hypeople.studio/yoda-admin-template/app-assets/img/memoji/newspaper.svg" alt="Newspaper" height="80%">
                            </div>

                            <p class="hp-header-start-text-item hp-input-label fw-normal hp-text-color-black-100 hp-text-color-dark-0 ms-12 mb-0 lh-1 d-flex align-items-center">
                                Do you know the latest update of 2022?&nbsp;&nbsp;
                                <span class="hp-text-color-primary-1">Our roadmap is alive for future updates.</span>
                            </p>
                        </div> -->

                        <div class="hp-horizontal-logo-menu d-flex align-items-center w-auto">
                            <div class="col hp-flex-none w-auto hp-horizontal-block">
                                <div class="hp-header-logo d-flex align-items-center">
                                <a href="<?php echo HOME_URI ?>/dashboard" class="position-relative">
                        

                                    <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logoapp_oficial.png" alt="logo">
                                    <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/app5mclaro.png" alt="logo">
                                    
                                </a>
                                </div>
                            </div>

                            <div class="col hp-flex-none w-auto hp-horizontal-block hp-horizontal-menu ps-24">
                            <?php require 'views/_include/menu.php'; ?>
                            </div>
                        </div>

                        <div class="hp-header-search d-none col">
                            <input type="text" class="form-control" placeholder="Search..." id="header-search" autocomplete="off">
                        </div>

                        <div class="col hp-flex-none w-auto pe-0">
                            <div class="row align-items-center justify-content-end">
                                <div class="w-auto px-0">
                                    <div class="d-flex align-items-center me-4 hp-header-search-button">
                                        <button type="button" class="btn btn-icon-only bg-transparent border-0 hp-hover-bg-black-10 hp-hover-bg-dark-100 hp-transition d-flex align-items-center justify-content-center munt">
                                            <svg class="hp-header-search-button-icon-1 hp-text-color-black-80 hp-text-color-dark-30" set="curved" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.5 21a9.5 9.5 0 1 0 0-19 9.5 9.5 0 0 0 0 19ZM22 22l-2-2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <i class="d-none hp-header-search-button-icon-2 ri-close-line hp-text-color-black-60 lorden"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="hover-dropdown-fade w-auto px-0 d-flex align-items-center position-relative">
                                    <button type="button" class="btn btn-icon-only bg-transparent border-0 hp-hover-bg-black-10 hp-hover-bg-dark-100 hp-transition d-flex align-items-center justify-content-center munt">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" class="hp-text-color-black-80 hp-text-color-dark-30">
                                            <path d="M12 6.44v3.33M12.02 2C8.34 2 5.36 4.98 5.36 8.66v2.1c0 .68-.28 1.7-.63 2.28l-1.27 2.12c-.78 1.31-.24 2.77 1.2 3.25a23.34 23.34 0 0 0 14.73 0 2.22 2.22 0 0 0 1.2-3.25l-1.27-2.12c-.35-.58-.63-1.61-.63-2.28v-2.1C18.68 5 15.68 2 12.02 2Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"></path>
                                            <path d="M15.33 18.82c0 1.83-1.5 3.33-3.33 3.33-.91 0-1.75-.38-2.35-.98-.6-.6-.98-1.44-.98-2.35" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        </svg>
                                        <span class="position-absolute translate-middle p-2 rounded-circle bg-primary hp-notification-circle devo"></span>
                                    </button>

                                    <div class="hp-notification-menu dropdown-fade position-absolute pt-18 finder">
                                        <div class="p-24 rounded hp-bg-black-0 hp-bg-dark-100">
                                            <div class="row justify-content-between align-items-center mb-16">
                                                <div class="col hp-flex-none w-auto h5 hp-text-color-black-100 hp-text-color-dark-10 hp-text-color-dark-0 me-64 mb-0">Notifications</div>

                                                <div class="col hp-flex-none w-auto hp-badge-text fw-medium hp-text-color-black-80 me-12 px-0">4 New</div>
                                            </div>

                                            <div class="divider my-4"></div>

                                            <div class="hp-overflow-y-auto px-10 fibras">
                                                <div class="row hp-cursor-pointer rounded hp-transition hp-hover-bg-primary-4 hp-hover-bg-dark-80 py-12 px-10 teju">
                                                    <div class="w-auto px-0 me-12">
                                                        <div class="avatar-item d-flex align-items-center justify-content-center rounded-circle temi">
                                                            <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-1.png" class="w-100">
                                                        </div>
                                                    </div>

                                                    <div class="w-auto px-0 col">
                                                        <p class="d-block fw-medium hp-p1-body hp-text-color-black-100 hp-text-color-dark-0 mb-4">
                                                            Debi Cakar
                                                            <span class="hp-text-color-black-60">commented on</span>
                                                            Ecosystem and conservation
                                                        </p>

                                                        <span class="d-block hp-badge-text fw-medium hp-text-color-black-60 hp-text-color-dark-40">1m ago</span>
                                                    </div>
                                                </div>

                                                <div class="row hp-cursor-pointer rounded hp-transition hp-hover-bg-primary-4 hp-hover-bg-dark-80 py-12 px-10 teju">
                                                    <div class="w-auto px-0 me-12">
                                                        <div class="avatar-item d-flex align-items-center justify-content-center rounded-circle temi">
                                                            <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-2.png" class="w-100">
                                                        </div>
                                                    </div>

                                                    <div class="w-auto px-0 col">
                                                        <p class="d-block fw-medium hp-p1-body hp-text-color-black-100 hp-text-color-dark-0 mb-4">
                                                            Edward Adams <span class="hp-text-color-black-60">invite you</span> to Prototyping
                                                        </p>

                                                        <span class="d-block hp-badge-text fw-medium hp-text-color-black-60 hp-text-color-dark-40">9h ago</span>
                                                    </div>
                                                </div>

                                                <div class="row hp-cursor-pointer rounded hp-transition hp-hover-bg-primary-4 hp-hover-bg-dark-80 py-12 px-10 teju">
                                                    <div class="w-auto px-0 me-12">
                                                        <div class="avatar-item d-flex align-items-center justify-content-center rounded-circle temi">
                                                            <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-3.png" class="w-100">
                                                        </div>
                                                    </div>

                                                    <div class="w-auto px-0 col">
                                                        <p class="d-block fw-medium hp-p1-body hp-text-color-black-100 hp-text-color-dark-0 mb-4">
                                                            Richard Charles <span class="hp-text-color-black-60">mentioned you in</span> UX Basics Field
                                                        </p>

                                                        <span class="d-block hp-badge-text fw-medium hp-text-color-black-60 hp-text-color-dark-40">13h ago</span>
                                                    </div>
                                                </div>

                                                <div class="row hp-cursor-pointer rounded hp-transition hp-hover-bg-primary-4 hp-hover-bg-dark-80 py-12 px-10 teju">
                                                    <div class="w-auto px-0 me-12">
                                                        <div class="avatar-item hp-bg-dark-success bg-success-4 d-flex align-items-center justify-content-center rounded-circle temi">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="hp-text-color-success-1">
                                                                <path d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10 10-4.49 10-10S17.51 2 12 2Zm4.78 7.7-5.67 5.67a.75.75 0 0 1-1.06 0l-2.83-2.83a.754.754 0 0 1 0-1.06c.29-.29.77-.29 1.06 0l2.3 2.3 5.14-5.14c.29-.29.77-.29 1.06 0 .29.29.29.76 0 1.06Z" fill="currentColor"></path>
                                                            </svg>
                                                        </div>
                                                    </div>

                                                    <div class="w-auto px-0 col">
                                                        <p class="d-block fw-medium hp-p1-body hp-text-color-black-100 hp-text-color-dark-0 mb-4">
                                                            <span class="hp-text-color-black-60">You swapped exactly</span>
                                                            0.230000 ETH <span class="hp-text-color-black-60">for</span> 28,031.99
                                                        </p>

                                                        <span class="d-block hp-badge-text fw-medium hp-text-color-black-60 hp-text-color-dark-40">17h ago</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="me-2 hp-basket-dropdown-button w-auto px-0 position-relative">
                                    <button type="button" class="btn btn-icon-only bg-transparent border-0 hp-hover-bg-black-10 hp-hover-bg-dark-100 hp-transition d-flex align-items-center justify-content-center munt">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" class="hp-text-color-black-80 hp-text-color-dark-30">
                                            <path d="M8.4 6.5h7.2c3.4 0 3.74 1.59 3.97 3.53l.9 7.5C20.76 19.99 20 22 16.5 22H7.51C4 22 3.24 19.99 3.54 17.53l.9-7.5C4.66 8.09 5 6.5 8.4 6.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M8 8V4.5C8 3 9 2 10.5 2h3C15 2 16 3 16 4.5V8M20.41 17.03H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>

                                    <div class="hp-basket-dropdown">
                                        <div class="row px-0 justify-content-between align-items-center">
                                            <h5 class="mb-0 w-auto hp-text-color-dark-15">My Cart</h5>

                                            <div class="w-auto px-0 me-8">
                                                <span class="d-inline-block hp-caption fw-medium w-auto hp-text-color-black-80 hp-text-color-dark-30">1 Item</span>
                                            </div>
                                        </div>

                                        <div class="divider mt-24 mb-4"></div>

                                        <div class="hp-basket-dropdown-list">
                                            <div class="hp-d-block hp-transition hp-hover-bg-primary-4 hp-hover-bg-dark-primary hp-hover-bg-dark-80 rounded py-8 px-10 hp-overflow-x-auto teju">
                                                <div class="row flex-nowrap justify-content-between align-items-center">
                                                    <div class="col mt-4 pe-0 bubler">
                                                        <a href="javascript:;">
                                                            <div class="avatar-item d-flex align-items-center justify-content-center hp-bg-black-0 hp-bg-dark-100 rounded-circle ment">
                                                                <img src="<?php echo CSS ?>/app-assets/img/product/watch-1.png">
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col ms-10 px-0 mands">
                                                        <a href="app-ecommerce-product-detail.html">
                                                            <h5 class="mb-0 fw-medium hp-p1-body hp-text-color-black-100 hp-text-color-dark-15">Smart Watches 3</h5>
                                                            <p class="mb-0 hp-caption hp-text-color-black-60">By <span class="hp-text-color-black-80">Sony</span></p>
                                                        </a>
                                                    </div>

                                                    <div class="col hp-d-flex hp-d-flex-column ms-8 px-0 blinkn">
                                                        <div class="input-number input-number-sm riotg">
                                                            <div class="input-number-handler-wrap">
                                                                <span class="input-number-handler input-number-handler-up">
                                                                    <span class="input-number-handler-up-inner">
                                                                        <svg viewBox="64 64 896 896" width="1em" height="1em" fill="currentColor">
                                                                            <path d="M890.5 755.3L537.9 269.2c-12.8-17.6-39-17.6-51.7 0L133.5 755.3A8 8 0 00140 768h75c5.1 0 9.9-2.5 12.9-6.6L512 369.8l284.1 391.6c3 4.1 7.8 6.6 12.9 6.6h75c6.5 0 10.3-7.4 6.5-12.7z"></path>
                                                                        </svg>
                                                                    </span>
                                                                </span>

                                                                <span class="input-number-handler input-number-handler-down input-number-handler-down-disabled">
                                                                    <span class="input-number-handler-down-inner">
                                                                        <svg viewBox="64 64 896 896" width="1em" height="1em" fill="currentColor">
                                                                            <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                                                                        </svg>
                                                                    </span>
                                                                </span>
                                                            </div>

                                                            <div class="input-number-input-wrap">
                                                                <input class="input-number-input" type="number" min="1" max="10" value="1">
                                                            </div>
                                                        </div>

                                                        <div class="hp-cursor-pointer mt-4 hp-input-description fw-medium text-black-60 text-decoration-underline">Remove Item</div>
                                                    </div>

                                                    <div class="col ps-0 text-end">
                                                        <p class="hp-basket-dropdown-list-item-price hp-p1-body mb-0 hp-text-color-black-80 hp-text-color-dark-30 fw-medium">$59.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="divider mt-4 mb-12"></div>

                                        <div class="row">
                                            <div class="col-6 px-8">
                                                <a href="app-ecommerce-checkout.html">
                                                    <button type="button" class="btn btn-text w-100 hp-bg-black-20 hp-text-color-black-100 hp-hover-text-color-primary-1 hp-hover-bg-primary-4">
                                                        View Cart
                                                    </button>
                                                </a>
                                            </div>

                                            <div class="col-6 px-8">
                                                <a href="app-ecommerce-checkout-address.html">
                                                    <button type="button" class="btn btn-text hp-text-color-black-0 hp-bg-black-100 hp-hover-bg-primary-1 w-100">
                                                        Checkout
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="hover-dropdown-fade w-auto px-0 ms-6 position-relative">
                                    <div class="hp-cursor-pointer rounded-4 border hp-border-color-dark-80">
                                        <div class="rounded-3 overflow-hidden m-4 d-flex">
                                            <div class="avatar-item hp-bg-info-4 d-flex bndes">
                                                <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-4.png">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hp-header-profile-menu dropdown-fade position-absolute pt-18 nemusa">
                                        <div class="rounded hp-bg-black-0 hp-bg-dark-100 px-18 py-24">
                                            <span class="d-block h5 hp-text-color-black-100 hp-text-color-dark-0 mb-16">Profile Settings</span>

                                            <a href="profile-information.html" class="hp-p1-body fw-medium hp-hover-text-color-primary-2">View Profile</a>

                                            <div class="divider mt-18 mb-16"></div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <a href="app-contact.html" class="d-flex align-items-center fw-medium hp-p1-body my-4 py-8 px-10 hp-transition hp-hover-bg-primary-4 hp-hover-bg-dark-primary hp-hover-bg-dark-80 rounded" target="_self teju">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" class="me-8">
                                                            <path d="M21.08 8.58v6.84c0 1.12-.6 2.16-1.57 2.73l-5.94 3.43c-.97.56-2.17.56-3.15 0l-5.94-3.43a3.15 3.15 0 0 1-1.57-2.73V8.58c0-1.12.6-2.16 1.57-2.73l5.94-3.43c.97-.56 2.17-.56 3.15 0l5.94 3.43c.97.57 1.57 1.6 1.57 2.73Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M12 11a2.33 2.33 0 1 0 0-4.66A2.33 2.33 0 0 0 12 11ZM16 16.66c0-1.8-1.79-3.26-4-3.26s-4 1.46-4 3.26" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        <span>Explore Creators</span>
                                                    </a>
                                                </div>

                                                <div class="col-12">
                                                    <a href="page-knowledge-base-1.html" class="d-flex align-items-center fw-medium hp-p1-body my-4 py-8 px-10 hp-transition hp-hover-bg-primary-4 hp-hover-bg-dark-primary hp-hover-bg-dark-80 rounded" target="_self teju">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" class="me-8">
                                                            <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V17c0 3-1.5 5-5 5H8c-3.5 0-5-2-5-5V8.5c0-3 1.5-5 5-5h8c3.5 0 5 2 5 5Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.695 13.7h.009M15.695 16.7h.009M11.995 13.7h.01M11.995 16.7h.01M8.294 13.7h.01M8.294 16.7h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        <span>Help Desk</span>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="divider my-12"></div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <a href="page-pricing.html" class="d-flex align-items-center fw-medium hp-p1-body py-8 px-10 hp-transition hp-hover-bg-primary-4 hp-hover-bg-dark-primary hp-hover-bg-dark-80 rounded" target="_self teju">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" class="me-8">
                                                            <path d="M10 22h4c5 0 7-2 7-7V9c0-5-2-7-7-7h-4C5 2 3 4 3 9v6c0 5 2 7 7 7Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M16.5 7.58v1c0 .82-.67 1.5-1.5 1.5H9c-.82 0-1.5-.67-1.5-1.5v-1c0-.82.67-1.5 1.5-1.5h6c.83 0 1.5.67 1.5 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M8.136 14h.012M11.995 14h.012M15.854 14h.012M8.136 17.5h.012M11.995 17.5h.012M15.854 17.5h.012" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        <span>Pricing List</span>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="divider mt-12 mb-18"></div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <a class="hp-p1-body fw-medium" href="profile-information.html">Account Settings</a>
                                                </div>

                                                <div class="col-12 mt-24">
                                                    <a class="hp-p1-body fw-medium" href="<?php echo HOME_URI ?>/login">Logout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                        

                        <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logoapp_oficial.png" alt="logo">
                        <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/app5mclaro.png" alt="logo">
                        
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
                        

                                    <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-none" src="<?php echo CSS ?>/app-assets/img/logo/logoapp_oficial.png" alt="logo">
                                    <img class="hp-logo hp-sidebar-hidden hp-dir-none hp-dark-block" src="<?php echo CSS ?>/app-assets/img/logo/app5mclaro.png" alt="logo">
                                    
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

                        <?php require 'views/_include/menu.php'; ?>
                    </div>

                    <!-- <div class="row justify-content-between align-items-center hp-sidebar-footer mx-0 hp-bg-color-dark-90">
                        <div class="divider border-black-40 hp-border-color-dark-70 hp-sidebar-hidden mt-0 px-0"></div>

                        <div class="col">
                            <div class="row align-items-center">
                                <div class="w-auto px-0">
                                    <div class="avatar-item bg-primary-4 d-flex align-items-center justify-content-center rounded-circle temi">
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
        </div>

        <div class="hp-main-layout-content">
            <div class="row mb-32 gy-32">
                <div class="col-12">
                    <div class="row align-items-center justify-content-between g-24">
                        <div class="col-12 col-md-6">
                            <h3>Gerenciamento de Itens</h3>
                            <p class="hp-p1-body mb-0">Gerencie seus itens como preferir!</p>
                        </div>

                        <!-- <div class="col hp-flex-none w-auto">
                            <select class="form-select">
                                <option selected value="1">This Month</option>
                                <option value="2">This Week</option>
                                <option value="3">This Year</option>
                            </select>
                        </div> -->
                    </div>
                </div>

                <div class="col-12">
                    

                    <div class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <h5>Faça sua pesquisa</h5>
                                                <div class="col-3">
                                                    <label for="">Nome</label>
                                                    <input type="text" class="form-control ps-8" placeholder="Nome">
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Email</label>
                                                    <input type="text" class="form-control ps-8" placeholder="E-mail">
                                                </div>
                                                <div class="col-3"> 
                                                    <button class="btn btn-outline-info down">
                                                        <i class="ri-search-line remix-icon"></i>
                                                        <span>Buscar</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               
                            </div>
                        </div>

                        
                    </div>
                    
                </div>
                <div class="col-12">
                    

                    <div id="geral" class="row g-32">
                        <div class="col-12 col-xl-12">
                            <div v-show="mostrardiv == '1'" class="row g-32">
                                <div class="col-12">
                                    <div class="card hp-project-ecommerce-table-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between mb-32">
                                                        <h5 class="mb-0">Lista de Itens</h5>
                                                        <div>
                                                       <a href="<?php echo HOME_URI ?>/categorias"><button class="btn btn-sm btn-primary">Categorias</button></a>
                                                        <button @click="mostrarDivNew" class="btn btn-sm btn-primary">Novo</button>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="table-responsive">
                                                        <table class="table align-middle mb-0">
                                                            <thead>
                                                                <tr>
                                                                    
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Capa</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Categoria</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Subcategoria</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Nome</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Valor</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Descrição</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Status</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Destaque</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-center hp-badge-size d-block pb-16 fw-normal text-black-60 hp-text-color-dark-50 text-uppercase">Ações</span>
                                                                    </th>
                                                                   
                                                                    
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                
                                                                <tr>
                                                                    
                                                                    <td class="ps-0 text-center photolist">
                                                                        <div class="avatar-item d-flex align-items-center justify-content-center rounded-circle imageroll">
                                                                            <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-1.png" class="w-100">
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Casa</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Sala de estar</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Sofá</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">R$20,00</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Ótimo produto!</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Ativo</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Sim</span>
                                                                    </td>
                                                                    
                                                                    
                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                        <svg @click="mostrarDivEdit" style="cursor:pointer;" fill="#858e91" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-lead-pencil" width="24" height="24" viewBox="0 0 24 24"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29" /></svg>
                                                                        <button class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                                        
                                                                    </div>
                                                                    </td>
                                                                   
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td class="ps-0 text-center photolist">
                                                                        <div class="avatar-item d-flex align-items-center justify-content-center rounded-circle imageroll">
                                                                            <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-1.png" class="w-100">
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Casa</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Sala de estar</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Sofá</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">R$20,00</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Ótimo produto!</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Ativo</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Sim</span>
                                                                    </td>
                                                                    
                                                                    
                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                        <svg @click="mostrarDivEdit" style="cursor:pointer;" fill="#858e91" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-lead-pencil" width="24" height="24" viewBox="0 0 24 24"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29" /></svg>
                                                                        <button class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                                        
                                                                    </div>
                                                                    </td>
                                                                   
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td class="ps-0 text-center photolist">
                                                                        <div class="avatar-item d-flex align-items-center justify-content-center rounded-circle imageroll">
                                                                            <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-1.png" class="w-100">
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Casa</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Sala de estar</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Sofá</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">R$20,00</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Ótimo produto!</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Ativo</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="mb-0 text-black-80 hp-text-color-dark-30">Sim</span>
                                                                    </td>
                                                                    
                                                                    
                                                                    <td class="text-center">
                                                                        <div class="actionbuttons">
                                                                        <svg @click="mostrarDivEdit" style="cursor:pointer;" fill="#858e91" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-lead-pencil" width="24" height="24" viewBox="0 0 24 24"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29" /></svg>
                                                                        <button class="iconly-Light-Delete hp-cursor-pointer hp-transition hp-hover-text-color-danger-1 text-black-80 lixeira bg-transparent"></button>
                                                                        
                                                                    </div>
                                                                    </td>
                                                                   
                                                                </tr>
                                                               

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               
                            </div>

                            <div v-show="mostrardiv == '2'" class="row g-32">
                                <div class="col-12 col-xl-12">
                                    <div class="row g-32">
                                        <div class="col-12">
                                            <div class="card hp-project-ecommerce-table-card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <h5>Novo item</h5>
                                                        <form>
                                                            <div class="modal-body">
                                                                <div class="row gx-8">
                        
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="mb-24">
                                                                            <label for="status" class="form-label">
                                                                                
                                                                               Categoria
                                                                            </label>
                                                                            <select class="form-select" id="status">
                                                                                <option selected disabled>Selecione a categoria</option>
                                                                                <option value="1">categoria X</option>
                                                                                <option value="2">categoria X</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="mb-24">
                                                                            <label for="status" class="form-label">
                                                                                
                                                                               SubCategoria
                                                                            </label>
                                                                            <select class="form-select" id="status">
                                                                                <option selected disabled>Selecione a subcategoria</option>
                                                                                <option value="1">subcategoria x</option>
                                                                                <option value="2">subcategoria x</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                        
                                                                    <div class="col-12 col-md-4">
                                                                        <div class="mb-24">
                                                                            <label for="name" class="form-label">
                                                                                
                                                                                Nome
                                                                            </label>
                                                                            <input type="text" class="form-control" placeholder="Nome" id="name">
                                                                        </div>
                                                                    </div>
                            
                                                                    <div class="col-12 col-md-4">
                                                                        <div class="mb-24">
                                                                            <label for="userName" class="form-label">
                                                                                
                                                                               Valor
                                                                            </label>
                                                                            <input type="text" placeholder="R$" class="form-control" id="userName">
                                                                        </div>
                                                                    </div>
                            
                                                                    <div class="col-12 col-md-4">
                                                                        <div class="mb-24">
                                                                            <label for="status" class="form-label">
                                                                                
                                                                               Destaque
                                                                            </label>
                                                                            <select class="form-select" id="status">
                                                                                <option selected disabled>Item em destaque?</option>
                                                                                <option value="1">Sim</option>
                                                                                <option value="2">Não</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                            
                                                                    
                                                                    
                            
                                                                    <div class="col-12 col-md-12">
                                                                        <div class="mb-24">
                                                                            <label for="name" class="form-label">
                                                                                Descrição
                                                                            </label>
                                                                            <textarea class="form-control" placeholder="Descrição" cols="30" rows="3"></textarea>
                                                                           
                                                                        </div>
                                                                    </div>
                            
                                                                    
                            
                                                                </div>
                                                            </div>
                            
                                                            <div class="modal-footer pt-0 px-24 pb-24">
                                                               
                            
                                                                <button type="button" class="m-0 btn btn-primary">Salvar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                       
                                    </div>
                                </div>
    
                            </div>
                            <div v-show="mostrardiv == '3'" class="row g-32">
                                <div class="col-12 col-xl-12">
                                    <div class="row g-32">
                                        <div class="col-12">
                                            <div class="card hp-project-ecommerce-table-card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        
                                                        <h5>Editar item</h5>
                                                        
                                                        <form>
                                                            <div class="modal-body">
                                                                <div class="row gx-8">
                        
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="mb-24">
                                                                            <label for="status" class="form-label">
                                                                                
                                                                               Categoria
                                                                            </label>
                                                                            <select class="form-select" id="status">
                                                                                <option selected disabled>Selecione a categoria</option>
                                                                                <option value="1">categoria X</option>
                                                                                <option value="2">categoria X</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="mb-24">
                                                                            <label for="status" class="form-label">
                                                                                
                                                                               SubCategoria
                                                                            </label>
                                                                            <select class="form-select" id="status">
                                                                                <option selected disabled>Selecione a subcategoria</option>
                                                                                <option value="1">subcategoria x</option>
                                                                                <option value="2">subcategoria x</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                        
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="mb-24">
                                                                            <label for="name" class="form-label">
                                                                                
                                                                                Nome
                                                                            </label>
                                                                            <input type="text" class="form-control" placeholder="Nome" id="name">
                                                                        </div>
                                                                    </div>
                            
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="mb-24">
                                                                            <label for="userName" class="form-label">
                                                                                
                                                                               Valor
                                                                            </label>
                                                                            <input type="text" placeholder="R$" class="form-control" id="userName">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 col-md-6">
                                                                        <div class="mb-24">
                                                                            <label for="status" class="form-label">
                                                                               Status
                                                                            </label>
                                                                            <select class="form-select" id="status">
                                                                                <option selected disabled>Selecione a Status</option>
                                                                                <option value="1">Ativo</option>
                                                                                <option value="2">Inativo</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                            
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="mb-24">
                                                                            <label for="status" class="form-label">
                                                                                
                                                                               Destaque
                                                                            </label>
                                                                            <select class="form-select" id="status">
                                                                                <option selected disabled>Item em destaque?</option>
                                                                                <option value="1">Sim</option>
                                                                                <option value="2">Não</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                            
                                                                    
                                                                    
                            
                                                                    <div class="col-12 col-md-12">
                                                                        <div class="mb-24">
                                                                            <label for="name" class="form-label">
                                                                                Descrição
                                                                            </label>
                                                                            <textarea class="form-control" placeholder="Descrição" cols="30" rows="3"></textarea>
                                                                           
                                                                        </div>
                                                                    </div>
                            
                                                                    
                            
                                                                </div>
                                                            </div>
                            
                                                            <div class="modal-footer pt-0 px-24 pb-24">
                                                               
                            
                                                                <button type="button" class="m-0 btn btn-primary">Salvar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                       
                                    </div>
                                </div>
                                <div class="col-12 col-xl-12">
                                    <div class="row g-32">
                                        <div class="col-12">
                                            <div class="card hp-project-ecommerce-table-card">
                                                <div class="card-body">
                                                    <div class="widget-content widget-content-area">
                                                        <h5>Salvar Imagens</h5>
                                                        <form class="dropzone lightimage" id="my-dropzone" action="#">
                                                            <div class="dz-message" data-dz-message><span>Arraste as imagens aqui ou clique para selecionar!</span></div>
                                                        </form>
                                                        <form>
                                                                 
                                                                  <div class="upload col-md-12">
                                                                    <div class="d-flex flex-wrap">
                                                                      <div class="mr-3 mb-3 lounge">
                                                                        <div class="foto-container">
                                                                          <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-8.png" alt="" class="rounded avatar-lg" style=" height: 100px;">
                                                                          <div class="foto-buttons">
                                                                            <button class="btn btn-danger btn-sm foto-delete-btn">
                                                                              <i>Excluir</i>
                                                                            </button>
                                                                            <button  type="button" class="btn btn-primary btn-sm foto-action-btn">
                                                                              <i>Tornar capa</i>
                                                                            </button>
                                                                          </div>
                                                                        </div>
                                                                        <div class="foto-container">
                                                                          <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-8.png" alt="" class="rounded avatar-lg" style=" height: 100px;">
                                                                          <div class="foto-buttons">
                                                                            <button class="btn btn-danger btn-sm foto-delete-btn">
                                                                              <i>Excluir</i>
                                                                            </button>
                                                                            <button  type="button" class="btn btn-primary btn-sm foto-action-btn">
                                                                              <i>Tornar capa</i>
                                                                            </button>
                                                                          </div>
                                                                        </div>
                                                                        <div class="foto-container">
                                                                          <img src="<?php echo CSS ?>/app-assets/img/memoji/user-avatar-8.png" alt="" class="rounded avatar-lg" style=" height: 100px;">
                                                                          <div class="foto-buttons">
                                                                            <button class="btn btn-danger btn-sm foto-delete-btn">
                                                                              <i>Excluir</i>
                                                                            </button>
                                                                            <button  type="button" class="btn btn-primary btn-sm foto-action-btn">
                                                                              <i>Tornar capa</i>
                                                                            </button>
                                                                          </div>
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                            </div>
                                                      </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
    
                                       
                                    </div>
                                </div>
    
                            </div>
                        </div>

                        
                    </div>
                </div>
                <!-- EDITAR CUPOM -->
                <div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addNewUserLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-16 px-24">
                                <h5 class="modal-title" id="addNewUserLabel">Editar Plano</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider m-0"></div>

                            <form>
                                <div class="modal-body">
                                    <div class="row gx-8">

                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="status" class="form-label">
                                                    
                                                    Tipo
                                                </label>
                                                <select class="form-select" id="status">
                                                    <option selected disabled>Selecione o tipo</option>
                                                    <option value="1">Assinatura</option>
                                                    <option value="2">Avulso</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">
                                                    
                                                    Nome
                                                </label>
                                                <input type="text" class="form-control" placeholder="Nome" id="name">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="userName" class="form-label">
                                                    
                                                   Valor
                                                </label>
                                                <input type="text" placeholder="R$" class="form-control" id="userName">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="email" class="form-label">
                                                    Tempo de Free
                                                </label>
                                                <input type="text" placeholder="tempo de free" class="form-control" id="email">
                                            </div>
                                        </div>

                                        
                                        

                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">
                                                    Validade
                                                </label>
                                                <input type="text" class="form-control" placeholder="Validade" id="name">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="status" class="form-label">
                                                    Status
                                                </label>
                                                <select class="form-select" id="status">
                                                    <option value="1">Ativo</option>
                                                    <option value="2">Inativo</option>
                                                </select>
                                            </div>
                                        </div>

                                        

                                    </div>
                                </div>

                                <div class="modal-footer pt-0 px-24 pb-24">
                                    <div class="divider"></div>

                                    <button type="button" class="m-0 btn btn-primary">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- EDITAR CUPOM -->
                <!-- NOVO CUPOM -->
                <div class="modal fade" id="addNewProd" tabindex="-1" aria-labelledby="addNewProdLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-16 px-24">
                                <h5 class="modal-title" id="addNewProdLabel">Novo Plano</h5>
                                <button type="button" class="btn-close hp-bg-none d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-line hp-text-color-dark-0 lh-1 lorden"></i>
                                </button>
                            </div>

                            <div class="divider m-0"></div>

                            <form>
                                <div class="modal-body">
                                    <div class="row gx-8">

                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="status" class="form-label">
                                                    
                                                    Tipo
                                                </label>
                                                <select class="form-select" id="status">
                                                    <option selected disabled>Selecione o tipo</option>
                                                    <option value="1">Assinatura</option>
                                                    <option value="2">Avulso</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">
                                                    
                                                    Nome
                                                </label>
                                                <input type="text" class="form-control" placeholder="Nome" id="name">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="mb-24">
                                                <label for="userName" class="form-label">
                                                    
                                                   Valor
                                                </label>
                                                <input type="text" placeholder="R$" class="form-control" id="userName">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="mb-24">
                                                <label for="email" class="form-label">
                                                    Tempo de Free
                                                </label>
                                                <input type="text" placeholder="tempo de free" class="form-control" id="email">
                                            </div>
                                        </div>

                                        
                                        

                                        <div class="col-12 col-md-4">
                                            <div class="mb-24">
                                                <label for="name" class="form-label">
                                                    Validade
                                                </label>
                                                <input type="text" class="form-control" placeholder="Validade" id="name">
                                            </div>
                                        </div>

                                        

                                    </div>
                                </div>

                                <div class="modal-footer pt-0 px-24 pb-24">
                                    <div class="divider"></div>

                                    <button type="button" class="m-0 btn btn-primary">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- NOVO CUPOM -->
            </div>
        </div>

        <!-- <footer class="w-100 py-18 px-16 py-sm-24 px-sm-32 hp-bg-color-black-20 hp-bg-color-dark-90">
            <div class="row">
                <div class="col-12">
                    <p class="hp-p1-body text-center hp-text-color-black-60 mb-8">Todos os direitos reservados à Meu APP Premium &#174; <?php echo date('Y'); ?> Desenvolvido por <a href="http://app5m.com.br/" target="_blank">App5M</a> - <a href="http://app5m.com.br/" target="_blank">Criação de Sites</a> - <a href="http://app5m.com.br/" target="_blank">Desenvolvimento de Aplicativos</a></p>
                </div>
            </div>
        </footer> -->
    </div>
</main>





<div class="scroll-to-top">
    <button type="button" class="btn btn-primary btn-icon-only rounded-circle hp-primary-shadow">
        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="16px" width="16px" xmlns="http://www.w3.org/2000/svg">
            <g>
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path d="M13 7.828V20h-2V7.828l-5.364 5.364-1.414-1.414L12 4l7.778 7.778-1.414 1.414L13 7.828z"></path>
            </g>
        </svg>
    </button>
</div>
<script>
 

    $(".dropzone").each(function() {
        var myDropzone = new Dropzone(this, {
            paramName: "file",
            maxFilesize: 5,
            dictDefaultMessage: "Arraste e solte os arquivos aqui ou clique para selecionar.", // Mensagem personalizada
            // Adicione mais configurações conforme necessário
        });
    });
</script>
<?php require_once 'views/_include/scripts.php'; ?>
<script src="<?php echo VUE ?>/geral.js"></script>
</body>

</html>
