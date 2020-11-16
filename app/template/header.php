<header id="page-header">
    <div id="header-container">
        <div id="site-icon-container">
            <img src="<?=BACKSTEP?>public/ikons/83439824283dvn9ö93nmds.png" alt="">
            <div class="separator"></div>
            <div class="colored-cases">speaker portal</div>
        </div>
        <div id="header-nav">
            <div id="site-description">
                <div class="colored-cases">Sitemap</div>
                <div class="colored-cases">Contact</div>                
                <div class="colored-cases">English <img src="<?=BACKSTEP?>public/ikons/201110133606474wNYNxV10.jpg" alt=""></div>                
            </div>
            <div class=""></div>
            <div id="peronal-controls">                
                <div>
                    <?php if ($user::get("logged")): ?>
                        <a class="colored-cases" href="<?=BACKSTEP.APPROOT?>logout">&#8855; Logout</a>                        
                    <?php else: ?>
                        <a class="colored-cases" href="<?=BACKSTEP.APPROOT?>login">Login</a>
                    <?php endif ?>
                </div>
                <div class="colored-cases">&#9921; My Collection</div>
            </div>
        </div>
        <div id="logo">
            <img src="<?=BACKSTEP?>public/ikons/201110133606474wNYNxV27.jpg" alt="">
        </div>
    </div>
    <div id="page-menu">
        <div class="menu-center">
            <div class="">
                <a href="<?=BACKSTEP.APPROOT?>"><img src="<?=BACKSTEP?>public/ikons/201110133606474wNYNxV38.jpg" alt=""></a>
            </div>
            <div>
                <?php if($user::get("logged")): ?>
                    <a href="<?=BACKSTEP.APPROOT?>gat" class="colored-cases">mpaf</a>
                <?php else: ?>
                    <span class="colored-cases">mpaf</span>
                <?php endif ?>
            </div>
            <div class="colored-cases">venous</div>
            <div class="colored-cases">acs</div>
            <div class="colored-cases">kivamoxoban studies</div>
            <div class="colored-cases">background information</div>
        </div>
    </div>
</header>