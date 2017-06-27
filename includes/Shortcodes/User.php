<?php

final class KBJ_UserShortcodesPlus_Shortcodes_User
{
    private $userdata = array();

    private $shortcodes = array();

    public function __construct()
    {
        $this->shortcodes = KBJ_UserShortcodesPlus::config( 'Shortcodes' );
        foreach( $this->shortcodes as $shortcode ) {
            add_shortcode( $shortcode[ 'tag' ], array( $this, 'do_shortcode' ) );
        }
    }

    public function do_shortcode( $atts, $content, $tag )
    {
        $atts = shortcode_atts( array(
            'id' => get_current_user_id(),
        ), $atts );

        $property = $this->get_property( $tag );
        $userdata = $this->get_userdata( $atts[ 'id' ] );

        if( ! $userdata && defined( 'WP_DEBUG' ) && WP_DEBUG ){
            return '<p>' . sprintf( __( 'User ID %s does not exist.', 'user-shortcodes-plus' ), $atts[ 'id' ] ) . '</p>';
        }

        return ( is_object( $userdata ) ) ? $userdata->$property : '';
    }

    private function get_property( $tag )
    {
        foreach( $this->shortcodes as $shortcode ){
            if( $tag != $shortcode[ 'tag' ] ) continue;
            return $shortcode[ 'property' ];
        }
        return FALSE;
    }

    private function get_userdata( $user_id )
    {
        if( ! isset( $this->userdata[ $user_id ] ) ){
            $this->userdata[ $user_id ] = get_userdata( $user_id );
        }
        return $this->userdata[ $user_id ];
    }
}
