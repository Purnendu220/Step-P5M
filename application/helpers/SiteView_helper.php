<?php 
function admin_template($template_name, $vars = array(), $return = FALSE)
{
	$CI =& get_instance();
	$content  = $CI->view('admin/cl_admin_templates/header', $vars, $return); // header
	$content  = $CI->view('admin/cl_admin_templates/sidebar', $vars, $return); // sidebar
	$content .= $CI->view($template_name, $vars, $return); // view
	$content .= $CI->view('admin/cl_admin_templates/footer', $vars, $return); // footer 		
	return $content;
}
?>