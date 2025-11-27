<?php
$date = $widget->get_setting('date', date('Y-m-d H:i', strtotime("+6 days 2 hours 56 minutes 50 seconds")));

$month   = esc_html__( 'Month', 'allianz' );
$months  = esc_html__( 'Months', 'allianz' );
$day     = esc_html__( 'Day', 'allianz' );
$days    = esc_html__( 'Days', 'allianz' );
$hour    = esc_html__( 'Hour', 'allianz' );
$hours   = esc_html__( 'Hours', 'allianz' );
$minute  = esc_html__( 'Minute', 'allianz' );
$minutes = esc_html__( 'Minutes', 'allianz' );
$second  = esc_html__( 'Second', 'allianz' );
$seconds = esc_html__( 'Seconds', 'allianz' );

// Wrap
$widget->add_render_attribute('wrap', [
    'class' => array_filter([
        'cms-countdown-wrap',
        'cms-countdown-'.$settings['layout'],
    ])
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
    <div class="cms-countdown d-flex gutter gutter-grid"
         data-month="<?php echo esc_attr( $month ) ?>"
         data-months="<?php echo esc_attr( $months ) ?>"
         data-day="<?php echo esc_attr( $day ) ?>"
         data-days="<?php echo esc_attr( $days ) ?>"
         data-hour="<?php echo esc_attr( $hour ) ?>"
         data-hours="<?php echo esc_attr( $hours ) ?>"
         data-minute="<?php echo esc_attr( $minute ) ?>"
         data-minutes="<?php echo esc_attr( $minutes ) ?>"
         data-second="<?php echo esc_attr( $second ) ?>"
         data-seconds="<?php echo esc_attr( $seconds ) ?>">
        <div class="cms-countdown-inner" data-count-down="<?php echo esc_attr( $date ); ?>"></div>
    </div>
</div>