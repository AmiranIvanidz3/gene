<?php

use App\Helpers\Helper;

function adminUrl($url){ return Helper::adminUrl($url); }

function externalUrl($url){ return Helper::externalUrl($url); }

function clearNumber($number){
    if (strpos($number, '.')!==false) {        
        $number = rtrim($number, 0);
        $number = rtrim($number, '.'); 
    }
    return $number;
}
function formNumber($num, $prec=0){
	if ($num<1 && $num!=0) {
		return clearNumber(shortNumber($num, $prec));
	}
	
	if ($num>1) {
		$prec--;
	}
	if ($num>10) {
		$prec--;
	}
	if ($num>100) {
		$prec--;
	}
    return clearNumber(number_format($num, $prec));
}
function shortNumber($number, $precision) {
    
    $zeros = strlen(intval(1/$number))-1;
    
    if ($number<1) {
        $precision += $zeros;
    }
    
    $result = number_format($number, $precision);
    
    return $result;
}

function clearURL($url){
	$url = str_replace(['https://', 'http://', 'www.'], '', $url);
	$url = rtrim($url, '/');
	$url = str_replace('/', '_', $url);
    return $url;
}

function tableOrderTH($column_name, $orderby_column, $sort){
    return $orderby_column == $column_name ? 'active-order '.($sort == 'desc' ? 'triangle-down ': 'triangle-up '): 'triangle-down ';
}

// /tokens/orderby/base-price-pair/
function tableOrderLink($settings = []){
    $expected_settings = ['url', 'order', 'orderby_column', 'current_column', 'title'];
    foreach($expected_settings as $expected_setting){
        ${$expected_setting} = $settings[$expected_setting] ?? null;
    }
    $active = $orderby_column == $current_column;

    $next_sort = $order == 'desc' && $active ? 'asc': 'desc';
    $active_class = $active ? 'active-order ' : '';
    $triangle = $active ? ($next_sort == 'desc' ? 'triangle-down ': 'triangle-up ') : 'triangle-down ';
    $label = $next_sort == 'desc' ? 'Order By Descending Order' : 'Order By Ascending Order';

    return '<a href="'.$url.'/orderby/'.str_replace('_', '-', $current_column).'/'.$next_sort.'">
                '.$title.'<span class="'.$active_class.$triangle.'table-order-icon has-tooltip" aria-label="'.$label.'"></span>
            </a>';
}

function clearDatetime($datetime){
	$res = '';
	if ($datetime) {
		$datetime = str_replace(' 00:00:00', '', $datetime);
		$res = date_format(date_create($datetime), 'M j, Y');
	}
    return $res;
}

function percent($whole, $part) {
    return clearNumber(number_format($part*100/$whole, 1));
}

function percentDiff($number) {
	$class = $number < 0 ? 'red' : 'green';
    return "<span class='$class b'>$number<sup>%</sup></span>";
} 

function colorRedGreenTRXcount($item) {
	$class = $item['count_1d_sell'] > $item['count_1d_buy'] ? 'red' : 'green';
    return "<span class='$class'>".$item['count_1d']."</span>";
}

function colorRedGreenDIVs($count_1d_buy, $count_1d_sell) {
	$buy = 0;
	$sum = $count_1d_buy + $count_1d_sell;
	
	if ($sum) {
		$buy = intval($count_1d_buy*100/$sum);
	}
	$sell = intval(100-$buy);
    return '<div style="min-width: 50px; height:10px; display:flex;">
							<div style="flex:'.$buy.'; background:green; "></div>
							<div style="flex:'.$sell.'; background:red; "></div>
						</div>';
}


// Risk calculations
function presalePairAfterFEGburn($presale, $presale_price) {
    return ($presale*$presale_price)*0.995;
}
function liquidityShare($presale, $presale_price, $team_presale_share_percent=50) {
    $afterFEGburn = presalePairAfterFEGburn($presale, $presale_price);

    // Calculate team share
    $team_presale_share = $afterFEGburn*$team_presale_share_percent/100;

    // Calculate liquidity share
    $liquidity_share = ($afterFEGburn-$team_presale_share)/2;
    
    return $liquidity_share;
}
function launchPrice($presale, $presale_price, $liquidity, $team_presale_share_percent) {
    $launch_price = liquidityShare($presale, $presale_price, $team_presale_share_percent)/$liquidity;
    return $launch_price;
}
function basePrice($presale, $presale_price, $total_supply_minus_IB, $team_presale_share_percent) {
    $base_price = liquidityShare($presale, $presale_price, $team_presale_share_percent)/$total_supply_minus_IB;
    return $base_price;
}
function launchPriceRatio($total_supply_minus_IB, $liquidity, $presale, $presale_price, $team_presale_share_percent) {
    $launch_price = launchPrice($presale, $presale_price, $liquidity, $team_presale_share_percent);
    $base_price = basePrice($presale, $presale_price, $total_supply_minus_IB, $team_presale_share_percent);    
    $price_ratio = getPriceRatio($launch_price, $base_price);

    return $price_ratio;
}
function presalePriceRatio($presale, $presale_price, $total_supply, $team_presale_share_percent) {
    return $presale_price/basePrice($presale, $presale_price, $total_supply, $team_presale_share_percent);
}
function investmentRisk($total_supply, $presale_price, $presale, $liquidity, $team_presale_share_percent) {
    $market_cap = ($total_supply)*$presale_price;
    $price_ratio = launchPriceRatio($total_supply, $liquidity, $presale, $presale_price, $team_presale_share_percent);
    $team_control = teamControl($total_supply, $presale, $liquidity);
    $presale_ratio = presalePriceRatio($presale, $presale_price, $total_supply, $team_presale_share_percent);

    $risk_points = riskPoints($market_cap, $presale_ratio, $price_ratio, $team_control);
    
    return $risk_points;
}

function teamControl($total_supply, $presale, $liquidity) {
    return ($total_supply-$presale-$liquidity)*100/$total_supply;
}
function riskPoints($market_cap, $presale_ratio, $price_ratio, $team_control) {
    return ($market_cap*$presale_ratio*$price_ratio*$team_control)/50000;
}
function getPriceRatio($launch_price, $base_price) {
    return $launch_price/$base_price;
}

function UPCalculatedFields($item) {
	
	$result = [];
	
	$result['supply_after_initial_burn'] = $item->total_supply-$item->initial_burn;
	$result['presale_percent'] = percent($result['supply_after_initial_burn'], $item->presale);
	$result['liquidity_percent'] = percent($result['supply_after_initial_burn'], $item->liquidity);
	$result['team_control'] = $result['supply_after_initial_burn']-$item->presale-$item->liquidity;
	$result['team_control_percent'] = percent($result['supply_after_initial_burn'], $result['team_control']);
	$result['hard_cap'] = $item['presale']*$item['presale_price'];
	
	$result['launch_price'] = formNumber(
		launchPrice(
			$item['presale'], 
			$item['presale_price'], 
			$item['liquidity'], 
			$item['team_presale_share']
		), 
		3
	);
	$base_price = basePrice(
		$item['presale'], 
		$item['presale_price'], 
		$result['supply_after_initial_burn'], 
		$item['team_presale_share']
	);
	$result['base_price'] = formNumber($base_price, 3);

	$result['presale_price_ratio'] = formNumber($item['presale_price']/$base_price, 2);
	$result['launch_price_ratio'] = formNumber(
		launchPriceRatio(
			$result['supply_after_initial_burn'], 
			$item['liquidity'], 
			$item['presale'], 
			$item['presale_price'], 
			$item['team_presale_share']
		), 
		2
	);
	$result['risk_points'] = formNumber(
		investmentRisk(
			$result['supply_after_initial_burn'],
			$item['presale_price'],
			$item['presale'],
			$item['liquidity'],
			$item['team_presale_share']
		), 
		2
	);

	$result['buy_fee_combined'] = 0.1+$item['holder_reflections']+$item['asset_backing'];
	$result['sell_fee_combined'] = 0.5+0.12+$item['holder_reflections']+$item['asset_backing']+$item['smart_rising_price_floor'];
	
	return $result;
}

function displayServerInfoTable(){
    $indicesServer = array('PHP_SELF',
    'argv',
    'argc',
    'GATEWAY_INTERFACE',
    'SERVER_ADDR',
    'SERVER_NAME',
    'SERVER_SOFTWARE',
    'SERVER_PROTOCOL',
    'REQUEST_METHOD',
    'REQUEST_TIME',
    'REQUEST_TIME_FLOAT',
    'QUERY_STRING',
    'DOCUMENT_ROOT',
    'HTTP_ACCEPT',
    'HTTP_ACCEPT_CHARSET',
    'HTTP_ACCEPT_ENCODING',
    'HTTP_ACCEPT_LANGUAGE',
    'HTTP_CONNECTION',
    'HTTP_HOST',
    'HTTP_REFERER',
    'HTTP_USER_AGENT',
    'HTTPS',
    'REMOTE_ADDR',
    'REMOTE_HOST',
    'REMOTE_PORT',
    'REMOTE_USER',
    'REDIRECT_REMOTE_USER',
    'SCRIPT_FILENAME',
    'SERVER_ADMIN',
    'SERVER_PORT',
    'SERVER_SIGNATURE',
    'PATH_TRANSLATED',
    'SCRIPT_NAME',
    'REQUEST_URI',
    'PHP_AUTH_DIGEST',
    'PHP_AUTH_USER',
    'PHP_AUTH_PW',
    'AUTH_TYPE',
    'PATH_INFO',
    'ORIG_PATH_INFO') ;
    
    echo '<table cellpadding="10">' ;
    foreach ($indicesServer as $arg) {
        if (isset($_SERVER[$arg])) {
            echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
        }
        else {
            echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
        }
    }
    echo '</table>' ;
}




function SvgAnnouncement(){
    return '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 239.563 239.563" style="enable-background:new 0 0 239.563 239.563;" xml:space="preserve" fill="#B5B5C3">
    <g>
        <g>
            <g>
                <path d="M146.962,36.978h-1.953L85.568,69.611H42.605C19.113,69.611,0,88.723,0,112.216c0,21.012,15.301,38.474,35.334,41.943     L21.56,202.585h47.523l13.584-47.756h2.901l59.443,32.628h1.953c12.585,0,22.826-10.239,22.826-22.826V59.803     C169.787,47.219,159.546,36.978,146.962,36.978z M57.592,187.366H41.71l8.352-29.364h15.882L57.592,187.366z M109.459,150.581     l-19.988-10.972H42.605c-15.103,0-27.388-12.29-27.388-27.393c0-15.103,12.285-27.388,27.388-27.388h46.866l19.988-10.974     V150.581z M154.57,164.631c0,3.637-2.567,6.683-5.978,7.431l-23.916-13.127V65.502l23.916-13.13     c3.414,0.748,5.978,3.797,5.978,7.434V164.631z"/>
                <path d="M198.989,79.377L188.106,90.26c5.623,7.789,8.976,17.32,8.976,27.637c0,10.32-3.353,19.851-8.976,27.637l10.883,10.883     c8.326-10.629,13.31-24,13.31-38.52C212.299,103.377,207.315,90.007,198.989,79.377z"/>
                <path d="M218.358,60.009l-10.794,10.794c10.482,12.856,16.782,29.252,16.782,47.094c0,17.845-6.3,34.238-16.782,47.094     l10.794,10.794c13.216-15.648,21.205-35.849,21.205-57.888S231.574,75.657,218.358,60.009z"/>
            </g>
        </g>
    </g>
    </svg>';
}