<?php # -*- coding: utf-8 -*-
class Sider extends Walker_Nav_Menu {

	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

   public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

   public function start_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "\n$indent<ul class=\"menu\">";
   }

   public function end_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "$indent</ul>\n";
   }

   public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
       $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

	   if ( $args->walker->has_children ){
	   		$output .= $indent . '<li class="header item">';
	   	}
	   	else
	   	{
	   		$output .= $indent . '<li class="item">';
	   	}

	   $atts = array();
	   $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
	   $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
	   $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
	   $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

	   $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

	   $attributes = '';
	   foreach ( $atts as $attr => $value ) {
	      if ( ! empty( $value ) ) {
	         $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
	         $attributes .= ' ' . $attr . '="' . $value . '"';
	      }
	   }

	   $icon = '';
	   $no_link = '';
	   if ( $args->walker->has_children ){
	   		$icon = "<i class=\"angle down icon\"></i>";
	   		$item_output = $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after . $icon;
	   }
	   else
	   {

		   $item_output = $args->before;
		   $item_output .= '<a'. $attributes .'>';
		   $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		   $item_output .= '</a>' . $icon;
		   $item_output .= $args->after;
		}

	    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	    
   }

   public function end_el( &$output, $item, $depth = 0, $args = array() ) {
      $output .= "</li>\n";
   }

}
