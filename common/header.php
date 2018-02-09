<?php

$is_home_page = isset($bodyid) && $bodyid === 'home';


?><!DOCTYPE html>
<html lang="<?= get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=yes"/>
    <?php if ($description = option('description')): ?>
        <meta name="description" content="<?= $description; ?>"/>
    <?php endif; ?>
    <?php
    if (isset($title)) {
        $titleParts[] = strip_formatting($title);
    }
    $titleParts[] = option('site_title');
    ?>
    <title><?= implode(' &middot; ', $titleParts); ?></title>

    <?= auto_discovery_link_tags(); ?>

    <!-- Plugin Stuff -->
    <?php fire_plugin_hook('public_head', array('view' => $this)); ?>

    <!-- Stylesheets -->
    <?php
    queue_css_file(array('style', 'iconfonts'));
    queue_css_url('https://fonts.googleapis.com/css?family=Crimson+Text:400,400italic,700,700italic');
    echo head_css();
    echo $this->partial('common/custom_colors.php');
    ?>

    <!-- JavaScripts -->
    <?php
    queue_js_file(array('globals'));
    queue_js_file(array('centerrow'), 'js');
    echo head_js();
    ?>
</head>

<?= body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
<a href="#content" id="skipnav"><?= __('Skip to main content'); ?></a>
<?php fire_plugin_hook('public_body', array('view' => $this)); ?>

<div id="wrap">

    <header role="banner" id="hero">

        <?php fire_plugin_hook('public_header', array('view' => $this)); ?>

        <div id="hero-wrapper">

            <div id="site-title"><?= link_to_home_page(theme_logo()); ?>
                <span class="site-subtitle">Drawings of the American Civil War</span>
            </div>

            <?php if (!$is_home_page): ?>
                <div id="search-container" role="search">
                    <?php if (get_theme_option('use_advanced_search') === null || get_theme_option(
                            'use_advanced_search'
                        )): ?>
                        <?= search_form(
                            array(
                                'show_advanced'   => true,
                                'form_attributes' => array('role' => 'search', 'class' => 'open')
                            )
                        ); ?>
                    <?php else: ?>
                        <?= search_form(
                            array(
                                'show_advanced'   => false,
                                'form_attributes' => array('role' => 'search', 'class' => 'open')
                            )
                        ); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <nav id="top-nav" role="navigation">
            <?= public_nav_main(); ?>
        </nav>

        <?= theme_header_image(); ?>


        <?php if ($is_home_page): ?>
            <?= search_form(
                array(
                    'show_advanced'   => false,
                    'form_attributes' => array('role' => 'search', 'class' => 'open homepage-search')
                )
            ); ?>
        <?php endif; ?>
    </header>

    <article id="content" role="main">

        <?php fire_plugin_hook('public_content_top', array('view' => $this)); ?>
