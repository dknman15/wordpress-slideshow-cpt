<?php
/*
* Custom Post Type - Homepage Slideshow
*/

add_action( 'init', 'create_homepage_slides' );
function create_homepage_slides() {
    register_post_type( 'homepage_slides',
        array(
            'labels' => array(
                'name' => 'Homepage Slides',
                'singular_name' => 'Homepage Slide',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Homepage Slide',
                'edit' => 'Edit',
                'edit_item' => 'Edit Homepage Slide',
                'new_item' => 'New Homepage Slide',
                'view' => 'View',
                'view_item' => 'View Homepage Slide',
                'search_items' => 'Search Homepage Slides',
                'not_found' => 'No Homepage Slides found',
                'not_found_in_trash' => 'No Homepage Slides found in Trash',
                'parent' => 'Parent Homepage Slide'
            ),
            'public' => true,
            'menu_position' => 20,
            'supports' => array( 'title', 'thumbnail' ),
            'taxonomies' => array( '' ),
            'has_archive' => false,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'homepage-slides')
        )
    );
	flush_rewrite_rules();
}


function homepage_slides_admin() {
    add_meta_box( 
		'homepage_slides_meta_box',
        'Homepage Slides Details',
        'homepage_slides_meta_box',
        'homepage_slides', 'normal', 'high'
    );
}
add_action( 'admin_init', 'homepage_slides_admin' );

function homepage_slides_meta_box( $homepage_slides ) {
    $homepage_slides_link = esc_html( get_post_meta( $homepage_slides->ID, 'homepage_slides_link', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 80px">Link</td>
            <td><input type="text" size="30" name="homepage_slides_link" value="<?php echo $homepage_slides_link; ?>" /></td>
		</tr>
    </table>
    <?php
}

add_action( 'save_post', 'add_homepage_slides_fields', 10, 2 );
function add_homepage_slides_fields( $homepage_slides_id, $homepage_slides ) {
    if ( $homepage_slides->post_type == 'homepage_slides' ) {
		if ( isset( $_POST['homepage_slides_link'] )) {
            update_post_meta( $homepage_slides_id, 'homepage_slides_link', $_POST['homepage_slides_link'] );
        }
    }
}

function homepage_slides_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'image' => __( 'Image' ),
	);

	return $columns;
}
add_filter( 'manage_edit-homepage_slides_columns', 'homepage_slides_columns' ) ;

function homepage_slides_data_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'image' :
			
			echo the_post_thumbnail();
			
			break;
		default :
			break;
	}
}

add_action( 'manage_homepage_slides_posts_custom_column', 'homepage_slides_data_columns', 10, 2 );



?>