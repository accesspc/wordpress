<?php
/**
 * Adds A4s_Addons_Widget_CPT widget.
 * 
 * @author Robertas Reiciunas
 * @since 1.1.0
 */
class A4s_Addons_Widget_CPT extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'a4s_addons_widget_cpt', // Base ID
			'A4s Category and Post Tree', // Name
			array( 'description' => __( 'A4s Category and Post Tree Description', 'a4saddons' ), ) // Args
		);
		
		add_shortcode('a4s-addons-cpt', array($this, 'shortcode_print_list'));
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 * 
	 * @since 1.1.0
	 *
	 * @param array $args	 Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$cpt_list_posts = (isset($instance['cpt_list_posts'])) ? $instance['cpt_list_posts'] : '';
		$cpt_full_list = (isset($instance['cpt_full_list'])) ? $instance['cpt_full_list'] : '';
		$list_opts = array(
			'cpt_list_posts' => $cpt_list_posts,
			'cpt_full_list' => $cpt_full_list
		);
 
		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
		echo '<div class="a4s-cpt-qs">';
		echo '<input type="text" id="qs" class="qs" value="" placeholder="Type for quick search..." />';
		echo '</div>';
		echo '<div class="a4s-cpt">';
		$this->getList($list_opts);
		echo "</div>";
		echo $after_widget;
	}
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 * 
	 * @since 1.1.0
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ( isset( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : __( 'New title', 'a4saddons' );
		$cpt_list_posts = (isset($instance['cpt_list_posts'])) ? $instance['cpt_list_posts'] : '';
		$cpt_full_list = (isset($instance['cpt_full_list'])) ? $instance['cpt_full_list'] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>">
				<?php _e( 'Title:' ); ?>
				<input class="widefat"
					id="<?php echo $this->get_field_id( 'title' ); ?>"
					name="<?php echo $this->get_field_name( 'title' ); ?>" 
					type="text" 
					value="<?php echo esc_attr( $title ); ?>"
				/>
			</label>
			<br />
			<label for="<?php echo $this->get_field_id('cpt_list_posts'); ?>">
				<input class="checkbox" 
					id="<?php echo $this->get_field_id('cpt_list_posts'); ?>" 
					name="<?php echo $this->get_field_name('cpt_list_posts'); ?>" 
					type="checkbox" <?php checked($cpt_list_posts, 'on' ); ?>
				/>
				<?php _e('Also list posts', 'a4saddons'); ?>
			</label>
			<br />
			<label for="<?php echo $this->get_field_id('cpt_full_list'); ?>">
				<input class="checkbox"
					id="<?php echo $this->get_field_id('cpt_full_list'); ?>"
					name="<?php echo $this->get_field_name('cpt_full_list'); ?>"
					type="checkbox" <?php checked($cpt_full_list, 'on' ); ?>
				/>
				<?php _e('Show full list', 'a4saddons'); ?>
			</label>
		</p>
		<?php
	}
	
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 * 
	 * @since 1.1.0
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		//$instance = array();
		$instance = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['cpt_list_posts'] = ( isset($new_instance['cpt_list_posts'])) ? strip_tags( $new_instance['cpt_list_posts'] ) : '';
		$instance['cpt_full_list'] = ( isset($new_instance['cpt_full_list'])) ? strip_tags( $new_instance['cpt_full_list']) : '';
		
		return $instance;
	}
	
	/**
	 * Recursively get categories and posts tree
	 * 
	 * @since 1.1.0
	 * 
	 * @param array $list_opts
	 * @param number $parentId
	 * @param number $lvl
	 */
	public function getList($list_opts, $parentId = 0, $lvl = 1) {
		$cpt_list_posts = $list_opts['cpt_list_posts'];
		$cpt_full_list = $list_opts['cpt_full_list'];
		
		if ($cpt_list_posts == 'on') {
			$cpt_list_posts = 1;
			$list_opts['cpt_list_posts'] = 1;
		}
		if ($parentId == 0) {
			echo '<ul class="cat-list cat-'.$lvl.'">';
		}
		$categories = get_categories(
			array(
				'parent' => $parentId,
			)
		);
		foreach ($categories as $category) {
			$subLvl = $lvl + 1;
			echo '<li class="cat-title cat-'.$lvl.'"><a href="' . get_category_link($category->term_id) . '" title="Category: ' . $category->name . '">' . $category->name . '</a>';
			echo '<ul class="cat-list cat-'.$subLvl.'">';
			$this->getList($list_opts, $category->term_id, $subLvl);
			echo '</li>';
			echo '</ul>';
		}
		if ($parentId > 0 && $cpt_list_posts == 1) {
			$post_args = array(
				'category' => $parentId,
				'orderby' => $list_opts['orderby'],
				'order' => $list_opts['order'],
			);
			if ( $cpt_full_list ) $post_args['posts_per_page'] = -1;
			
			$posts = get_posts($post_args);
			foreach ($posts as $post) {
				$child_categories = get_term_children($parentId, 'category');
				if ($child_categories && in_category($child_categories, $post->ID)) {
					continue;
				}
				echo '<li class="cat-item cat-'.$lvl.'"><a href="' . esc_url(get_permalink($post->ID)) . '" title="Post: ' . $post->post_title . '">' . $post->post_title . '</a></li>';
			}
		}
		if ($parentId == 0) {
			echo '</ul>';
		}
	}
	
	/**
	 * Shortcode function for printing Category and Post list
	 * 
	 * @since 1.1.0
	 * 
	 * @param unknown $atts
	 * @return unknown
	 */
	public function shortcode_print_list($atts) {
		$a4s_addons_atts = shortcode_atts(
			array(
				'posts' => 1,
				'full' => 1
			),
			$atts
		);
		
		$list_opts = array(
			'cpt_list_posts' => $a4s_addons_atts['posts'],
			'cpt_full_list' => $a4s_addons_atts['full'],
			'orderby' => 'ID',
			'order' => 'DESC',
		);
		
		if (isset($_GET['orderby'])) {
			$list_opts['orderby'] = $_GET['orderby'];
		}
		if (isset($_GET['order'])) {
			$list_opts['order'] = $_GET['order'];
		}
		
		ob_start();
		?>
		<div class="a4s-cpt-order">
			<a href="<?php echo the_permalink(); ?>?orderby=name&order=ASC" title="Order by Name ASC"><span class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></span></a>&nbsp;
			<a href="<?php echo the_permalink(); ?>?orderby=name&order=DESC" title="Order by Name DESC"><span class="glyphicon glyphicon-sort-by-alphabet-alt" aria-hidden="true"></span></a>&nbsp;
			<a href="<?php echo the_permalink(); ?>?orderby=ID&order=ASC" title="Order by ID/Date ASC"><span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span></a>&nbsp;
			<a href="<?php echo the_permalink(); ?>?orderby=ID&order=DESC" title="Order by ID/Date DESC"><span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span></a>&nbsp;
		</div>
		<div class="a4s-cpt-qs"><input type="text" id="qs" class="qs" value="" placeholder="Type for quick search..."></div>
		<div class="a4s-cpt"><?php 
		$this->getList($list_opts);
		?></div><?php 
		$output = ob_get_clean();
		return $output;
	}
	
	/**
	 * Register widget with Wordpress
	 * 
	 * @since 1.1.0
	 */
	public function register_widget() {
		register_widget('A4s_Addons_Widget_CPT');
	}
	
}
