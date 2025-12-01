                <ul class="hp-print-none">
                    <li>
                        <div class="menu-title">MENUS</div>

                        <ul id="menuscelular">
                            <li v-for="menus of listallmenus">
                                <a :href="'<?php echo HOME_URI ?>/'+menus.link_menu">
                                <div class="tooltip-item in-active" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Typography" aria-label="Typography"></div>

                                    <span>
                                        <span style="display:flex; align-items:center;" class="submenu-item-icon">
                                        <i style="margin-right:5px;" :class="menus.icone_menu"></i>

                                        <span>{{menus.nome_menu}}</span>
                                    </span>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                </ul>