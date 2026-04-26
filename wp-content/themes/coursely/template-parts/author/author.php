<?php
/**
 * Template part Author
 */
$current_id  = get_the_ID();
$author_of_publication = get_field( 'author_of_publication', $current_id );
?>
<div class="author-info-wrapper">
	<?php
	if ( $author_of_publication ) {
		$author_img  = get_field( 'author_photo', $author_of_publication[0] );
		$author_info = get_field( 'author_info', $author_of_publication[0] );
		echo '<p>';
		echo '<span class="h4">Author: <span itemprop="author">' . get_the_title( $author_of_publication[0]->ID ) . '</span></span></p>
        <img width="150" height="150" class="author-img" src="' . $author_img['url'] . '" alt="' . $author_img['url'] . '">
        <p class="author-description">' . $author_info . '</p>';
	} else {
		echo '<p><b>Author: </b><span itemprop="author">' . get_the_author() . '</span></p>';
	}
	?>
</div>
