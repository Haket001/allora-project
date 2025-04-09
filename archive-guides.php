<?php get_header();

if (function_exists('the_breadcrumbs')) {
    the_breadcrumbs();
}
?>
<?php get_template_part('template_parts/archive/archive', 'guides') ?>

<?php get_footer()?>