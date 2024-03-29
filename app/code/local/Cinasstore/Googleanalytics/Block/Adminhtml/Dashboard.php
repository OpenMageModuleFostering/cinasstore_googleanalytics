<?php
class Cinasstore_Googleanalytics_Block_Adminhtml_Dashboard extends Mage_Adminhtml_Block_Template
{
 public $auth_token;
 public $ga_profile_id;
 public $ga_email_id;
 public $ga_password;
 
  public function __construct()
  {
    $this->_controller = 'adminhtml_dashboard';
    $this->_blockGroup = 'googleanalytics';
    $this->_headerText = Mage::helper('googleanalytics/dashboard')->__('Settings');
	$this->ga_profile_id = Mage::getStoreConfig('googleanalytics/general/analytic_profile_id');
	$this->ga_email_id = Mage::getStoreConfig('googleanalytics/general/analytic_email_id');
	$this->ga_password = Mage::getStoreConfig('googleanalytics/general/analytic_password');
	
    parent::__construct();
  }
  
   public function getAuthToken()
   {
    	if(isset($this->auth_token))
		{
    		return $this->auth_token;
    	}
		else
		{
			try
			{ 
				return $this->auth_token = Mage::getModel('googleanalytics/gapi')->authenticateUser($this->ga_email_id,$this->ga_password)->getAuthToken();	
			} 
			catch (Exception $e)
			{ 
			   echo '<ul class="messages"><li class="error-msg"><ul><li><span>'.$e->getMessage().'</span></li></ul></li></ul>';
			    exit;
			} 	
    	}
    }
	
	
  protected function _toHtml()
  {     
	$processor = Mage::getModel('googleanalytics/gapi')->setAuthToken($this->getAuthToken());
	
	$this->topReffer =  $this->showTopReferrer($processor, $this->ga_profile_id);
	$this->PageViews =  $this->showPageViews($processor, $this->ga_profile_id);
	$this->CountryVisits =  $this->showCountryVisits($processor, $this->ga_profile_id);
	$this->TopPages =  $this->showTopPages($processor, $this->ga_profile_id);	
	$this->PageVisitHistory =  $this->getPageVisitHistory($processor, $this->ga_profile_id); 
	$this->PageKeywordSearch =  $this->getKeywordSearch($processor, $this->ga_profile_id);  
	$this->PageBrowserViews =  $this->getBrowserViews($processor, $this->ga_profile_id);  
    $html = parent::_toHtml(); 
    return $html;
  }
  
	public function showTopReferrer($ga, $ga_profile_id)
	{
	
	  $ga->requestReportData($ga_profile_id, array('source','medium'),array('visits'),'-visits', '', '2013-12-25', '2014-01-03', 1,5);  
	  $results = $ga->getResults();
	  
	  foreach($results as $result)
	  { 
		$ga_dash_top_referrers .="['".$result->getSource()."',".$result->getVisits()."],";
	  }
	  
	   
	  
	   $code.='
				google.load("visualization", "1", {packages:["corechart"]});
				google.setOnLoadCallback(ga_dash_drawrd);
				
				function ga_dash_drawrd()
				 {
					var data = google.visualization.arrayToDataTable([
					 [\'Source\', \'Visits\'],
						'.$ga_dash_top_referrers.'
					]);
					var options = {
					 title: \'\'
					 };
	
					  var chart = new google.visualization.PieChart(document.getElementById("ga_dash_rdata"));   
					  chart.draw(data, options); 
			
				 }';		  
		return $code;
	}  

	public function showTopPages($ga, $ga_profile_id)
	{
	  $ga->requestReportData($ga_profile_id, array('pagePath','pageTitle'),array('pageviews'),'-pageviews');  
	  $results = $ga->getResults();
	  
	  foreach($results as $result)
	  { 
		$ga_dash_top_pages .="['".$result->getpagePath()."',".$result->getpageViews()."],";
	  }
	  $code.='
				google.load("visualization", "1", {packages:["table"]})
				google.setOnLoadCallback(ga_dash_drawpgd);
				function ga_dash_drawpgd() {
				var data = google.visualization.arrayToDataTable(['."
				  ['Top Pages', 'Visits'],"
				  .$ga_dash_top_pages.
				"  
				]);
				
				var options = {
					page: 'enable',
					pageSize: 15,
					width: '100%'
				};        
				
				var chart = new google.visualization.Table(document.getElementById('ga_dash_pgddata'));
				chart.draw(data, options);
				
			  }";
	  return $code;
	} 
	
	public function getBrowserViews($ga, $ga_profile_id)
   {
	  $ga->requestReportData($ga_profile_id, array('browser'), array('pageviews','visits'), array('-visits'));
      $results = $ga->getResults();
	  foreach($results as $result)
	   { 
	      $ga_dash_browserviews .= "['".$result->getBrowser()."','".$result->getPageviews()."','".$result->getVisits()."'],";
	   }
	   
	    $code.='
				google.load("visualization", "1", {packages:["table"]})
				google.setOnLoadCallback(ga_dash_drawBrowserView);
				function ga_dash_drawBrowserView() {
				var data = google.visualization.arrayToDataTable(['."
				  ['Browser', 'Page Views', 'Visits'],"
				  .$ga_dash_browserviews.
				"  
				]);
				
				var options = {
					page: 'enable',
					pageSize: 10,
					width: '100%'
				};        
				
				var chart = new google.visualization.Table(document.getElementById('ga_dash_browserdata'));
				chart.draw(data, options);
				
			  }";
			  
		 return $code;
   }	
	
   public function getKeywordSearch($ga, $ga_profile_id)
   {
	  $ga->requestReportData($ga_profile_id, array('keyword'), array('visits'));
      $results = $ga->getResults();
	  foreach($results as $result)
	   { 
	      $ga_dash_top_Keywords .= "['".$result->getKeyword()."','".$result->getVisits()."'],";
	   }
	   
	    $code.='
				google.load("visualization", "1", {packages:["table"]})
				google.setOnLoadCallback(ga_dash_drawKeywordHistory);
				function ga_dash_drawKeywordHistory() {
				var data = google.visualization.arrayToDataTable(['."
				  ['Keyword', 'Visits'],"
				  .$ga_dash_top_Keywords.
				"  
				]);
				
				var options = {
					page: 'enable',
					pageSize: 10,
					width: '100%'
				};        
				
				var chart = new google.visualization.Table(document.getElementById('ga_dash_keyworddata'));
				chart.draw(data, options);
				
			  }";
			  
		 return $code;
   }	
	
   public function getPageVisitHistory($ga, $ga_profile_id)
	{
		$ga->requestReportData($ga_profile_id, 'pagePath', array('pageviews', 'uniquePageviews', 'exitRate', 'avgTimeOnPage', 'entranceBounceRate', 'organicSearches','itemRevenue','transactionRevenuePerVisit','avgPageLoadTime'), null, 'pagePath == \'/\'', date('Y-m-d'));
        $results = $ga->getResults();
		
	  foreach($results as $result)
	   { 
		 $ga_dash_top_pages .="['Page Views','".number_format($result->getPageviews())."'],";
		 $ga_dash_top_pages .="['Unique Views','".number_format($result->getUniquepageviews())."'],";
		 $ga_dash_top_pages .="['Avg time on page','".$this->secondMinute($result->getAvgtimeonpage())."'],";
		 $ga_dash_top_pages .="['Bounce rate','".round($result->getEntrancebouncerate(), 2)."'],";
		 $ga_dash_top_pages .="['Exit rate','".round($result->getExitrate(), 2)."%'],";
		 $ga_dash_top_pages .="['Organic Searches','".round($result->getOrganicsearches(), 2)."'],";
		 $ga_dash_top_pages .="['Revenue','".round($result->getItemrevenue(), 2)."'],";
		 $ga_dash_top_pages .="['Revenue/Visit','".round($result->getTransactionrevenuepervisit(), 2)."'],";
		 
		 $returnCode['Page Views'] = number_format($result->getPageviews());
		 $returnCode['Unique Views'] = number_format($result->getUniquepageviews());
		 $returnCode['Avg time on page'] = $this->secondMinute($result->getAvgtimeonpage());
		 $returnCode['Bounce rate'] = number_format($result->getEntrancebouncerate());
		 $returnCode['Exit rate'] = round($result->getExitrate(), 2)."%";
		 $returnCode['Organic Searches'] = number_format($result->getPageviews());
		 $returnCode['Revenue'] = number_format($result->getItemrevenue());
		 $returnCode['Revenue/Visit'] = round($result->getTransactionrevenuepervisit(), 2);
		 return $returnCode;
	   }
	  
		 
		 $code.='
				google.load("visualization", "1", {packages:["table"]})
				google.setOnLoadCallback(ga_dash_drawVisitHistory);
				function ga_dash_drawVisitHistory() {
				var data = google.visualization.arrayToDataTable(['."
				  ['Title', 'Total'],"
				  .$ga_dash_top_pages.
				"  
				]);
				
				var options = {
					page: 'enable',
					pageSize: 10,
					width: '100%'
				};        
				
				var chart = new google.visualization.Table(document.getElementById('ga_dash_historydata'));
				chart.draw(data, options);
				
			  }";
			  
		 return $code;
	}  

	
	public function secondMinute($seconds)
	{
		$minResult = floor($seconds/60);
		if($minResult < 10){$minResult = 0 . $minResult;}
		$secResult = ($seconds/60 - $minResult)*60;
		if($secResult < 10){$secResult = 0 . round($secResult);}
		else { $secResult = round($secResult); }
		return $minResult.":".$secResult;
   } 

	public function showCountryVisits($ga, $ga_profile_id)
	{
	  $ga->requestReportData($ga_profile_id, array('country'),array('visits'), array('-visits'));  
	  $results = $ga->getResults();
	  
	   
	  $code='
				google.load("visualization", "1", {packages:["geochart"]});
				google.setOnLoadCallback(ga_dash_drawmap);
				function ga_dash_drawmap() {
				var data  = google.visualization.arrayToDataTable(['."
				  ['Country', 'Visits'],";
					$countryVar = '';		  
					  foreach($results as $result) {
						  $countryVar.="['".$result->getCountry()."', ".$result->getVisits()."],";
					  }
				
					 $code .= $countryVar."
				]);
				
				var options = {
				colors: ['white', 'orange'], title:'Geo Location Visits'
			    };
				
				var chart = new google.visualization.GeoChart(document.getElementById('ga_dash_mapdata'));
				chart.draw(data , options);
				
			  }";
			  
	   return $code;		  
	}
	

	public function showPageViews($ga, $ga_profile_id)
	{
	
	$ga->requestReportData($ga_profile_id, array('date'),array('pageviews'), 'date', '');  
	$results = $ga->getResults();
	$code='
	  google.load("visualization", "1", {packages:["corechart"]});
	  google.setOnLoadCallback(drawChart);
	  function drawChart() {
		var data = new google.visualization.DataTable();
		data.addColumn(\'string\',\'Day\');
		data.addColumn(\'number\', \'Pageviews\');
		 data.addRows([';
		 
	$varDataRows='';	
		  foreach($results as $result) {
			  $varDataRows .= '["'.date('M j',strtotime($result->getDate())).'", '.$result->getPageviews().'],';
		  }
	
	   $code .=$varDataRows."]);
	
		var chart = new google.visualization.AreaChart(document.getElementById('chart'));
		chart.draw(data, {title: '".date('M j, Y',strtotime('-30 day')).' - '.date('M j, Y')."',
						  colors:['#058dc7','#e6f4fa'],
						  areaOpacity: 0.1,
						  hAxis: {textPosition: 'in', showTextEvery: 5, slantedText: false, textStyle: { color: '#058dc7', fontSize: 10 } },
						  pointSize: 5,
						  legend: 'none'
		});
	  }";
	 return $code;
	}

    
}
