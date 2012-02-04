<?php

 /*
Plugin Name: Demotivational Post
Description: Demotivational Post widget add to your website new page with  big collection of Demotivational Posters . All pictures hosting in http://demotivationalpost.com so you don't pay for transfer. If user click some picture he open new tab with source of picture. All pictures are checked by moderator and  will be grabbed from home page  http://demotivationalpost.com , you can see how working this widget in my  sample blog http://funmot.com/english/Demotivational-posters/ .If plugin not work good try to disable recent posts or use another theme.
Tags: widget, pictures , posters,theme, funny , demotivators, motivational posters , gallery , plugin , image , page , site , humor , links , post, cartoons , funny demotivators , demotivational posters , demotivationalpost.com , demotivational post
Version: 1.2 
Tested up to: 3.3.1
Author: Darek Rycyk
Author URI: http://demotivationalpost.com/info/contact.php
Adds: Page with 8 random demotivational pictures.
License: GPL2
*/

     

	   
 class demotivators{
       
    
	   
	    public static $page_id;   
        public static $pictures_8;    
		public static $count_pages;    	
	    public static $picture_1;  
			
			private static function add_new_page($wpdb){
			
			                 // add new demotivators page 
							 
							 $add_page="INSERT INTO `".$wpdb->prefix."posts` (	`ID` , `post_author` , `post_date` , `post_date_gmt` , `post_content` , `post_title` ,
                                               `post_excerpt` , `post_status` , `comment_status` , `ping_status` , `post_password` , `post_name` , `to_ping` , `pinged` , `post_modified` , `post_modified_gmt` ,`post_content_filtered` , `post_parent` , `guid` , `menu_order` , `post_type` , `post_mime_type` , `comment_count` )
                                                VALUES ( NULL , '0', CURDATE( ) , CURDATE( ) , '', 'Demotivational', '', 'publish', 'closed', 'closed', '', 'Demotivational-posters', '', '', CURDATE( ) , CURDATE( ) , '', '0', '', '0', 'page', '', '0' );";                 
			                          
									            $wpdb->query($add_page);          
			  
			 }
			
			
			private static function get_demotivator_id(){
			
			                return $_GET['demotivator'];       
			
			}
			
			
		  	public function get_page_id(){
			                 
  							    			   
							    
								global $wpdb;   // wordpress class for mysql 
                                 
								//check demotivators page id 
				 				              
                                $get_post_id = $wpdb->get_var("SELECT * FROM `".$wpdb->prefix."posts` WHERE `post_title` = 'Demotivational' AND `post_name` = 'Demotivational-posters' LIMIT 1"); 
			           
					            // add if demotivators page is not exist
           
                                 if(empty($get_post_id)){
								 
                            	 	         // add page	
											 
			                                  $this->add_new_page($wpdb);   
									
			                                  // get page id                     
			                                  
											  $get_post_id = $wpdb->get_var("SELECT * FROM `".$wpdb->prefix."posts` WHERE `post_title` = 'Demotivational' AND `post_name` = 'Demotivational-posters' LIMIT 1"); 
			                       			         																					
									          $get_post_id=(int)$get_post_id;        
                                              
					             }
								      
								demotivators::$page_id = $get_post_id;					                
					             
            }
		   
		   
		    
		    public function check_current_page(){		
                                    
				                  	if( is_page(demotivators::$page_id) and !isset($_GET['demotivator'])){									
		                                   
					                           return 1;
		  
		                            }
		                         
				                    elseif( is_page(demotivators::$page_id) and isset($_GET['demotivator'])){	
									
			                                  
                                               return 2;      
			               
				                     }
				                     
                                    else{
                           
                                               return 3;   
                                    }   
					 
		    }	  
			  
			public function get_demotivators_page(){	 
                                
								  if(empty($_GET['demotivators_page']) or  $_GET['demotivators_page'] == 0 or $_GET['demotivators_page'] == 1){
                        	          $demotivators_page=1;
                        	      }
                        	      else{
                        	          $demotivators_page=$_GET['demotivators_page'];
                        	      }                        	      							     
								 
								  return $demotivators_page;							 
								 
			                  
            }     
			
			public function import_8_pictures_from_demotivators_us(){	
                             
							    $demotivators_from_base = @file_get_contents('http://demotivationalpost.com/widget/wordpress/page.php?site='.get_bloginfo('url').'&demotivators_page='.$this->get_demotivators_page());
			                    
								return demotivators::$pictures_8 = $demotivators_from_base;
              
            } 

			public function import_1_picture_from_demotivators_us(){	
                             
							    $demotivator_from_base_1 = @file_get_contents('http://demotivationalpost.com/widget/wordpress/demotivator.php?site='.get_bloginfo('url').'&demotivator='.$this->get_demotivator_id());
			                    self::$picture_1=explode('[=<>=]', $demotivator_from_base_1);						  
                             
            } 
			
			
			public function generate_html_code($demotivators_from_base){	
			
			                //==================================
							
							
							 if(!empty($demotivators_from_base)){
                                 
                                       $count_pages = explode('==[count_page]==',$demotivators_from_base);
                                                 if(  (empty($count_pages[1])) or ($count_pages[1] == 0) ){
                                                       $count=40;
                                                 }
                                       demotivators::$count_pages = (int)$count_pages[1];
                                    
                                       $images = explode('=[nl]=',$count_pages[0]); 
                                    
                                                          
                                  
                                    foreach($images as $index => $img){
                                    
                                                   
                                                    $img_tab = explode('=[--]=',$img); 
                                                    
                                                    $demotivator_url = get_bloginfo('url').'/'.$_SERVER['REQUEST_URI'];
                                                    $REQUEST_URI = $_SERVER['REQUEST_URI'];
                                                    $varname='demotivators_page';
                                                    $demotivator_url = preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$REQUEST_URI);
                                                    
                                                     if ( (strpos($_SERVER['REQUEST_URI'] , '?') == true ) && !empty($img_tab[5]) ) {
                                                           
                                                                  $mot = '<a class="fun_demotivator_8_simple_pic" title="'.$img_tab[1].' demotivator " href="'.$demotivator_url.'&demotivator='.trim($img_tab[0]).'" ><img alt="'.$img_tab[1].' demotivators demotivational posters '.$img_tab[2].'" src="http://demotivationalpost.com/motivators/'.$img_tab[4].'/'.$img_tab[5].'" /></a>';
                                                                  $mot = str_replace('&&','&',$mot);
																  $mot = str_replace('?&','?',$mot);
                                                                  echo $mot;
                                                      }
                                                     elseif(  (strpos($_SERVER['REQUEST_URI'] , '?') == false ) && !empty($img_tab[5]) ){
                                                     
                                                                  $mot = '<a class="fun_demotivator_8_simple_pic" title="'.$img_tab[1].' demotivator " href="'.$demotivator_url.'?demotivator='.trim($img_tab[0]).'" ><img alt="'.$img_tab[1].' demotivators demotivational posters '.$img_tab[2].'" src="http://demotivationalpost.com/motivators/'.$img_tab[4].'/'.$img_tab[5].'" /></a>';
                                                                  $mot = str_replace('&&','&',$mot); 
																  $mot = str_replace('?&','?',$mot);
																 
                                                                  echo $mot;
                                                     }
                                  
                                  
                                  
                                  
                                  
                                    }
                                 
                                 }         
							
							
							//===========================
			
			} 
			
			public function get_next_and_prev_page(){
			
			                if( $this->get_demotivators_page() == 1){
															    
									    $next_prev[0]=demotivators::$count_pages; 
										$next_prev[1]=2;
									
										return $next_prev;
										
							}
							elseif( $this->get_demotivators_page() == demotivators::$count_pages){
                                                          
                                        $next_prev[0]=(demotivators::$count_pages)-1;
										$next_prev[1]=1;
										
										return $next_prev;
							
							}
							else{
										
										$next_prev[0]=($this->get_demotivators_page())-1;
										$next_prev[1]=($this->get_demotivators_page())+1;											
										return $next_prev;
										
							}    
			
			}
			
			public function get_url_last_and_first_page($url_type){
			
			            //true - url with "?" key
			
			            if($url_type == true){
						      
							                                     //==========================
															   $next = preg_replace('/([?&])'.'demotivators_page'.'=[^&]+(&|$)/','$1',$_SERVER['REQUEST_URI']);
															   $next_page= $this->get_next_and_prev_page();															   
															   $next.='&demotivators_page='.$next_page[0];
															   $next_page = str_replace('?&','?',$next_page);
															   $code.='<a href="'.$next.'"> <img class="fun_demotivator_float_right"  src="http://demotivationalpost.com/img/forward.png"> </a>';
                                                               //======================= 
							  
							                                  
							                                     //==========================
															   $next = preg_replace('/([?&])'.'demotivators_page'.'=[^&]+(&|$)/','$1',$_SERVER['REQUEST_URI']);
															   $next_page= $this->get_next_and_prev_page();															   
															   $next.='&demotivators_page='.$next_page[1];
															   $next_page = str_replace('?&','?',$next_page);
															   $code.='<a href="'.$next.'"> <img class="fun_demotivator_float_left" src="http://demotivationalpost.com/img/previous.png"> </a>';
                                                               //======================= 
						
						}
						else{
						                                          //==========================
															   $next = preg_replace('/([?&])'.'demotivators_page'.'=[^&]+(&|$)/','$1',$_SERVER['REQUEST_URI']);
															   $next_page= $this->get_next_and_prev_page();															   
															   $next.='?demotivators_page='.$next_page[0];
															   $next_page = str_replace('?&','?',$next_page);
															   $code.='<a href="'.$next.'"> <img class="fun_demotivator_float_right" src="http://demotivationalpost.com/img/forward.png"> </a>';
                                                               //======================= 
							  
							                                  
							                                     //==========================
															   $next = preg_replace('/([?&])'.'demotivators_page'.'=[^&]+(&|$)/','$1',$_SERVER['REQUEST_URI']);
															   $next_page= $this->get_next_and_prev_page();															   
															   $next.='?demotivators_page='.$next_page[1];
															   $next_page = str_replace('?&','?',$next_page);
															   $code.='<a href="'.$next.'"> <img class="fun_demotivator_float_left" src="http://demotivationalpost.com/img/previous.png"> </a>';
                                                               //======================= 
						
						}
			         
                        echo'<div id="fun_demotivator_strzalki_with">'.$code.'</div>';					 
			}
			
			public function pagination(){
			
			//===============================================================================
			
			
			                     //paginacja
                                   
								
									
                    if (strpos($_SERVER['REQUEST_URI'] , '?') == true) {
                             	        
                                if(!empty(demotivators::$pictures_8)){                                                                   
                                                                                                                         
                                                                
                                                               $REQUEST_URI = $_SERVER['REQUEST_URI'];
                                                               $varname='demotivators_page';
                                                              
                                                               $REQUEST_URI = str_replace('&&','&',$REQUEST_URI);
															   $REQUEST_URI = str_replace('?&','?',$REQUEST_URI);
                                                               $REQUEST_URI = preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$REQUEST_URI);                                                                 
                                                               
															 
															   
                                }
                                else{
                                                      
                                                               $REQUEST_URI = $_SERVER['REQUEST_URI'];
                                                         
                                }
                                        $this->get_url_last_and_first_page(true);
										
                                        echo'<div class="fun_demotivator_paginate" ><ul>'; 
                                                for($i=1;$i<=demotivators::$count_pages;$i++){
                                                  
                                                      
                                                        if( (round($i/15) * 15) == $i ){
                                                                  // echo '</br>';
                                                        }
                                                      
                                                        if( ($REQUEST_URI[strlen($REQUEST_URI) - 1]) == '&'   ){
                                                                    
                                                                        echo'<li><a  href="'.$REQUEST_URI.'demotivators_page='.$i.'">'.$i.'</a></li>';
                                                                        
                                                        }
                                                        else{
                                                                        
                                                                         echo'<li><a  href="'.$REQUEST_URI.'&demotivators_page='.$i.'">'.$i.'</a></li>';
                                                                    
                                                        }
                                                }
                                                        echo'</ul></div>';           
                                     
									        
									 
									 
                    }
                                    
                    else{
                                     
                                         $this->get_url_last_and_first_page(false);
										 
                                         echo'<div class="fun_demotivator_paginate"  ><ul>';       
                                                 
                                                    if(!empty(demotivators::$pictures_8)){
                                                    
                                                         $REQUEST_URI = $_SERVER['REQUEST_URI'];
                                                         $REQUEST_URI = str_replace('&demotivators_page='.$_GET['demotivators_page'],'',$REQUEST_URI);
                                                         $REQUEST_URI = str_replace('?&','?',$REQUEST_URI);                                                      
                                                      }
                                                      else{
                                                      
                                                          $REQUEST_URI = $_SERVER['REQUEST_URI'];
                                                         
                                                      }
                                                 
                                                  for($i=1;$i<=demotivators::$count_pages;$i++){
                                                  
                                                      
                                                      if( (round($i/15) * 15) == $i ){
                                                        // echo '</br>';
                                                      }
                                                      
                                                    
                                                      
                                                      echo'<li  ><a  href="'.$REQUEST_URI.'?demotivators_page='.$i.'">'.$i.'</a></li>';
                                                      }
                                            echo'</ul></div>';         
                                                  
                                                  
                                         }
			
			
			//=================================================================================
			
			}
			
			
			
 }           
 
 
 
 
 
 
 
 
 
     // Generate title and meta tags

 
  
     add_filter( 'wp_title', 'custom_title', 20 );

     function custom_title( $title ) {
	      
		 $demot_title = new demotivators;	         
		 $demot_title->get_page_id();
		
		 
		               if( ($demot_title->check_current_page() == 1) or  $demot_title->check_current_page() == 2  ){
					   
                                    $demot_title->import_1_picture_from_demotivators_us();
									remove_action('wp_head', 'rsd_link');
                                    remove_action('wp_head', 'feed_links', 2);
                                    remove_action('wp_head', 'index_rel_link');
                                    remove_action('wp_head', 'wlwmanifest_link');
                                    remove_action('wp_head', 'feed_links_extra', 3);
                                    remove_action('wp_head', 'start_post_rel_link', 10, 0);
                                    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
                                    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
                                    remove_action('wp_head', 'index_rel_link');
                                    remove_action('wp_head', 'rel_canonical');	
                                    remove_action( 'wp_head', 'wp_generator'); 
                                    remove_action(wp_head, adjacent_posts_rel_link_wp_head, 10, 0 ); 

													   
                       }					   
				      
				 
				       if( $demot_title->check_current_page() == 1 ){
					   
				                   add_action( 'wp_head', 'addMeta');
				                   $title.=' '.$_GET['demotivators_page'].' ';
								   
				        }
					   
					   
					   elseif( $demot_title->check_current_page() == 2 ){
                               
   							      add_action( 'wp_head', 'addMeta'); // add canonical tag , it make blog more seo friendly								 
							      $title.=' '.demotivators::$picture_1[1].' '.demotivators::$picture_1[4]; // change title
								
								  
							 
				        }              	       
	             
	         
			 $demot_title = NULL;
			 
             return $title; 
		
    }

 
 
 
    // Import demotivators 
 
    add_action( 'loop_start', 'import_images');
 
    function import_images(){
	
	           $demot_import = new demotivators;	         
			  
			  
			            if( $demot_import->check_current_page() == 1 ){
			   
			                        echo '<div id="fun_demotivator_8_demot" > <h1 id="fun_demotivator_logo_h1" >Demotivational Post</h1>';
			  
		                            $demot_import->import_8_pictures_from_demotivators_us();	     
			   
			                        $demot_import->generate_html_code(demotivators::$pictures_8);	

									$demot_import->pagination();

									echo'</div>'; 
									
                         }
						 
			            elseif( $demot_import->check_current_page() == 2 ){
	                              
								      echo'<div id="fun_demotivator_1_demot">';
									  
	                                  echo '<h3 id="fun_demotivator_h3" >'.demotivators::$picture_1[1].'</h3>'; 
	                                  echo demotivators::$picture_1[0];  
									
									  
									  $prev_url =str_replace($_GET['demotivator'],demotivators::$picture_1[2],$_SERVER['REQUEST_URI']);
									  $next_url =str_replace($_GET['demotivator'],demotivators::$picture_1[3],$_SERVER['REQUEST_URI']);
									
									  echo'<div id="fun_demotivator_1_demot_footer" >';   
									  echo'<a  href="'.$prev_url.'" ><img class="fun_demotivator_float_left" src="http://demotivationalpost.com/img/previous.png" /></a>';  
									  echo'<a  href="'.$next_url.'" ><img class="fun_demotivator_float_right" src="http://demotivationalpost.com/img/forward.png" /></a>';  
								      echo '</div></br></br></br></br>';
									 
									   
									  echo'<h4> Demotivational posters always demotivate you. LOL! </h4>';
								 
								      echo'</div>';
									 
	                    } 
						
	    $demot_import = NULL;
  
	}
   
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 //====================================================
 
 // add very important canonical tag 
 
  function addMeta(){
  
                     $pageURL = 'http';
                     if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
                              $pageURL .= "://";
                     if ($_SERVER["SERVER_PORT"] != "80") {
                     $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
                     } else {
                     $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
                     }
                     
					 if ( $_GET['demotivators_page'] == 1) {
					     $pageURL=str_replace('?demotivators_page=1','',$pageURL);
						 $pageURL=str_replace('&demotivators_page=1','',$pageURL);
					 }
                         echo '<link rel="canonical" href="'.$pageURL.'" />';
                         echo '<meta name="robots" content="all" />';
						 echo '<meta name="Keywords" content="demotivators,motivators,posters,demotivational posters,demotivation" />';
                         echo '<meta name="Description" content="Funny demotivators collection" />';



   }
  
 

 
// off coments in page with one demotivator 

      
 
 


















 function demotivators_style(){
               $css_style='			   
			        <style type="text/css">
				
					
				   	
				 
				           #fun_demotivator_logo_h1{
						            font-size:20px !important;
						            text-shadow: 1px 0px 1px #000;
									font-family:serif;
						   }
						   .fun_demotivator_8_simple_pic img{
						   
						             -moz-border-radius:5px;
		                             -webkit-border-radius:5px;
						             border:0px solid #1F1F1F;
						             border-radius:10px;
						             margin:0 auto;		
									 margin-top: 20px; !important; 	
									 margin-bottom:5px; !important; 	
							}		 
						   .fun_demotivator_8_simple_pic img:hover {		
						            
		                              box-shadow: 5px 4px 8px #000000;		                            
						           					   
						   }
				           .fun_demotivator_float_right{
						   
						              float:right;
						   
						   }
						   .fun_demotivator_float_left{
						      
							          float:left;
							   
						   }
				           #fun_demotivator_8_demot{
						               width:520px; 
									   margin:0 auto; 
						   }
				           #fun_demotivator_1_demot{
                                      width:620px;
									  margin:0 auto;
                           }
                         						  
				 
                            .fun_demotivator_paginate{							
							            
					                    width:500px; 									   
									    margin:0 auto;									
					  
				             }
							 
							 .fun_demotivator_paginate li{
							          
				                           list-style: none; 
										   display: inline-block;
							               z-index: 1;
										  margin:4px;
										   
										   
										   
										   
										   
										   
										  
							 }
							 
							 .fun_demotivator_paginate li a{
							 
							             float:left;
							             padding:2px;	
                                         padding-left:6px;
                                         padding-right:6px;										 
							             z-index: 2;								
										 -moz-border-radius: 3px;
                                        -webkit-border-radius: 3px;              
                                        -o-border-radius: 3px;
                                        -ms-border-radius: 3px;
                                        -khtml-border-radius: 3px;
                                         border-radius: 3px;
                                        -moz-box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
                                         -webkit-box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
                                        -o-box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
                                        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
										 border-top: 1px solid #fff;
									    text-decoration: none !important;
  color: #717171 !important;
  font-size: smaller !important;
  font-family: "Helvetica Neueu", Helvetica, Arial, sans-serif;
  text-shadow: white 0 1px 0;
  background-color: #f5f5f5;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#f9f9f9), to(#eaeaea));
  /* Saf4+, Chrome */
  background-image: -webkit-linear-gradient(top, #f9f9f9, #eaeaea);
  /* Chrome 10+, Saf5.1+ */
  background-image: -moz-linear-gradient(top, #f9f9f9, #eaeaea);
  /* FF3.6 */
  background-image: -ms-linear-gradient(top, #f9f9f9, #eaeaea);
  /* IE10 */
  background-image: -o-linear-gradient(top, #f9f9f9, #eaeaea);
  /* Opera 11.10+ */
  background-image: linear-gradient(top, #f9f9f9, #eaeaea);
										
										
  
									  
										

							 }
							 
							.fun_demotivator_paginate a:hover, .fun_demotivator_paginate a:focus {
   border-color: #fff;
  background-color: #fdfdfd;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#fefefe), to(#fafafa));
  /* Saf4+, Chrome */
  background-image: -webkit-linear-gradient(top, #fefefe, #fafafa);
  /* Chrome 10+, Saf5.1+ */
  background-image: -moz-linear-gradient(top, #fefefe, #fafafa);
  /* FF3.6 */
  background-image: -ms-linear-gradient(top, #fefefe, #fafafa);
  /* IE10 */
  background-image: -o-linear-gradient(top, #fefefe, #fafafa);
  /* Opera 11.10+ */
  background-image: linear-gradient(top, #fefefe, #fafafa);


} 
							 
							 
							 
							 
							 
							 
				
							 
                           .fun_demotivator_paginate ul li a:hover{
						     background-color:black;
						   }
				   
				   
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
					

					.entry-title, H1 {
					  font-size:0px !important;
					}
					#fun_demotivator_strzalki_with{
					
					        margin-top:10px;
							margin-bottom:75px;
							
					}
					#fun_demotivator_h3{

					        font-size:20px;
					
					}
					#fun_demotivator_1_demot_footer h4{
					
					        text-shadow: 2px 2px 2px #000; " 
							
					}
                   	</style>				
			       ';
                 
				 if( is_page(demotivators::$page_id) ){
				 
				       echo $css_style;
					   
				 }
       }
	   
	   
	   
    
	   
     add_action( 'wp_head', 'demotivators_style');

 ?>