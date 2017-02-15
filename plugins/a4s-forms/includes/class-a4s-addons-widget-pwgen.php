<?php
/**
 * Adds A4s_Addons_Widget_PwGen widget.
 * 
 * @author Robertas
 * @since 1.2.0
 */
class A4s_Addons_Widget_PwGen extends WP_Widget {
	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'a4s_addons_widget_pwgen', // Base ID
            'A4s Password Generator', // Name
            array( 'description' => __( 'A4s_Addons Widget PwGen Description', 'a4saddons' ), ) // Args
        );
    }
	
	/**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     * 
     * @since 1.2.0
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
    extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		$pwgen_length = (isset($instance['pwgen_length'])) ? $instance['pwgen_length'] : 9;
		$pwgen_count = (isset($instance['pwgen_count'])) ? $instance['pwgen_count'] : 3;
		$pwgen_upper = (isset($instance['pwgen_upper'])) ? $instance['pwgen_upper'] : 'on';
		$pwgen_lower = (isset($instance['pwgen_lower'])) ? $instance['pwgen_lower'] : 'on';
		$pwgen_num = (isset($instance['pwgen_num'])) ? $instance['pwgen_num'] : 'on';
		$pwgen_special = (isset($instance['pwgen_special'])) ? $instance['pwgen_special'] : '';
		
		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
        
        ?>
		<div class="widget-container pwgen">
			<form>
				<div class="input-group pwgen-number col-lg-12">
					<span class="input-group-addon">Length:</span>
					<input type="number" name="pwgen_length" id="pwgen_length" class="text form-control" value="<?php echo $pwgen_length; ?>" aria-describedby="pwgen_length" min="7" max="20" />
				</div>
				
				<div class="input-group pwgen-number col-lg-12">
					<span class="input-group-addon">Count:</span>
					<input type="number" name="pwgen_count" id="pwgen_count" class="text form-control" value="<?php echo $pwgen_count; ?>" aria-describedby="pwgen_count" min="1" max="10" />
				</div>
				
				<div class="input-checkbox pwgen-checkbox col-lg-6">
					<label for="pwgen_upper" class="pwgen-checkbox-label">
						<input type="checkbox" name="pwgen_upper" id="pwgen_upper" class="" <?php checked($pwgen_upper, 'on' ); ?> />
						<?php _e('Uppercase', 'a4s-addons'); ?>
					</label>
				</div>
				
				<div class="input-checkbox pwgen-checkbox col-lg-6">
					<label for="pwgen_lower" class="pwgen-checkbox-label">
						<input type="checkbox" name="pwgen_lower" id="pwgen_lower" class="" <?php checked($pwgen_lower, 'on' ); ?> />
						<?php _e('Lowercase', 'a4s-addons'); ?>
					</label>
				</div>
				
				<div class="input-checkbox pwgen-checkbox col-lg-6">
					<label for="pwgen_num" class="pwgen-checkbox-label">
						<input type="checkbox" name="pwgen_num" id="pwgen_num" class="" <?php checked($pwgen_num, 'on' ); ?> />
						<?php _e('Numbers', 'a4s-addons'); ?>
					</label>
				</div>
				
				<div class="input-checkbox pwgen-checkbox col-lg-6">
					<label for="pwgen_special" class="pwgen-checkbox-label">
						<input type="checkbox" name="pwgen_special" id="pwgen_special" class="" <?php checked($pwgen_special, 'on' ); ?> />
						<?php _e('Special', 'a4s-addons'); ?>
					</label>
				</div>
				
				<div class="input-group pwgen-number col-lg-12">
					<button type="submit" name="submit" class="pwgen_generate btn btn-default"><?php _e( 'Generate', 'a4s-addons' ); ?></button>
				</div>
				
				<div class="input-group col-lg-12">
					<div class="pwgen_output"></div>
				</div>
				
			</form>
		</div>
		<script type="text/javascript">
jQuery('form.pwgen').submit(function(event) {
	event.preventDefault();
});
		</script>
		<?php
		echo $after_widget;
    }
	
	/**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     * 
     * @since 1.2.0
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ( isset( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : __( 'New title', 'a4s-addons' );
		
		$pwgen_length = (isset($instance['pwgen_length'])) ? $instance['pwgen_length'] : 9;
		$pwgen_count = (isset($instance['pwgen_count'])) ? $instance['pwgen_count'] : 3;
		$pwgen_upper = (isset($instance['pwgen_upper'])) ? $instance['pwgen_upper'] : true;
		$pwgen_lower = (isset($instance['pwgen_lower'])) ? $instance['pwgen_lower'] : true;
		$pwgen_num = (isset($instance['pwgen_num'])) ? $instance['pwgen_num'] : true;
		$pwgen_special = (isset($instance['pwgen_special'])) ? $instance['pwgen_special'] : false;
		
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
			
			<label for="<?php echo $this->get_field_id('pwgen_length'); ?>">
				<?php _e('Password length', 'a4s-addons'); ?>
				<input class="widefat" 
					id="<?php echo $this->get_field_id('pwgen_length'); ?>" 
					name="<?php echo $this->get_field_name('pwgen_length'); ?>" 
					type="number" value="<?php echo $pwgen_length; ?>"
					min="7" max="20"
				/>
			</label>
			<br />
			<label for="<?php echo $this->get_field_id('pwgen_count'); ?>">
				<?php _e('Password count', 'a4s-addons'); ?>
				<input class="widefat" 
					id="<?php echo $this->get_field_id('pwgen_count'); ?>" 
					name="<?php echo $this->get_field_name('pwgen_count'); ?>" 
					type="number" value="<?php echo $pwgen_count; ?>"
					min="1" max="10"
				/>
			</label>
			<br />
			<label for="<?php echo $this->get_field_id('pwgen_upper'); ?>">
				<input class="checkbox" 
					id="<?php echo $this->get_field_id('pwgen_upper'); ?>" 
					name="<?php echo $this->get_field_name('pwgen_upper'); ?>" 
					type="checkbox" <?php checked($pwgen_upper, 'on' ); ?>
				/>
				<?php _e('Include uppercase', 'a4s-addons'); ?>
			</label>
			<br />
			<label for="<?php echo $this->get_field_id('pwgen_lower'); ?>">
				<input class="checkbox" 
					id="<?php echo $this->get_field_id('pwgen_lower'); ?>" 
					name="<?php echo $this->get_field_name('pwgen_lower'); ?>" 
					type="checkbox" <?php checked($pwgen_lower, 'on' ); ?>
				/>
				<?php _e('Include lowercase', 'a4s-addons'); ?>
			</label>
			<br />
			<label for="<?php echo $this->get_field_id('pwgen_num'); ?>">
				<input class="checkbox" 
					id="<?php echo $this->get_field_id('pwgen_num'); ?>" 
					name="<?php echo $this->get_field_name('pwgen_num'); ?>" 
					type="checkbox" <?php checked($pwgen_num, 'on' ); ?>
				/>
				<?php _e('Include numbers', 'a4s-addons'); ?>
			</label>
			<br />
			<label for="<?php echo $this->get_field_id('pwgen_special'); ?>">
				<input class="checkbox" 
					id="<?php echo $this->get_field_id('pwgen_special'); ?>" 
					name="<?php echo $this->get_field_name('pwgen_special'); ?>" 
					type="checkbox" <?php checked($pwgen_special, 'on' ); ?>
				/>
				<?php _e('Include special', 'a4s-addons'); ?>
			</label>
		</p>
		<?php
    }
	
	/**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     * 
     * @since 1.2.0
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
		
		$instance['pwgen_length'] = ( isset($new_instance['pwgen_length'])) ? strip_tags( $new_instance['pwgen_length'] ) : '';
		$instance['pwgen_upper'] = ( isset($new_instance['pwgen_upper'])) ? strip_tags( $new_instance['pwgen_upper'] ) : '';
		$instance['pwgen_lower'] = ( isset($new_instance['pwgen_lower'])) ? strip_tags( $new_instance['pwgen_lower'] ) : '';
		$instance['pwgen_num'] = ( isset($new_instance['pwgen_num'])) ? strip_tags( $new_instance['pwgen_num'] ) : '';
		$instance['pwgen_special'] = ( isset($new_instance['pwgen_special'])) ? strip_tags( $new_instance['pwgen_special'] ) : '';
		
		return $instance;
    }
	
	/**
	 * Register widget with Wordpress
	 * 
	 * @since 1.2.0
	 */
	public function register_widget() {
		register_widget('A4s_Addons_Widget_PwGen');
	}
	
}
