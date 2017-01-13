<div class="main-menu">
    <div class="ui grid container">
      <div class="column">
        <div class="ui secondary menu page-nav">
          <div class="header item">
            <img class="ui centered golo image" src="<?php if(get_theme_mod( 'img-upload' )!=null || get_theme_mod( 'img-upload' ) != '') echo get_theme_mod( 'img-upload' ); else echo get_template_directory_uri().'/img/dki.png'; ?>"" alt="">
            <div class="content">
              <a href="<?php echo site_url(); ?>">
                <h3 class="ui header"><?php echo get_theme_mod( 'nick_title', 'your title' ); ?></h3>
                <p><?php echo get_theme_mod( 'nick_city', 'your city' ); ?></p>
              </a>
            </div>
          </div>
          <div class="right menu">
            
            <form action="<?php echo home_url( '/' ); ?>">
              <div class="item search-ui">
                <div class="ui fluid search">
                  <div class="ui icon input">
                    <input class="prompt" name="s" type="text" placeholder="Search...">
                    <i class="search icon"></i>
                  </div>
                </div>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="ui menu menu-bar">
    <div class="ui container">
      <?php 
              wp_nav_menu(array(
                'menu'              => 'primary',
                'theme_location'    => 'primary',
                'depth'             => 3,
                'container'         => '',
                'container_id'      => '',
                'container_class'   => '',
                'menu_class'        => '',
                'fallback_cb'       => '',
                'items_wrap'        => '%3$s',
                'walker'            => new walkah()
              ));
            ?>
    </div>
  </div>
          
  <div class="ui vertical left sidebar styled accordion menu">
    <?php 
      wp_nav_menu(array(
        'menu'              => 'primary',
        'theme_location'    => 'primary',
        'depth'             => 3,
        'container'         => '',
        'container_id'      => '',
        'container_class'   => '',
        'menu_class'        => '',
        'fallback_cb'       => '',
        'items_wrap'        => '%3$s',
        'walker'            => new sider()
      ));
    ?>
  </div>
  <div class="pusher">
    <div class="mobile-nav">
      <div class="ui container">
        <div class="ui large secondary menu">
          <div class="item head">
            <div class="ui logo image">
              <img class="ui mini image" src="<?php if(get_theme_mod( 'img-upload' )!=null || get_theme_mod( 'img-upload' ) != '') echo get_theme_mod( 'img-upload' ); else echo get_template_directory_uri().'/img/dki.png'; ?>"" alt="">
            </div>
            <div class="mobile-label">
              <h3 class="title"><?php echo get_theme_mod( 'nick_title_abr', 'your abbreviation title' ); ?></h3>
              <h5 class="subtitle"><?php echo get_theme_mod( 'nick_subtitle', 'your subtitle' ); ?></h5>
            </div>
          </div>
          <div class="right item">
            <a class="toc item">
              <i class="sidebar icon"></i>
            </a>
          </div>
        </div>
      </div>
    </div>