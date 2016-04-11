<?php

/*
 * Plugin Name: User Shortcodes Plus
 * Plugin URI: http://kylebjohnson.me/plugins
 * Description: Add simple user shortcodes to WordPress for displaying information about any user.
 * Version: 1.0.0
 * Author: Kyle B. Johnson
 * Author URI: http://kylebjohnson.me
 * Text Domain: user-shortcodes-plus
 *
 * Copyright 2016 Kyle B. Johnson.
 */

final class KBJ_UserShortcodesPlus
{
    /**
     * @var array $userdata[ user_id ][ property ]
     */
    private $userdata = array();

    /**
     * @var array $shortcodes[ tag ] => userdata
     */
    private $shortcodes = array(
        'user_id'           => 'ID',
        'user_login'        => 'user_login',
        'user_email'        => 'user_email',
        'user_firstname'    => 'first_name',
        'user_lastname'     => 'last_name',
        'user_nicename'     => 'user_nicename',
        'user_display'      => 'display_name',
        'user_display_name' => 'display_name',
        'user_registered'   => 'user_registered'
    );

    public function __construct()
    {
        add_action( 'init', array( $this, 'init' ) );
    }

    public function init()
    {
        foreach( $this->shortcodes as $tag => $property ) {
            add_shortcode( $tag, array( $this, 'get_userdata' ) );
        }
        add_shortcode( 'user_meta', array( $this, 'get_user_meta' ) );
    }

    public function get_userdata( $atts, $content, $tag )
    {
        extract( shortcode_atts( array(
            'id' => get_current_user_id(),
        ), $atts ));

        $property = $this->shortcodes[ $tag ];
        $userdata = ( isset( $this->userdata[ $id ] ) ) ? $this->userdata[ $id ] : get_userdata( $id );

        return $userdata->$property;
    }

    public function get_user_meta( $atts )
    {
        extract( shortcode_atts( array(
            'id' => get_current_user_id(),
            'key' => '',
        ), $atts ));
        
        return ( $key ) ? get_user_meta( $id, $key, TRUE ) : '';
    }
}

new KBJ_UserShortcodesPlus();
