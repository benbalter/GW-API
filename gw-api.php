<?php
class gw_api {
 
    public function __construct() {
 
        //configuration settings
        $this->user_agent = 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7';
        $this->maps_base = 'http://citl.gwu.edu/iphonedev/maps/';
        $this->schedule_base = 'http://my.gwu.edu/mod/pws/scheduleXML.cfm';
    }
 
    public function get_url($url) {
 
        //prefer the WP HTTP API to allow for caching and user agent spoofing, fall back if necessary
        if ( function_exists( 'wp_remote_get') )
            $data = wp_remote_retrieve_body( wp_remote_get($url, array('user-agent' => $this->user_agent) ) );
        else
            $data = file_get_contents($url);
 
        //parse the XML into a PHP object
        $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
 
        return $xml;
    }
 
    public function get_map($category = 'categories') {
        return $this->get_url($this->maps_base . $category . '.xml');
    }
 
    public function get_schedule($year = '', $term ='', $dept = ''){
 
        //if no year was given, assume the current year
        if ($year == '')
            $year = date('Y');
 
        //if no term is given, calculate the current term
        if ($term == '')
            $term = $this->get_term();
 
        //form URL and call
        return $this->get_url($this->schedule_base . '?termCode=' . $year . $term . '&deptCode=' . $dept);
    }
 
    public function get_term() {
 
        //get the current month as 01-12
        $m = date('M');
 
        //if it is jan. - april, we're in the spring
        if ($m < 5)
            return '01';
 
        //if it's May - August, we're in the summer
        else if ($m < 9) {
            return '02';
        } 
 
        //otherwise, it's fall
        else return '03';
    }
 
}
?>