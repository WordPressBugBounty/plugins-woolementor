<?php
use Codexpert\CoDesigner\Helper;
use Codexpert\CoDesigner\App\Library_Source;
wp_enqueue_style( 'codesigner-library' );

$library = [];

if ( defined( 'ELEMENTOR_VERSION' ) ) {
	$library = Library_Source::get_library_data();
}

$pages 		= isset( $library['pages'] ) ? $library['pages'] : [];
$blocks 	= isset( $library['blocks'] ) ? $library['blocks'] : [];
$categories = isset( $library['categories'] ) ? $library['categories'] : [];
?>

<?php

$args = [
	'tmpl_blocks' 	=> __( 'Blocks', 'codesigner' ),
	'tmpl_pages' 	=> __( 'Pages', 'codesigner' ),
];
$tab_links = apply_filters( 'wcd_help_tab_link', $args );

echo wp_kses_post("");
echo wp_kses_post("");

?>
<div class='wcd_tab_btns wcd-tmpl-btns'>
	<ul class='wcd_template_tabs wcd-tmpl-content'>
		<?php
		$count 	= 0;
		foreach ( $tab_links as $id => $tab_label ) :
			$active = $count == 0 ? 'active' : '';
			?>
			<li class='wcd_template_tab <?php echo esc_attr( $active ); ?>' id="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $tab_label ); ?></li>
			<?php
			$count++;
		endforeach;
		?>
	</ul>

	<div id='wcd-template-search-box'>
		<select id='wl-template-categories'>
			<option value=""><?php echo esc_attr( __( 'Choose a Category', 'codesigner' ) ); ?></option>
			<?php foreach ( $categories as $key => $category ) : ?>
			<option value='<?php echo esc_attr( $key ); ?>'><?php echo esc_html( $category ); ?></option>
			<?php endforeach; ?>

		</select>
		<input id='wl-template-search' type='text' class='input-search' placeholder="<?php echo esc_attr( __( 'Type to Search...', 'codesigner' ) ); ?>">
		<button class='btn-search'><i class='eicon-search'></i></button>
	</div>
	<div id='wcd-template-sync' class='elementor-templates-modal__header__item clickable'>
		<i class='eicon-sync' aria-hidden='true' title="<?php echo esc_attr( __( 'Sync Library', 'codesigner' ) ); ?>"></i>
		<span class='elementor-screen-only'><?php echo esc_attr( __( 'Sync Library', 'codesigner' ) ); ?></span>
	</div>
</div>

<div class="elementor-templates-modal__header tmpl-admin-template-header" style="display: none;">
	<div class="tmpl-admin-template-logo-area elementor-templates-modal__header__logo-area">
		<div id="elementor-template-library-header-preview-back" class="tmpl-wl-template-library-header-preview-back">
			<i class="eicon-" aria-hidden="true"></i>
			<span><?php esc_attr_e( 'Back to Library', 'codesigner-pro' ); ?></span>
		</div>
	</div>
	<div class="tmpl-admin-template-menu-area elementor-templates-modal__header__menu-area">
		<div class="elementor-component-tab wl__responsive-menu-item elementor-active" data-tab="desktop">
			<i class="eicon-device-desktop" aria-hidden="true" title="Desktop view"></i>
			<span class="elementor-screen-only"><?php esc_attr_e( 'Desktop view', 'codesigner-pro' ); ?></span>
		</div>
		<div class="elementor-component-tab wl__responsive-menu-item" data-tab="tab">
			<i class="eicon-device-tablet" aria-hidden="true" title="Tab view"></i>
			<span class="elementor-screen-only"><?php esc_attr_e( 'Tab view', 'codesigner-pro' ); ?></span>
		</div>
		<div class="elementor-component-tab wl__responsive-menu-item" data-tab="mobile">
			<i class="eicon-device-mobile" aria-hidden="true" title="Mobile view"></i>
			<span class="elementor-screen-only"><?php esc_attr_e( 'Mobile view', 'codesigner-pro' ); ?></span>
		</div>
	</div>
</div>

<div id="tmpl_pages_content" class="wcd_template_content">
	<div id="codesigner-templates" class="wcd-tmpl-wrapper">
		<?php 
		foreach ( $pages as $page ):
			$categories = !is_null( $page['subtype'] ) ? implode(',', array_keys( $page['subtype'] ) ) : '';
			$keywords 	= !is_null( $page['keywords'] ) ? implode(',', array_keys( $page['keywords'] ) ) : '';
			?>
			<div class="import-this elementor-template-library-template-remote" title="<?php echo esc_html( $page['title'] ); ?>">		
				<span style="display:none;"><?php echo  esc_html( $categories ) . " " . esc_html( $keywords ) ?></span>
				<div class="elementor-template-library-template-body">
					<div class="elementor-template-library-template-screenshot" style="background-image: url(<?php echo esc_url( $page['thumbnail'] ); ?>);"></div>
					
					<div class="elementor-template-library-template-preview" data-url="<?php echo esc_url( $page['url'] ); ?>" data-tab="<?php echo esc_html( $page['template_id'] ); ?>">
						<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
					</div>
				</div>

				<div class="elementor-template-library-template-footer">
					<a target="_blank" href="<?php echo esc_url( $page['url'] ); ?>">
						<div class="elementor-template-library-template-name"><?php echo esc_html( $page['title'] ); ?></div>
					</a>
				</div>
			</div>
			<?php
		endforeach; 
		?>
	</div>
	<div class="tmpl-wl-templates-modal-preview-iframe">
    	<iframe></iframe> 
	</div>
</div>

<div id="tmpl_blocks_content" class="wcd_template_content active">
	<div id="codesigner-templates" class="wcd-tmpl-wrapper">
		<?php 
		foreach ( $blocks as $block ):
			$categories = !is_null( $block['subtype'] ) ? implode(',', array_keys( $block['subtype'] ) ) : '';
			$keywords 	= !is_null( $block['keywords'] ) ? implode(',', array_keys( $block['keywords'] ) ) : '';
			?>
			<div class="import-this elementor-template-library-template-remote" title="<?php echo esc_html( $block['title'] ); ?>">
				<span style="display:none;"><?php echo esc_html( $categories ) . " " . esc_html( $keywords ) ?></span>
				<div class="elementor-template-library-template-body">
					<div class="elementor-template-library-template-screenshot" style="background-image: url(<?php echo esc_url( $block['thumbnail'] ); ?>);"></div>
					
					<div class="elementor-template-library-template-preview" data-url="<?php echo esc_url( $block['url'] ); ?>" data-tab="<?php echo esc_html( $block['template_id'] ); ?>">
						<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
					</div>
				</div>

				<div class="elementor-template-library-template-footer">
					<a target="_blank" href="<?php echo esc_url( $block['url'] ); ?>">
						<div class="elementor-template-library-template-name"><?php echo esc_html( $block['title'] ); ?></div>
					</a>
				</div>
			</div>
			<?php
		endforeach; 
		?>
	</div>
	<div class="tmpl-wl-templates-modal-preview-iframe">
    	<iframe></iframe> 
	</div>
</div>

<div id="elementor-template-library-loading" class="tmpl-admin-template-loader" style="display: none;">
	<div class="elementor-loader-wrapper tmpl-wl-loader-wrapper">
		<div class="elementor-loader">
			<img src="<?php echo esc_url( CODESIGNER_ASSETS . '/img/loader.gif' ); ?>">
		<div class="elementor-loading-title">Loading</div>
	</div>
</div></div>