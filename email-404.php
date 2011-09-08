<?php
/*
Plugin Name: Email 404
Plugin URI: http://jfoucher.com/email-404
Description:Sends email on 404 error
Version: 0.3.1
Author: Jonathan Foucher
Author URI: http://jfoucher.com


Copyright 2009 Jonathan Foucher

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */

function email_admin($location){
	$name=get_option('blogname');
	$email = get_option('admin_email');
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/plain; charset=UTF-8\r\n";
	$headers .= 'From: "' . $name . '" <' .$email. ">\r\n";
	$headers .= 'Reply to: "' . $email .  "'>\r\n";
	$subject='404 error in '.$name;
	$body='A 404 error occured at the following url: '.$_SERVER['SERVER_NAME'].$location."\r\n
Referrer: ".$_SERVER['HTTP_REFERER'];

	@mail($email,$subject,$body,$headers);


}

function email_error(){
	global $wp_query;
	$location=$_SERVER['REQUEST_URI'];

	if ($wp_query->is_404){
		email_admin($location);
	}
}

add_action('get_header', 'email_error');
