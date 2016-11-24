<?php

function the_excerpt_max_charlength( $charlength, $text = NULL ) {
	$excerpt = ( is_null( $text ) ? get_the_excerpt() : $text );
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {

		$subex 		= mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords 	= explode( ' ', $subex );
		$excut 		= - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			return mb_substr( $subex, 0, $excut ) . '...';
		} else {
			return $subex;
		}

	} else {

		return $excerpt;
	}
}


function event_month_dropdown( $default = null )
{
	
	$html = '<select name="m" class="ui fluid selection dropdown">';
   	$html .= '<option value="-">Pilih bulan</option>';
	
	for ($m=1; $m<=12; $m++) {
		
		$time 	= mktime(0,0,0,$m);
		$value	= date('m', $time);
		$selected = null;
		
		if( $value == $default  ) {
			$selected = 'selected="selected"';
		}

       	$html .= '<option value="' . $value . '" '.  $selected .'>' . date('F', $time) . '</option>';
    }
	$html .= '</select>';

	echo $html;
}

function event_year_dropdown( $default = null )
{
	
	$html = '<select name="year" class="tim-select">';
   	$html .= '<option value="-">Pilih tahun</option>';
	
	$year_start = date('Y', strtotime('+2 years'));

	for ($m=1; $m<=5; $m++) {
		
		$selected = null;
		
		if( $year_start == $default  ) {
			$selected = 'selected="selected"';
		}

       	$html .= '<option value="' . $year_start . '" '.  $selected .'>' . $year_start . '</option>';
       	$year_start--;
    }
	$html .= '</select>';

	echo $html;
}

/**
 * Retrieve meta data(caption, alt, href, description) from Attachment
 * @param  [int] $attachment_id  post id
 * @return [array]                
 */
function tim_get_attachment( $attachment_id ) {

    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}
?>