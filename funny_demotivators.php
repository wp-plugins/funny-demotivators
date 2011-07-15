<?php

/*
Plugin Name: Funny Demotivators
Description: Add random funny demotivational pictures to your site . All pictures from demotivators.us.
Tags: widget, pictures , theme, funny , demotivators, motivational posters , gallery , plugin , image
Version: 0.2 
Tested up to: 2.8.4
Author: darek rycyk
Author URI: http://demotivators.us/info/contact.php
Adds: One random picture below your all posts
License: GPL2
*/

// Feel free change all srcipt
// change option :
// 1 - Big images (width 513px) below your posts (source: http://demotivators.us/widget/big_demotivators.php)
// 2 - Small images (width 125px) below menu   (source: http://demotivators.us/widget/small_demotivators.php)
// You can change place of pictures if you change function ad_action
// Action reference  - http://codex.wordpress.org/Plugin_API/Action_Reference
// Demotivators look diffrent in some themes , if user click picture he open new tab with source this picture.

 $option=1;
 

      // CSS style  

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

      add_action( 'wp_head', 'demotivators_style');
	   
	   
	   


    if($option == 1){
	                  // Option 1 big demotivators
	         function get_image_big() 
			 
             {  	
			    if ( !is_home() || !is_front_page() ){ // this line remove demotivators from home page
                    
					echo @file_get_contents('http://demotivators.us/widget/big_demotivators.php');	 
                
				}
			   
             }
	         
			
			  
                  add_action( 'loop_end', 'get_image_big');
				  
			
	
     }
	 
	else{
	            // Option 2 small  demotivators
	     function get_image_small() 
         {
            echo @file_get_contents('http://demotivators.us/widget/small_demotivators.php');	   
      
         }
	
         add_action( 'wp_meta', 'get_image_small');
    } 