<?php
use Codexpert\Plugin\Table;

$config = array(
	'per_page'     => 5,
	'columns'      => array(
		'id'             => __( 'Order #', 'codesigner' ),
		'products'       => __( 'Products', 'codesigner' ),
		'order_total'    => __( 'Order Total', 'codesigner' ),
		'commission'     => __( 'Commission', 'codesigner' ),
		'payment_status' => __( 'Payment Status', 'codesigner' ),
		'time'           => __( 'Time', 'codesigner' ),
	),
	'sortable'     => array( 'visit', 'id', 'products', 'commission', 'payment_status', 'time' ),
	'orderby'      => 'time',
	'order'        => 'desc',
	'data'         => array(
		array(
			'id'             => 345,
			'products'       => 'Abc',
			'order_total'    => '$678',
			'commission'     => '$98',
			'payment_status' => 'Unpaid',
			'time'           => '2020-06-29',
		),
		array(
			'id'             => 567,
			'products'       => 'Xyz',
			'order_total'    => '$178',
			'commission'     => '$18',
			'payment_status' => 'Paid',
			'time'           => '2020-05-26',
		),
		array(
			'id'             => 451,
			'products'       => 'Mno',
			'order_total'    => '$124',
			'commission'     => '$12',
			'payment_status' => 'Paid',
			'time'           => '2020-07-01',
		),
		array(
			'id'             => 588,
			'products'       => 'Uji',
			'order_total'    => '$523',
			'commission'     => '$22',
			'payment_status' => 'Pending',
			'time'           => '2020-07-02',
		),
		array(
			'id'             => 426,
			'products'       => 'Rim',
			'order_total'    => '$889',
			'commission'     => '$33',
			'payment_status' => 'Paid',
			'time'           => '2020-08-01',
		),
		array(
			'id'             => 109,
			'products'       => 'Rio',
			'order_total'    => '$211',
			'commission'     => '$11',
			'payment_status' => 'Unpaid',
			'time'           => '2020-08-12',
		),
	),
	'bulk_actions' => array(
		'delete' => __( 'Delete', 'codesigner' ),
		'draft'  => __( 'Draft', 'codesigner' ),
	),
);

$table = new Table( $config );
?>
<form method="post">
	<?php
	$table->prepare_items();
	$table->search_box( 'Search', 'search' );
	$table->display();
	?>
</form>
<?php
