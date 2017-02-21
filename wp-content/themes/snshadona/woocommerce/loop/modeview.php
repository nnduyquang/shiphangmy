<?php
if (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'grid') {
    $modeview = 'grid';
}elseif (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'list') {
    $modeview = 'list';
}
elseif (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'list-table') {
    $modeview = 'list-table';
}
?>
<ul class="mode-view pull-left">
    <li class="grid1">
    	<a class="grid<?php echo ($modeview=='grid')?' active':''; ?>" data-mode="grid" href="#" title="<?php echo esc_html__('Grid', 'snshadona'); ?>">
    		<span><?php echo esc_html__('Grid', 'snshadona'); ?></span>
    	</a>
    </li>
    <li class="list1">
    	<a class="list<?php echo ($modeview=='list')?' active':''; ?>" data-mode="list" href="#" title="<?php echo esc_html__('List', 'snshadona'); ?>">
            <span><?php echo esc_html__('List', 'snshadona'); ?></span>
        </a>
    </li>
     <li class="list-table1">
        <a class="list-table<?php echo ($modeview=='list-table')?' active':''; ?>" data-mode="list-table" href="#" title="<?php echo esc_html__('List Table', 'snshadona'); ?>">
            <span><?php echo esc_html__('List Table', 'snshadona'); ?></span>
        </a>
    </li> 
</ul>