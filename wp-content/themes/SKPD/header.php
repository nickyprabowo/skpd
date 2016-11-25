<!DOCTYPE html <?php language_attributes(); ?>>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<?php if(is_page('user-form')){
  /*echo '<meta http-equiv="REFRESH" content="5;url='.echo esc_url( home_url( '/' ) ).'">';*/
}; ?>
<title>
  <?php bloginfo('name'); ?> |
  <?php is_front_page() ? bloginfo('description') : wp_title(''); ?>
</title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
  
  <div class="main-menu">
    <div class="ui grid container">
      <div class="column">
        <div class="ui secondary menu page-nav">
          <div class="header item">
            <img class="ui centered golo image" src="<?php if(get_theme_mod( 'img-upload' )!=null || get_theme_mod( 'img-upload' ) != '') echo get_theme_mod( 'img-upload' ); else echo get_template_directory_uri().'/img/dki.png'; ?>"" alt="">
            <div class="content">
              <a href="<?php echo site_url(); ?>">
                <h2 class="ui header"><?php echo get_theme_mod( 'nick_title_abr', 'your title' ); ?></h2>
                <p><?php echo get_theme_mod( 'nick_subtitle', 'your subtitle' ); ?></p>
              </a>
            </div>
          </div>
          <div class="right menu">
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
            <div class="item search-ui">
              <div class="ui fluid search">
                <div class="ui icon input">
                  <input class="prompt" type="text" placeholder="Search...">
                  <i class="search icon"></i>
                </div>
              </div>
            </div>
            <a class="item search-btn">
              <i class="search icon"></i>
            </a>
            <a class="item search-close">
              <i class="remove icon"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="ui vertical left sidebar accordion menu">
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
    <div class="item">
      <a class="title">
        <i class="dropdown icon"></i>
        Size
      </a>
      <div class="content">
        <div class="ui link list">
          <div class="active item">Home</div>
          <a class="item">About</a>
          <a class="item">Jobs</a>
          <a class="item">Team</a>
        </div>
      </div>
    </div>
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

