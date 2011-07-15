=== Funny demotivators ===

Contributors: Funny Demotivators
Description: Add random funny demotivational pictures to your site . All pictures from demotivators.us.
Tags: widget, pictures , theme, funny , demotivators, motivational posters , gallery , plugin , image
Version: 0.2 
Tested up to: 2.8.4
Author: darek rycyk
Author URI: http://demotivators.us/info/contact.php
Plugin URI: Plugin URI: http://demotivators.us/trunk/
Adds: One random picture below your all posts
License: GPL2

== Description ==

This widget let you have funny demotivational pictures below your all post or if you set $option=2 mini 
pictures below side bar. 


This script only read random pictures from this url http://demotivators.us/widget/big_demotivators.php
or small pictures from here http://demotivators.us/widget/small_demotivators.php . All pictures are checked my modreator so 
no porn , no ofensive , no racist but you can check pictures here in home page http://demotivators.us
If user click some picture he open new tab with source of picture. Picture look like diffrent in diffrent themes 
so you can edit css style in funny_demotivators.php

 function demotivators_style(){
               echo'
			       <style type="text/css">
			           .demotivators_link{
				   	    	padding-top:20px;
						padding-bottom:20px;	                       							
				   }
				   .demotivators_image{
				           border:0px solid #1F1F1F;
		                           -moz-border-radius:5px;
		                           -webkit-border-radius:5px;
		                           border-radius:10px;
					   margin:0 auto;							
				     }					   
				     .demotivators_image:hover{
					  box-shadow: 0 5px 19px #000000;						  
			    		}	
                   	         </style>				
			        ';
 
       }



== Installation ==
Plugin have only one  file


Here it is in graphic form:


- wp-content
	- plugins
		- widgets
			| funny_demotivators.php
	


