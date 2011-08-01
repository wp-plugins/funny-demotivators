<?php

/*
Plugin Name: Funny Demotivators
Description: Add random funny demotivational pictures to your site . All pictures from demotivators.us.
Tags: widget, pictures , theme, funny , demotivators, motivational posters , gallery , plugin , image , page , site , humor , links , post, cartoons
Version: 0.5 
Tested up to: 2.8.4
Author: darek rycyk
Author URI: http://demotivators.us/info/contact.php
Adds: Page with 8 random demotivational pictures.
License: GPL2
*/

// Feel free change all srcipt
// change option :
// 0 - Add new page to your menu with 8 random demotivators in your blog (http://demotivators.us/widget/8_%20big_demotivators.php)
// 1 - Big images (width 513px) below your posts (source: http://demotivators.us/widget/big_demotivators.php)
// 2 - Small images (width 125px) below menu   (source: http://demotivators.us/widget/small_demotivators.php)
// You can change place of pictures if you change function ad_action
// Action reference  - http://codex.wordpress.org/Plugin_API/Action_Reference
// Demotivators look diffrent in some themes , if user click picture he open new tab with source this picture.

 $option=0;
 

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
	   
	      function multi_demotivators_style(){
               echo'
			       <style type="text/css">			    
				
				   .random_demotivator{
				           margin-top:20px;
				   }
				   #big_font{
				          font-size:19px; 
						      margin-top:30px;
				   }
				   .demotivators_image{				          	
		                   -moz-border-radius:5px;
		                   -webkit-border-radius:5px;
		                    border-radius:10px;
						            margin:0 auto;		
							          border-size:0px;     							       
				     }
          .demotivators_image:hover{
						           box-shadow: 0 4px 9px #000000;						  
					}						   
				
                   	</style>				
			       ';
 
       }

	   
   	$demot_url=get_bloginfo('url'); // Get site URL , it will let me make list the best blogs using this plugin ,  10 the best blogs can get links from my site.
	   
   if($option == 0){
                      // option 0 generate new page with 8 random demotivators
			

          // add css to site			
	      add_action( 'wp_head', 'multi_demotivators_style');
   
                  
   
      // add demotivators to your menu
 if ( !function_exists('fb_add_page_link') ) {
    function fb_add_page_link($output) {
    $output .= '<li><a href="'.$demot_url.'?c=demotivators&p=9999999990">Demotivators</a></li>';
    return $output;
    }
    add_filter('wp_list_pages', 'fb_add_page_link');
  }


     // generate new page with demotivators
  
if($_GET['p']==9999999990 && $_GET['c']=='demotivators'){

if (!class_exists('Memberlist_Plugin'))
{
  class Memberlist_Plugin
  {
    public $_name;
    public $page_title;
    public $page_name;
    public $page_id;

    public function __construct()
    {
      $this->_name      = 'demotivators';
      $this->page_title = 'demotivators';
      $this->page_name  = $this->_name;
      $this->page_id    = '0';

      register_activation_hook(__FILE__, array($this, 'activate'));
      register_deactivation_hook(__FILE__, array($this, 'deactivate'));
      register_uninstall_hook(__FILE__, array($this, 'uninstall'));

      add_filter('parse_query', array($this, 'query_parser'));
      add_filter('the_posts', array($this, 'page_filter'));
    }

    public function activate()
    {
      global $wpdb;      

      delete_option($this->_name.'_page_title');
      add_option($this->_name.'_page_title', $this->page_title, '', 'yes');

      delete_option($this->_name.'_page_name');
      add_option($this->_name.'_page_name', $this->page_name, '', 'yes');

      delete_option($this->_name.'_page_id');
      add_option($this->_name.'_page_id', $this->page_id, '', 'yes');

      $the_page = get_page_by_title($this->page_title);

      if (!$the_page)
      {
        // Create post object
        $_p = array();
        $_p['post_title']     = $this->page_title;
        $_p['post_content']   = "This text may be overridden by the plugin. You shouldn't edit it.";
        $_p['post_status']    = 'publish';
        $_p['post_type']      = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status']    = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $this->page_id = wp_insert_post($_p);
      }
      else
      {
        // the plugin may have been previously active and the page may just be trashed...
        $this->page_id = $the_page->ID;

        //make sure the page is not trashed...
        $the_page->post_status = 'publish';
        $this->page_id = wp_update_post($the_page);
      }

      delete_option($this->_name.'_page_id');
      add_option($this->_name.'_page_id', $this->page_id);
    }

    public function deactivate()
    {
      $this->deletePage();
      $this->deleteOptions();
    }

    public function uninstall()
    {
      $this->deletePage(true);
      $this->deleteOptions();
    }

    public function query_parser($q)
    {
      if(isset($q->query_vars['page_id']) AND (intval($q->query_vars['page_id']) == $this->page_id ))
      {
        $q->set($this->_name.'_page_is_called', true);
      }
      elseif(isset($q->query_vars['pagename']) AND (($q->query_vars['pagename'] == $this->page_name) OR ($_pos_found = strpos($q->query_vars['pagename'],$this->page_name.'/') === 0)))
      {
        $q->set($this->_name.'_page_is_called', true);
      }
      else
      {
        $q->set($this->_name.'_page_is_called', false);
      }
    }

    function page_filter($posts)
    {
      global $wp_query;

      if($wp_query->get($this->_name.'_page_is_called'))
      {
	    $demot_url=get_bloginfo('url');
        $posts[0]->post_title = __('Motivational Posters');
        $posts[0]->post_content = @file_get_contents('http://demotivators.us/widget/8_%20big_demotivators.php?site='.$demot_url).'<a id="big_font" href="'.$demot_url.'?c=demotivators&p=9999999990">Random new demotivators</a>'; 
	
		
      }
      return $posts;
    }

    private function deletePage($hard = false)
    {
      global $wpdb;

      $id = get_option($this->_name.'_page_id');
      if($id && $hard == true)
        wp_delete_post($id, true);
      elseif($id && $hard == false)
        wp_delete_post($id);
    }

    private function deleteOptions()
    {
      delete_option($this->_name.'_page_title');
      delete_option($this->_name.'_page_name');
      delete_option($this->_name.'_page_id');
    }
  }
}
$memberlist = new Memberlist_Plugin();

}

                    
   
   
   
   
   
   }
	   
	   
	   


    elseif($option == 1){
	                  // Option 1 big demotivators
	         function get_image_big() 
			 
             {  	
			    if ( !is_home() || !is_front_page() ){ // this line remove demotivators from home page
                   	$demot_url=get_bloginfo('url');
					echo @file_get_contents('http://demotivators.us/widget/big_demotivators.php?site='.$demot_url);	 
                
				}
			   
             }
	         
			
			  
                  add_action( 'loop_end', 'get_image_big');
				  add_action( 'wp_head', 'demotivators_style'); 
			
	
     }
	 
	else{
	            // Option 2 small  demotivators
	     function get_image_small() 
         {
		   	$demot_url=get_bloginfo('url');
            echo @file_get_contents('http://demotivators.us/widget/small_demotivators.php?site='.$demot_url);	   
      
         }
	     
         add_action( 'wp_meta', 'get_image_small');
		 add_action( 'wp_head', 'demotivators_style');
    } 