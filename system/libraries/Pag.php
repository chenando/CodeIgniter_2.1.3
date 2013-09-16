<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
class CI_Pag {

    var $base_url = ''; // The page we are linking to
    var $prefix = ''; // A custom prefix added to the path.
    var $suffix = ''; // A custom suffix added to the path.
    var $total_rows = 0; // Total number of items (database results)
    var $per_page = 10; // Max number of items you want shown per page
    var $num_links = 2; // Number of "digit" links to show before/after the currently viewed page
    var $cur_page = 0; // The current page being viewed
    var $use_page_numbers = FALSE; // Use page number for segment instead of offset
    var $first_link = '&lsaquo; First';
    var $next_link = '&gt;';
    var $prev_link = '&lt;';
    var $last_link = 'Last &rsaquo;';
    var $uri_segment = 3;
    var $full_tag_open = '';
    var $full_tag_close = '';
    var $first_tag_open = '';
    var $first_tag_close = '&nbsp;';
    var $last_tag_open = '&nbsp;';
    var $last_tag_close = '';
    var $first_url = ''; // Alternative URL for the First Page.
    var $cur_tag_open = '&nbsp;<strong>';
    var $cur_tag_close = '</strong>';
    var $next_tag_open = '&nbsp;';
    var $next_tag_close = '&nbsp;';
    var $prev_tag_open = '&nbsp;';
    var $prev_tag_close = '';
    var $num_tag_open = '&nbsp;';
    var $num_tag_close = '';
    var $page_query_string = FALSE;
    var $query_string_segment = 'per_page';
    var $display_pages = TRUE;
    var $anchor_class = '';

    /**
     * Constructor
     *
     * @access	public
     * @param	array	initialization parameters
     */
    public function __construct($params = array()) {
        if (count($params) > 0) {
            $this->initialize($params);
        }

        if ($this->anchor_class != '') {
            $this->anchor_class = 'class="' . $this->anchor_class . '" ';
        }

        log_message('debug', "Pag Class Initialized");
    }

    // --------------------------------------------------------------------

    /**
     * Initialize Preferences
     *
     * @access	public
     * @param	array	initialization parameters
     * @return	void
     */
    function initialize($params = array()) {
        if (count($params) > 0) {
            foreach ($params as $key => $val) {
                if (isset($this->$key)) {
                    $this->$key = $val;
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Generate the pagination links
     *
     * @access	public
     * @return	string
     */
    function create_links() {
        // If our item count or per-page total is zero there is no need to continue.
        if ($this->total_rows == 0 OR $this->per_page == 0) {
            return '';
        }

        // Calculate the total number of pages
        $num_pages = ceil($this->total_rows / $this->per_page);

        // Is there only one page? Hm... nothing more to do here then.
        if ($num_pages == 1) {
            return '';
        }

        // Set the base page index for starting page number
        if ($this->use_page_numbers) {
            $base_page = 1;
        } else {
            $base_page = 0;
        }

        // Determine the current page number.

        $CI = & get_instance();

        $outset = $CI->input->post($this->uri_segment, TRUE);

        // Prep the current page - no funny business!
        $this->cur_page = (int) $outset;


        $this->cur_page = ceil($this->cur_page / $this->per_page);
        // parametros de entrada.

        $middle_links = intval($this->num_links / 2);
        $i = 0;
        $inc = 0;
        if ($this->cur_page > $middle_links) {
            $i = $this->cur_page - $middle_links;
            $inc = $i;           
        }   
        if ($this->cur_page + $middle_links >= $num_pages && $num_pages - $this->per_page > 0) {
            $i = $num_pages - $this->per_page;
            $inc = $i;           
        }


        $prev_outset = ($outset - $this->per_page > 0) ? $outset - $this->per_page : 0;
        $next_outset = ($outset + $this->per_page < $this->total_rows) ? $outset + $this->per_page : $outset;
        $last_outset = $this->total_rows - ($this->total_rows % $this->per_page);
        //end parametros derivados
        //
        //create links.
        $output = "";
        $output = form_button(array('type' => 'submit', 'name' => $this->uri_segment, 'value' => 0), $this->first_link, $this->anchor_class);
        $output.='&nbsp;';
        $output .= form_button(array('type' => 'submit', 'name' => $this->uri_segment, 'value' => $prev_outset), $this->prev_link, $this->anchor_class);
        $output.='&nbsp;&nbsp;&nbsp;';
        for ($i; $i < ($this->num_links + $inc) && $i < $num_pages; $i++) {
            $outset_aux = ($i * $this->per_page);
            $page = $i + 1;
            $content = $page;
            $content = ($outset_aux == $outset) ? "<strong>$content</strong>" : $content;
            $output.= form_button(array('type' => 'subtmit', 'name' => 'start', 'value' => $outset_aux), $content, $this->anchor_class);
        }

        $output.='&nbsp;&nbsp;&nbsp;';
        $output .= form_button(array('type' => 'submit', 'name' => $this->uri_segment, 'value' => $next_outset), $this->next_link, $this->anchor_class);
        $output.='&nbsp;';
        $output .= form_button(array('type' => 'submit', 'name' => $this->uri_segment, 'value' => $last_outset), $this->last_link, $this->anchor_class);
        //end create links.
        //
        

        // Add the wrapper HTML if exists
        $output = $this->full_tag_open . $output . $this->full_tag_close;
        return $output;
    }

}

// END Pagination Class

/* End of file Pagination.php */
/* Location: ./system/libraries/Pagination.php */