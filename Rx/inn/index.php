<?php
 include("include/config.php"); 
 include("include/common.php"); 

 if (!true) {
    echo "UserID : " . $_SESSION['au_member_id'] . " | DebugMode is ON!" . "\r";
}

$target = strval($_SESSION['au_member_id']);

$setShowJA = 'hidden';

if(!empty($_SESSION['au_member_id'])){
	$count_row = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME)->query("SELECT Status FROM tbl_job_test WHERE userRespon ='$target' AND Status != '3' AND Status != '4'");
	$row_countResult = $count_row->num_rows;
	$setShowJA = '';
}



//echo $row_countResult;
?>
<!DOCTYPE html>
<html lang="en" class="en Light" data-controller="home feed" data-page="feed-home" data-an="Main Feeds|Home Feed|1">
<head>

<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta http-equiv="x-dns-prefetch-control" content="on">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no">



<title>Operation and Maintenance CATV -  Control</title>



<meta name="referrer" content="origin">
<meta name="csrf-name" content="X_CSRF_TOKEN">
<meta name="csrf-token" content="a4e9df0441d8907ef9f9e7f5e6f7dc3a8f962d31739e1d2ba7e08b5651235317">
<link rel="apple-touch-icon" href="./img/apple-touch-icon.png">
<link rel="icon" href="./img/favicon-32x32.png">

<link rel="stylesheet" type="text/css" href="./formpage/css/desktop-91ebaacb.css" media="all">

<link rel="stylesheet" type="text/css" href="./formpage/css/home-32f6fa4e.css" media="all">
<script type="text/javascript">var App={config:{BASE_URL:'',CDN_LOCAL:'',IMG_URL:'',DEBUG:false,DEVELOPMENT:false,gaAccountNumber:'UA-1985900-10',isLoggedIn:false,isSubscriber:false,gridItemWidth:236,gridItemMaxHeight:600,gridItemGutter:24,gridMinColumns:2,gridMaxColumns:9,COMPONENTS:{"account-verification":"tbDa2q84q0sbcdxhf99xAh8B","alert":"aimja38B0itx8Cwxm4lgk23g","autocomplete":"ffztpE3B17b7tBy18cijlve5","cancel-subscription":"izBf66z7yet241fA9iu631sb","change-password":"al71vwle3aoajang1qflchfo","change-plan":"3rEnwcikzCcbxDCctgkyE8tp","collection-collaboration":"7wefc6nh4tCcqihAxDy17yc1","color-search":"fzwjlC71kwvtjeks5841e66m","create-collection":"hefxqqazAs6vwh8dz8tnt1o6","create-subscription":"ldaugtuukego2g4rmrsvk7dE","create-vision":"5tkbxfok50nhehxbt1idmfbc","delete-account-request":"pjvb19nt2x6eh4361dv9oe9u","edit-collection":"mo5pejtDlfDqbnv3zwd1w7h2","edit-save":"wm7rwp7okb4aovsEkDAn9tid","feature-announcement":"cDux7ewijuwcl4cb6ojq0i1z","login-pro":"3gkC92hvn0fjkf8477ndCatz","login":"7Esjau3sAa4pgejbEt9iq5pm","renew-subscription":"m4f8gfxaxsj0d6EBmziajx64","report":"ppo1Aoz9qB3y2jE4w5mDlfBn","save-closeup":"okqBECrrxophga18bDu3e2sg","save-from-website":"7n9zuqf52tuj5xp59w09eDpg","save-to-collection":"m2Edr86m4dk09jvkhiy1j2gc","share":"jzthCya7x9cg4n5rw3siC72r","signup-pro":"g6t7A1vmw036jwpcu2mvm3aA","signup":"uvdsx90rfjujf91o6vjBny37","update-card":"sEa63tqBbA49uE48zasgp9ng","upload-media":"nwD1ie3hnoE2dcfkqC78tcre"},lastAccessUI:'signup',fb_auth_app_id:'129861400415426',fb_graph_version:'v8.0',g_auth_client_id:'167338216752-gm3r3tnodgm7nfbigdqk61678gvk0gdl.apps.googleusercontent.com',g_rc_idv2:'6Lfm7woTAAAAADh6PYb5GOZhesohCLMHwlcAbp8I',g_rc_idv3:'6LeD8KcUAAAAAAt9JY30eZSfaQhKkZsXdRxfRzKq',stripe:'pk_live_aYMhNb4xKtWxpOD5VZkiX0SJ'},browser:{height:0,width:0,pageHeight:0,pageWidth:0,init:function(){this.height=this.getWindowHeight(),this.width=this.pageWidth=this.getWindowWidth(),App.columnManager.setNumColumns()},getPageHeight:function(){var e=document.body,t=document.documentElement;return Math.max(Math.max(e.scrollHeight,t.scrollHeight),Math.max(e.offsetHeight,t.offsetHeight),Math.max(e.clientHeight,t.clientHeight))},getWindowHeight:function(){return document.documentElement.clientHeight||window.innerHeight},getWindowWidth:function(){return document.documentElement.clientWidth||document.body.scrollWidth||window.innerWidth},getViewportHeight:function(){return window.innerHeight}},columnManager:{numColumns:0,getNumColumns:function(){var e=App.config.gridItemWidth+App.config.gridItemGutter,t=this.getPageWidth();return Math.min(Math.max(Math.floor(t/e),App.config.gridMinColumns),App.config.gridMaxColumns)},getPageWidth:function(){return window.innerWidth||document.documentElement.clientWidth},setNumColumns:function(e){e=e||this.getNumColumns(),this.numColumns&&e===this.numColumns||(this.numColumns=e)}}};App.browser.init();</script>

<script defer type="text/javascript" src="./formpage/js/desktop-debe64d0.js"></script>


<script>var PaginationParams={"next":2,"prev":null,"current":1,"has_more":true};</script>

<link rel="stylesheet" href="./formpage/css/w3.css">
<style>
.mySlides {display:none;}
</style>
</head>

<body class="feed">
    <div class="App">
	    <div class="Header">
	<div class="headerContainer">
		<div class="logoContainer">
	        <a href="/" class="logoLink">
				<svg width="200" height="200" style="margin-top: 0;"
				xmlns="">
				<image href="./img/TVIlogo.png" height="60" width="90"/>
				</svg>      </a>
		</div>

		<div class="rightHeaderContent">
			<ul class="navItems">

										



	
					<li class="navItem hideableNavItem">
						
					<?php if ($_SESSION["au_privilege"]["Administrator"]) { ?>
					<button type="button" onclick="window.location.href='./formpage/logout.php'" class="signupHeaderButton signupTrigger">
							<span>Log Out</span>
						</button>
					<?php }else{ ?>
						<button type="button" onclick="window.location.href='./formpage/login.php'" class="signupHeaderButton signupTrigger">
							<span>Log In</span>
						</button>
					<?php } ?>

					<button type="button" onclick="window.location.href='./formpage/jobactivity.php'" class="signupHeaderButton signupTrigger" <?php echo $setShowJA;?>>
					<span <?php echo $setShowJA;?>>Request : <?php echo $row_countResult;?></span>
					</li>

				
				<li class="navItem">
					<button type="button" class="more dropdownTrigger btn" data-type="more">
						<span class="moreDropdownContainer">
							<svg xmlns="" width="16" height="4" fill-rule="evenodd">
								<path d="M2 0a2 2 0 1 0 0 4 2 2 0 1 0 0-4m6 0a2 2 0 1 0 0 4 2 2 0 1 0 0-4m6 0a2 2 0 1 0 0 4 2 2 0 1 0 0-4"></path>
							</svg>
						</span>
					</button>

					<div class="dropdown module moreDropdown" data-pos="right">
					    <div class="moduleContainer">
						    <div class="dropdownCaret">
						        <div class="dropdownCaretOuter up"></div>
						        <div class="dropdownCaretInner up"></div>		    
						    </div>

					        <div class="dropdownContainer">
					            <ul class="dropNavItems">							
														
					                <li class="loginAndSignup">
				
										<button type="button"  class="signupHeaderButton signupTrigger">
											<span>Log in</span>
										</button>
					                </li>	
								
					                <li>
					                    <a href="./register2way.php" class="dropNavItem">Regist Equipment</a>
					                </li>

					                <li>
					                    <a href="./formpage/request_movebetweenfloor.php" class="dropNavItem">Move Between Floor</a>
					                </li>

					                <li>
					                    <a href="/ssm/" class="dropNavItem">Incoming Equipment</a>
					                </li>

					                <li>
					                    <a href="/about/support/" class="dropNavItem">Outgoing Equipment</a>
					                </li>

					                <li>
					                    <a href="/sitemap/users_a.html" class="dropNavItem">Return Partner</a>
					                </li>

					                <li>
					                    <a href="/about/advertising/" class="dropNavItem">Write Off</a>
					                </li>
	
					                <li class="line"></li>
									<li>
					                    <a href="./formpage/jobactivity.php" class="dropNavItem">Job Activity : <?php echo $row_countResult;?></a>
					                </li>
									<li>
					                    <a href="./formpage/Equipment_history.php" class="dropNavItem">Equipemt monitoring</a>
					                </li>
									<li>
					                    <a href="/about/advertising/" class="dropNavItem">Log monitoring</a>
					                </li>
	
					                <li class="line"></li>
									

					                <li>
									<a href="./index.php" class="dropNavItem">Back to Home</a>
									<a href="formpage/admin/user_list.php" class="dropNavItem">User List</a>
									<a href="formpage/sap_list.php" class="dropNavItem">SAP list</a>
					                </li>
					            </ul>
					        </div>
					    </div>
					
					    <div class="moduleOverlay canClose"></div>
					</div>
				</li>
				
				<li class="navItem">
									</li>
			</ul>
		</div>

		<div class="centerHeaderContent">
		    <div class="searchForm">

		
	            <div class="searchSuggestions">
	<div class="canClose"></div>
	<div class="searchSuggestionAligner">
		<div class="searchSuggestionContainer">
			<ul class="suggestionTray"></ul>


		</div>
	</div>
</div>		    </div>
		</div>
	</div>
</div>
	    <div class="featured">
	    <div class="featuredDisplayContainer centeredWithin">
				<div class="featuredDisplay">
					<div class="featuredDisplayScroller">
						
						<div class="featuredItem">
							<div class="proAccountBanner">				    
								<a href="./register2way.php">
									<img src="./img/register.png" style="height: 100%;" width="250" height="120" alt="Visions Mood Boarding">
								</a>
							</div>
						</div>
						<div class="featuredItem">
							<div class="proAccountBanner" style="height: 100%;">		
								<a href="./formpage/request_movebetweenfloor.php">		    
									<img src="./img/between.png" style="height: 100%;"  width="756" height="100%" alt="Activate Moon Mode on proAccountBanner">
								</a>
							</div>
						</div>

						<div class="featuredItem">
							<div class="dragDropBanner" style="height: 100%;">				    
								<a href="/pro/">
									<img src="./img/incoming.png" style="height: 100%;" width="756" height="300" alt="Drag drop on Designspiration">
								</a>
							</div>
						</div>


						<div class="featuredItem">
							<div class="proAccountBanner">				    
								<a href="/pro/">
									<img src="./img/moveout.png" style="height: 100%;" width="756" height="300" alt="Visions Mood Boarding">
								</a>
							</div>
						</div>
						<div class="featuredItem">
							<div class="proAccountBanner">				    
								<a href="/pro/">
									<img src="./img/return.png" style="height: 100%;" width="756" height="300" alt="Visions Mood Boarding">
								</a>
							</div>
						</div>
						<div class="featuredItem">
							<div class="proAccountBanner">				    
								<a href="/pro/">
									<img src="./img/wirteoff.png" style="height: 100%;" width="756" height="300" alt="Visions Mood Boarding">
								</a>
							</div>
						</div>

						

					</div>
				</div>
		</div>
	    </div>	    

		
<div class="homeMenu textMenu horizontalMenu">
    <div class="horizontalMenuSectionInner">
        <div class="scroller">
			<div class="previous shifter">
				<button class="shifterContainer">
					<div class="icon"></div>
				</button>
			</div>

			<div class="next shifter">
				<button class="shifterContainer">
					<div class="icon"></div>
				</button>
			</div>

            <div class="horizontalMenuScroller justifyCenter">
                <div class="horizontalMenuScrollerInner">
                    <div class="horizontalMenuSection">
                        <ul class="menuItems menuItemsPositioner">

	<li class="menuItem firstItem">
		<a class="menuItemLink active"  id="i1" onclick="currentDiv(1)">
			<span class="menuItemText">Regist Equipment</span>
		</a>
	</li>
		<li class="menuItem">
		<a class="menuItemLink" id="i2" onclick="currentDiv(2)">
			<span class="menuItemText">Move Between Floor</span>
		</a>
	</li>
	<li class="menuItem">
		<a class="menuItemLink" id="i3"  onclick="currentDiv(3)">
			<span class="menuItemText">Incoming Equipment</span>			
		</a>
	</li>
		<li class="menuItem">
		<a class="menuItemLink" id="i4"  onclick="currentDiv(4)">
			<span class="menuItemText">Outgoing Equipment</span>
		</a>
	</li>
	</li>
		<li class="menuItem">
		<a class="menuItemLink" id="i5"  onclick="currentDiv(5)">
			<span class="menuItemText">Return Partner</span>
		</a>
	</li>
	</li>
		<li class="menuItem">
		<a class="menuItemLink" id="i6"  onclick="currentDiv(6)">
			<span class="menuItemText">Write Off</span>
		</a>
	</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








	    <div class="AppContent">
			<div class="w3-content w3-section" style="max-width:500px">
				<a href="./register2way.php">
					<img class="mySlides w3-animate-bottom" src="./img/register.png" style="width:100%">
				</a>
				<a href="./formpage/request_movebetweenfloor.php">
					<img class="mySlides w3-animate-bottom" src="./img/between.png" style="width:100%">
				</a>
				<a href="./formpage/request_register2.php">
					<img class="mySlides w3-animate-bottom" src="./img/incoming.png" style="width:100%">
				</a>
				<a href="./formpage/request_register3.php">
					<img class="mySlides w3-animate-bottom" src="./img/moveout.png" style="width:100%">
				</a>
				<a href="./formpage/request_register4.php">
					<img class="mySlides w3-animate-bottom" src="./img/return.png" style="width:100%">
				</a>
				<a href="./formpage/request_register5.php">
					<img class="mySlides w3-animate-bottom" src="./img/wirteoff.png" style="width:100%">
				</a>
			  </div>
	    </div>
	
			<script>
				var slideIndex = 1;
				showDivs(slideIndex);
				
				function plusDivs(n) {
				  showDivs(slideIndex += n);
				}
				
				function currentDiv(n) {
				  showDivs(slideIndex = n);
				  chage_curMenu(slideIndex = n);
				}
				
				function showDivs(n) {
				  var i;
				  var x = document.getElementsByClassName("mySlides");
				  var dots = document.getElementsByClassName("demo");
				  if (n > x.length) {slideIndex = 1}    
				  if (n < 1) {slideIndex = x.length}
				  for (i = 0; i < x.length; i++) {
					x[i].style.display = "none";  
				  }
				  for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" w3-red", "");
				  }
				  x[slideIndex-1].style.display = "block";  
				//   dots[slideIndex-1].className += " w3-red";
				  
				}
				function chage_curMenu(n) {
					var x = document.getElementsByClassName("menuItemLink");
					for(i=1;i<=x.length;i++)
					{
						if(i==n)
						{
							x[i-1].className = "menuItemLink active";
						}
						else
						{
							x[i-1].className = "menuItemLink";
						}
					}
					
				 
				}
				</script>

    </div>

	<div class="ComponentManager"></div>

    <script type="application/json" id="PJSD">{"page":{"user":{"isLoggedIn":false,"username":null,"user_id":false,"displayName":null,"email_confirmed":null,"showPromoted":true,"color_mode":"Light"},"ads":{"homepage_banner":null,"promoted_save":[{"ad_type":"promoted_save","advertiser":"EditorX","advertiser_logo":"https:\/\/dspncdn.com\/a1\/prm_logo\/80x\/2e821ea4b882fb653be31129decd2649.jpg","advertiser_logo_background":"#000000","background":"#090ce7","click_tracking_url":"https:\/\/www.editorx.com\/prowebsites\/collaboration?utm_source=so&utm_medium=cpc&utm_campaign=ma_ads_edx-brand-collaboration-desginspiration-banner-blue","click_url":"https:\/\/www.editorx.com\/prowebsites\/collaboration?utm_source=so&utm_medium=cpc&utm_campaign=ma_ads_edx-brand-collaboration-desginspiration-banner-blue","format":"default","id":"613032ec66e8480bb97e9238","images":{"1x":{"h":400,"url":"https:\/\/dspncdn.com\/a1\/prm\/236x\/dbf4533a34952f07367f4766353a9428.jpg","w":236},"2x":{"h":800,"url":"https:\/\/dspncdn.com\/a1\/prm\/472x\/dbf4533a34952f07367f4766353a9428.jpg","w":472}},"impression_urls":[""],"internal":false,"media":"dbf4533a34952f07367f4766353a9428.jpg","media_poster":"https:\/\/dspncdn.com\/a1\/prm\/472x\/dbf4533a34952f07367f4766353a9428.jpg","media_type":"image","tagline":"Harness the power of Editor X and work together on the same site, at the same time.","timestamp":"1631086016991","visitor_filter":"all"}],"time":48,"user":{"has_ad_blocker":false,"is_member":false,"visitor_id":"b2f0605cc719844458efd79b47ef98d8","visitory_country":"TH"},"app_id":"79827115962","track_url":"https:\/\/analytics.designspiration.com","show":true}},"data":[{"added_at":"2015-08-05T13:55:21","affiliate":false,"annotations":["industrial","military","styling","military styling","typography","desktop","illustration","text","abstract","symbol","graphic","business","vector"],"background":"#032b41","collection_name":null,"collection_permalink":null,"description":"Design, Typography, Logo, Vintage, Texas","has_saved":false,"id":"904155295419","images":{"1x":{"h":159,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/28\/03\/a5\/2803a5775344d353a5b5b38734008486.jpg","w":236},"2x":{"h":319,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/28\/03\/a5\/2803a5775344d353a5b5b38734008486.jpg","w":472},"3x":{"h":468,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/28\/03\/a5\/2803a5775344d353a5b5b38734008486.jpg","w":692},"4x":{"h":548,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/28\/03\/a5\/2803a5775344d353a5b5b38734008486.jpg","w":810}},"media_type":"image","palette":["#032b41","#072957","#1b2d2c","#7b7b6c","#c5ad80"],"position":20,"promoted":false,"resaves":0,"seo":{"description":"","title":"Design, Typography, Logo, Vintage, Texas"},"source_domain":"workbyland.com","source_url":"http:\/\/www.workbyland.com\/design","title":"","type":"save","user_background":"#d8c9c4","user_display_name":"Ryan Harrison","user_id":3194,"user_permalink":"\/letterpresslove\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/64\/50\/64509fb3c5cfce6dd78c0b8796206712.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/64\/50\/64509fb3c5cfce6dd78c0b8796206712.jpg"},"username":"letterpresslove"},{"id":"613032ec66e8480bb97e9238_1631086016991","description":"","background":"#090ce7","click_url":"https:\/\/www.editorx.com\/prowebsites\/collaboration?utm_source=so&utm_medium=cpc&utm_campaign=ma_ads_edx-brand-collaboration-desginspiration-banner-blue","images":{"1x":{"h":400,"url":"https:\/\/dspncdn.com\/a1\/prm\/236x\/dbf4533a34952f07367f4766353a9428.jpg","w":236},"2x":{"h":800,"url":"https:\/\/dspncdn.com\/a1\/prm\/472x\/dbf4533a34952f07367f4766353a9428.jpg","w":472}},"media_type":"image","type":"save","promoted":{"internal":false,"type":"save","media_poster":"https:\/\/dspncdn.com\/a1\/prm\/472x\/dbf4533a34952f07367f4766353a9428.jpg","format":"default","timestamp":"1631086016991","advertiser":"EditorX","click_tracking_url":"https:\/\/www.editorx.com\/prowebsites\/collaboration?utm_source=so&utm_medium=cpc&utm_campaign=ma_ads_edx-brand-collaboration-desginspiration-banner-blue","id":"613032ec66e8480bb97e9238","tagline":"Harness the power of Editor X and work together on the same site, at the same time.","logo":"https:\/\/dspncdn.com\/a1\/prm_logo\/80x\/2e821ea4b882fb653be31129decd2649.jpg","logo_background":"#000000","impression_urls":[""],"visitor_filter":"all"}},{"added_at":"2013-01-11T07:36:13","affiliate":false,"annotations":["white","floor","wood","indoors","religion","light","inside","table","wall"],"background":"#484948","collection_name":"office","collection_permalink":"\/jared\/office\/","description":"spikes from the floor #wood #spikes #art #floor","has_saved":false,"id":"32566983201","images":{"1x":{"h":188,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/90\/ea\/68\/90ea68ab997c6a1926d6542b4039e62a.jpg","w":236},"2x":{"h":376,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/90\/ea\/68\/90ea68ab997c6a1926d6542b4039e62a.jpg","w":472},"3x":{"h":479,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/90\/ea\/68\/90ea68ab997c6a1926d6542b4039e62a.jpg","w":600},"4x":{"h":479,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/90\/ea\/68\/90ea68ab997c6a1926d6542b4039e62a.jpg","w":600}},"media_type":"image","palette":["#1e1e1d","#484948","#896f5e","#949290","#e4e4e3"],"position":8,"promoted":false,"resaves":0,"seo":{"description":"","title":"spikes from the floor #wood #spikes #art #floor"},"source_domain":"jarederickson.com","source_url":"http:\/\/jarederickson.com\/2013\/friday-inspiration-137\/","title":"","type":"save","user_background":"#524238","user_display_name":"Jared Erickson","user_id":128,"user_permalink":"\/jared\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/da\/24\/da2424344ef59515264ca9e9980ebb0d.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/da\/24\/da2424344ef59515264ca9e9980ebb0d.jpg"},"username":"jared"},{"added_at":"2013-03-07T04:38:36","affiliate":false,"annotations":["packaging","beer","beautiful","beautiful beer","culture","beer culture","bar","alcohol","drink","ale","glass","brewery","bottle","lager","pub","foam","cold","liquor"],"background":"#7f8279","collection_name":"Packaging","collection_permalink":"\/distinguished\/packaging\/","description":"Oh Beautiful Beer - Page 2 #beer #awesome #branding","has_saved":false,"id":"423129054835","images":{"1x":{"h":227,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/2a\/cf\/07\/2acf072e8d82c69003ac08b888bcf527.jpg","w":236},"2x":{"h":454,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/2a\/cf\/07\/2acf072e8d82c69003ac08b888bcf527.jpg","w":472},"3x":{"h":433,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/2a\/cf\/07\/2acf072e8d82c69003ac08b888bcf527.jpg","w":450},"4x":{"h":433,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/2a\/cf\/07\/2acf072e8d82c69003ac08b888bcf527.jpg","w":450}},"media_type":"image","palette":["#1a1814","#7f8279","#875e43","#b5bab0","#e0b68a"],"position":15,"promoted":false,"resaves":0,"seo":{"description":"","title":"Oh Beautiful Beer - Page 2 #beer #awesome #branding"},"source_domain":"ohbeautifulbeer.com","source_url":"http:\/\/www.ohbeautifulbeer.com\/page\/2\/","title":"","type":"save","user_background":"#eeeeee","user_display_name":"Distinguished & Co","user_id":1534,"user_permalink":"\/distinguished\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/default.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/default.jpg"},"username":"distinguished"},{"added_at":"2014-08-08T07:37:43","affiliate":false,"annotations":["ux","mindsparkle-mag","typography","paper","business","isolated","blank","illustration","template"],"background":"#f4605b","collection_name":null,"collection_permalink":null,"description":"Websites We Love \u2014 Showcasing The Best in Web Design #design #website #minimal #webdesign #typography","has_saved":false,"id":"633846363008","images":{"1x":{"h":156,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/37\/96\/5d\/37965d062236e75b6ec7fd5a2224421a.jpg","w":236},"2x":{"h":313,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/37\/96\/5d\/37965d062236e75b6ec7fd5a2224421a.jpg","w":472},"3x":{"h":459,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/37\/96\/5d\/37965d062236e75b6ec7fd5a2224421a.jpg","w":692},"4x":{"h":459,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/37\/96\/5d\/37965d062236e75b6ec7fd5a2224421a.jpg","w":692}},"media_type":"image","palette":["#74665f","#d3bfb5","#d5d5d3","#d77776","#f4605b"],"position":0,"promoted":false,"resaves":0,"seo":{"description":"","title":"Websites We Love \u2014 Showcasing The Best in Web Design #design #website #minimal #webdesign #typography"},"source_domain":"mindsparklemag.com","source_url":"http:\/\/mindsparklemag.com\/?websites?websites_html=&page=12","title":"","type":"save","user_background":"#605e5c","user_display_name":"Tamas Velociraptor Horvath","user_id":2248,"user_permalink":"\/notwo\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/af\/3a\/af3a352fbe5c83ad0c6d5fb016e56cdb.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/af\/3a\/af3a352fbe5c83ad0c6d5fb016e56cdb.jpg"},"username":"notwo"},{"added_at":"2012-10-24T09:54:50","affiliate":false,"annotations":["motorcycle","modern","warrior","modern warrior","car","wheel","transportation system","vehicle","technology","power","drive","speed","engine","equipment","sport","chrome","machine","fast"],"background":"#1a1a1c","collection_name":"Cars & Bikes","collection_permalink":"\/adamschweitzer\/cars-bikes\/","description":"TT New Generation Chopper Motorbike #tech #modern #design #futuristic #craft #illustration #industrial #art","has_saved":false,"id":"3181070014721","images":{"1x":{"h":132,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/89\/ea\/21\/89ea21e515ffe5683fee3750b5fa58ff.jpg","w":236},"2x":{"h":265,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/89\/ea\/21\/89ea21e515ffe5683fee3750b5fa58ff.jpg","w":472},"3x":{"h":337,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/89\/ea\/21\/89ea21e515ffe5683fee3750b5fa58ff.jpg","w":600},"4x":{"h":337,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/89\/ea\/21\/89ea21e515ffe5683fee3750b5fa58ff.jpg","w":600}},"media_type":"image","palette":["#0d0e0e","#1a1a1c","#3b3c3f","#7a7b7b","#c1c1c1"],"position":1,"promoted":false,"resaves":0,"seo":{"description":"","title":"TT New Generation Chopper Motorbike #tech #modern #design #futuristic #craft #illustration #industrial #art"},"source_domain":"techcracks.com","source_url":"http:\/\/techcracks.com\/2012\/10\/tt-new-generation-chopper-motorbike-concept-by-olcay-tuncay-karabulut\/","title":"","type":"save","user_background":"#eeeeee","user_display_name":"AdamSchweitzer","user_id":10170,"user_permalink":"\/adamschweitzer\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/default.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/default.jpg"},"username":"adamschweitzer"},{"added_at":"2012-08-23T15:37:59","affiliate":false,"annotations":["vol","kirkup","people","silhouette","man","indoors","window","woman","adult","business","one"],"background":"#262626","collection_name":"Designs","collection_permalink":"\/kylereed\/designs\/","description":"The National - James Kirkups portfolio #print #1950 #the #james #poster #national #kirkup","has_saved":false,"id":"319164216490","images":{"1x":{"h":334,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/63\/fb\/69\/63fb690d296f7ab81ec06c69a2ab6ca2.jpg","w":236},"2x":{"h":668,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/63\/fb\/69\/63fb690d296f7ab81ec06c69a2ab6ca2.jpg","w":472},"3x":{"h":530,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/63\/fb\/69\/63fb690d296f7ab81ec06c69a2ab6ca2.jpg","w":374},"4x":{"h":530,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/63\/fb\/69\/63fb690d296f7ab81ec06c69a2ab6ca2.jpg","w":374}},"media_type":"image","palette":["#262626","#585858","#a3a3a3","#e2e2e2","#f7f7f7"],"position":12,"promoted":false,"resaves":0,"seo":{"description":"","title":"The National - James Kirkups portfolio #print #1950 #the #james #poster #national #kirkup"},"source_domain":"cargocollective.com","source_url":"http:\/\/cargocollective.com\/jameskirkup\/The-National","title":"","type":"save","user_background":"#dfc8a4","user_display_name":"Kyle Reed","user_id":1133,"user_permalink":"\/kylereed\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/25\/1b\/251baab8500e298c17f2f80455570151.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/25\/1b\/251baab8500e298c17f2f80455570151.jpg"},"username":"kylereed"},{"added_at":"2013-06-29T07:24:36","affiliate":false,"annotations":["illustration","vector","art","chalk out","retro","graphic","sketch","sport"],"background":"#e6d6c7","collection_name":"Tony","collection_permalink":"\/patcartelli\/tony\/","description":"Print of the Day \u2013 25 by McBess \u00ab SIXAND5 \u2013 Inspiration webzine #illustration #mcbess","has_saved":false,"id":"1284852192696","images":{"1x":{"h":234,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/62\/31\/9f\/62319fd55484634747280d0dca9f17b3.jpg","w":236},"2x":{"h":469,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/62\/31\/9f\/62319fd55484634747280d0dca9f17b3.jpg","w":472},"3x":{"h":527,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/62\/31\/9f\/62319fd55484634747280d0dca9f17b3.jpg","w":530},"4x":{"h":527,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/62\/31\/9f\/62319fd55484634747280d0dca9f17b3.jpg","w":530}},"media_type":"image","palette":["#13100d","#574e44","#9d9286","#e6d6c7","#f1e4d5"],"position":18,"promoted":false,"resaves":0,"seo":{"description":"","title":"Print of the Day \u2013 25 by McBess \u00ab SIXAND5 \u2013 Inspiration webzine #illustration #mcbess"},"source_domain":"sixand5.com","source_url":"http:\/\/sixand5.com\/2012\/04\/11\/print-of-the-day-25-by-mcbess\/","title":"","type":"save","user_background":"#eeeeee","user_display_name":"Patrick Cartelli","user_id":4559,"user_permalink":"\/patcartelli\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/default.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/default.jpg"},"username":"patcartelli"},{"added_at":"2016-01-03T08:54:04","affiliate":false,"annotations":["casa","sperimentale","casa sperimentale","architecture","building","house","expression","city","urban","industry","construction","outdoors","business","family","steel","window","street"],"background":"#3b4140","collection_name":"Architecture","collection_permalink":"\/rickardarvius\/architecture\/","description":"Exploring the Ruins of Rome's Casa Sperimentale","has_saved":false,"id":"887435994435","images":{"1x":{"h":157,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/f7\/f2\/27\/f7f227c9a7860307bd1e43c7287db89d.jpg","w":236},"2x":{"h":314,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/f7\/f2\/27\/f7f227c9a7860307bd1e43c7287db89d.jpg","w":472},"3x":{"h":461,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/f7\/f2\/27\/f7f227c9a7860307bd1e43c7287db89d.jpg","w":692},"4x":{"h":600,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/f7\/f2\/27\/f7f227c9a7860307bd1e43c7287db89d.jpg","w":900}},"media_type":"image","palette":["#3b4140","#586063","#69584d","#9a9893","#dbdddd"],"position":3,"promoted":false,"resaves":0,"seo":{"description":"","title":"Exploring the Ruins of Rome's Casa Sperimentale"},"source_domain":"fubiz.net","source_url":"http:\/\/www.fubiz.net\/2016\/01\/02\/exploring-the-ruins-of-romes-casa-sperimentale\/olivierastrologo-0\/","title":"","type":"save","user_background":"#e57dec","user_display_name":"Rickard Arvius","user_id":3123,"user_permalink":"\/rickardarvius\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/47\/8f\/478f734f2c7cda849dd21a9dd7e7a189.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/47\/8f\/478f734f2c7cda849dd21a9dd7e7a189.jpg"},"username":"rickardarvius"},{"added_at":"2015-06-24T19:33:28","affiliate":false,"annotations":["logo","retro","motorcycle","badge","retro motorcycle","motorcycle badge","retro motorcycle badge","label","symbol","sign","disjunct","illustration"],"background":"#fefefd","collection_name":"Marks","collection_permalink":"\/davebullen\/marks\/","description":"Retro Motorcycle Badges #race #moto #bike #racer #logo #font #typography #light #cool #retro #vintage #hipster #badge #caferacer #motorcycle","has_saved":false,"id":"6757652896721","images":{"1x":{"h":157,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/75\/e2\/fe\/75e2fea70d1637160ecc2ee5d70da71b.jpg","w":236},"2x":{"h":314,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/75\/e2\/fe\/75e2fea70d1637160ecc2ee5d70da71b.jpg","w":472},"3x":{"h":386,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/75\/e2\/fe\/75e2fea70d1637160ecc2ee5d70da71b.jpg","w":580},"4x":{"h":386,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/75\/e2\/fe\/75e2fea70d1637160ecc2ee5d70da71b.jpg","w":580}},"media_type":"image","palette":["#37271c","#5d7661","#ccb487","#cd6837","#fefefd"],"position":5,"promoted":false,"resaves":0,"seo":{"description":"","title":"Retro Motorcycle Badges #race #moto #bike #racer #logo #font #typography #light #cool #retro #vintage #hipster #badge #caferacer #motorcycle"},"source_domain":"creativemarket.com","source_url":"https:\/\/creativemarket.com\/justliviu\/55194-retro-motorcycle-badges?utm_source=Pinterest&utm_medium=CM%20Social%20Share&utm_campaign=Product%20Social%20Share&utm_content=retro%20motorcycle%20badges","title":"","type":"save","user_background":"#eeeeee","user_display_name":"Dave Bullen","user_id":21759,"user_permalink":"\/davebullen\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/32\/49\/3249e535acda721f617766bf9cdbabe7.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/32\/49\/3249e535acda721f617766bf9cdbabe7.jpg"},"username":"davebullen"},{"added_at":"2012-11-03T10:59:49","affiliate":false,"annotations":["architecture","exterior","exterior architecture","architecture design","exterior architecture design","outdoors","house","luxury","home","tree","horizontal plane","modern","mansion","lawn","window","building","facade"],"background":"#303128","collection_name":"Architecture","collection_permalink":"\/freshome\/architecture\/","description":"SAOTA modern architecture (1) #architecture","has_saved":false,"id":"941234095473","images":{"1x":{"h":157,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/82\/52\/57\/825257b0d834abfb6217f52c80a262d3.jpg","w":236},"2x":{"h":314,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/82\/52\/57\/825257b0d834abfb6217f52c80a262d3.jpg","w":472},"3x":{"h":400,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/82\/52\/57\/825257b0d834abfb6217f52c80a262d3.jpg","w":600},"4x":{"h":400,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/82\/52\/57\/825257b0d834abfb6217f52c80a262d3.jpg","w":600}},"media_type":"image","palette":["#1c1f22","#303128","#696057","#91afd8","#b5a68e"],"position":19,"promoted":false,"resaves":0,"seo":{"description":"","title":"SAOTA modern architecture (1) #architecture"},"source_domain":"freshome.com","source_url":"http:\/\/freshome.com\/2012\/10\/30\/relaxed-atmosphere-and-expansive-views-offered-by-glen-2961-house-in-south-africa\/","title":"","type":"save","user_background":"#b5cb2d","user_display_name":"Freshome","user_id":3331,"user_permalink":"\/freshome\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/b9\/2d\/b92da734880b40b8799668f81724abb4.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/b9\/2d\/b92da734880b40b8799668f81724abb4.jpg"},"username":"freshome"},{"added_at":"2013-03-25T10:02:54","affiliate":false,"annotations":["alex","register","alex register","banner","signalise","business","text","sign","communication","signal","graffiti","street","horizontal","forbidden","send message","banking","road"],"background":"#293c50","collection_name":"Print","collection_permalink":"\/hmlaban\/print\/","description":"Alex Register www.mr-cup.com #midwest #print #banner","has_saved":false,"id":"2362219543942","images":{"1x":{"h":151,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/79\/53\/78\/795378f57ebd5c5334547d299433a3c0.jpg","w":236},"2x":{"h":302,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/79\/53\/78\/795378f57ebd5c5334547d299433a3c0.jpg","w":472},"3x":{"h":384,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/79\/53\/78\/795378f57ebd5c5334547d299433a3c0.jpg","w":600},"4x":{"h":384,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/79\/53\/78\/795378f57ebd5c5334547d299433a3c0.jpg","w":600}},"media_type":"image","palette":["#1e1410","#293c50","#748597","#804d3d","#c2d4e5"],"position":4,"promoted":false,"resaves":0,"seo":{"description":"","title":"Alex Register www.mr-cup.com #midwest #print #banner"},"source_domain":"mr-cup.com","source_url":"http:\/\/www.mr-cup.com\/blog.html","title":"","type":"save","user_background":"#eeeeee","user_display_name":"Hayley Laban","user_id":8308,"user_permalink":"\/hmlaban\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/default.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/default.jpg"},"username":"hmlaban"},{"added_at":"2014-10-02T22:38:44","affiliate":false,"annotations":["portrait","xgen","xgen portrait","powder","desktop","tree"],"background":"#fdfbfa","collection_name":"Faces","collection_permalink":"\/jethro\/faces\/","description":"XGen Portraits on Behance #face #explosion #3d #distort","has_saved":false,"id":"150681945053","images":{"1x":{"h":236,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/c3\/d9\/a1\/c3d9a13716dec6750c23dd8f8756b6d4.jpg","w":236},"2x":{"h":472,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/c3\/d9\/a1\/c3d9a13716dec6750c23dd8f8756b6d4.jpg","w":472},"3x":{"h":600,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/c3\/d9\/a1\/c3d9a13716dec6750c23dd8f8756b6d4.jpg","w":600},"4x":{"h":600,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/c3\/d9\/a1\/c3d9a13716dec6750c23dd8f8756b6d4.jpg","w":600}},"media_type":"image","palette":["#42211a","#6e473e","#936b62","#bb998f","#fdfbfa"],"position":7,"promoted":false,"resaves":0,"seo":{"description":"","title":"XGen Portraits on Behance #face #explosion #3d #distort"},"source_domain":"behance.net","source_url":"https:\/\/www.behance.net\/gallery\/19890669\/XGen-Portraits","title":"","type":"save","user_background":"#f16235","user_display_name":"Jethro Lawrence","user_id":589,"user_permalink":"\/jethro\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/27\/7b\/277bec6b6bd6afd663d492cb57059b19.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/27\/7b\/277bec6b6bd6afd663d492cb57059b19.jpg"},"username":"jethro"},{"added_at":"2012-06-01T09:30:08","affiliate":false,"annotations":["photography","layout","typography","illustration","house","family","window","business","indoors","architecture","paper","vector","apartment"],"background":"#c8bdbf","collection_name":null,"collection_permalink":null,"description":"Russian Carpet: Daily inspiration, trends, mood board. Architecture, art, design, fashion, photography. #inspiration #design #graphic #russian #carpet #blue #typography","has_saved":false,"id":"129885003771","images":{"1x":{"h":183,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/c5\/b5\/0a\/c5b50a3cc047b50f1726ed67af225187.jpg","w":236},"2x":{"h":366,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/c5\/b5\/0a\/c5b50a3cc047b50f1726ed67af225187.jpg","w":472},"3x":{"h":412,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/c5\/b5\/0a\/c5b50a3cc047b50f1726ed67af225187.jpg","w":530},"4x":{"h":412,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/c5\/b5\/0a\/c5b50a3cc047b50f1726ed67af225187.jpg","w":530}},"media_type":"image","palette":["#627bbb","#8a9cc7","#c8bdbf","#d9d9d8","#dc949b"],"position":11,"promoted":false,"resaves":0,"seo":{"description":"","title":"Russian Carpet: Daily inspiration, trends, mood board. Architecture, art, design, fashion, photography. #inspiration #design #graphic #russian #carpet #blue #typography"},"source_domain":"russiancarpet.com","source_url":"http:\/\/www.russiancarpet.com\/","title":"","type":"save","user_background":"#bd7736","user_display_name":"Joy Stain","user_id":500,"user_permalink":"\/joystain\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/60\/c1\/60c1724b839b243dcbd96c2746032a6e.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/60\/c1\/60c1724b839b243dcbd96c2746032a6e.jpg"},"username":"joystain"},{"added_at":"2014-11-13T13:27:49","affiliate":false,"annotations":["desktop","pattern","paper","color","illustration","symbol","texture","stripe","graphic"],"background":"#e7e4d0","collection_name":null,"collection_permalink":null,"description":"Image of Atmosphere #shape #organic","has_saved":false,"id":"58722263604","images":{"1x":{"h":296,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/ae\/04\/6d\/ae046dbc2484aa0cf50e1e25aee03627.jpg","w":236},"2x":{"h":593,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/ae\/04\/6d\/ae046dbc2484aa0cf50e1e25aee03627.jpg","w":472},"3x":{"h":724,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/ae\/04\/6d\/ae046dbc2484aa0cf50e1e25aee03627.jpg","w":576},"4x":{"h":724,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/ae\/04\/6d\/ae046dbc2484aa0cf50e1e25aee03627.jpg","w":576}},"media_type":"image","palette":["#c32d1f","#e7e4d0","#eb4910","#ec6b97","#f0bc17"],"position":16,"promoted":false,"resaves":0,"seo":{"description":"","title":"Image of Atmosphere #shape #organic"},"source_domain":"pinterest.com","source_url":"http:\/\/www.pinterest.com\/pin\/44824958762388221\/","title":"","type":"save","user_background":"#155a77","user_display_name":"Floris Spoelder","user_id":229,"user_permalink":"\/studioemptiness\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/73\/d4\/73d4cb9d80563e11707245ab52eeaca4.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/73\/d4\/73d4cb9d80563e11707245ab52eeaca4.jpg"},"username":"studioemptiness"},{"added_at":"2013-04-02T11:04:28","affiliate":false,"annotations":["posters","hecox","industry","retro","graphic design"],"background":"#fcc90a","collection_name":null,"collection_permalink":null,"description":"FFFFOUND! | chocosunsetchrome.jpg 1,091\u00d71,440 pixels #paint #evan #type #awesome #hecox","has_saved":false,"id":"56789815437","images":{"1x":{"h":311,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/1e\/96\/1e\/1e961e020502ed3aca110aa2d730b69b.jpg","w":236},"2x":{"h":622,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/1e\/96\/1e\/1e961e020502ed3aca110aa2d730b69b.jpg","w":472},"3x":{"h":480,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/1e\/96\/1e\/1e961e020502ed3aca110aa2d730b69b.jpg","w":364},"4x":{"h":480,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/1e\/96\/1e\/1e961e020502ed3aca110aa2d730b69b.jpg","w":364}},"media_type":"image","palette":["#cf2620","#d77327","#f9f3ee","#fcc90a","#fdd306"],"position":4,"promoted":false,"resaves":0,"seo":{"description":"","title":"FFFFOUND! | chocosunsetchrome.jpg 1,091\u00d71,440 pixels #paint #evan #type #awesome #hecox"},"source_domain":"ffffound.com","source_url":"http:\/\/ffffound.com\/image\/0ef4f2d22f5b2d3ba578972cdd087bc2427f6640","title":"","type":"save","user_background":"#b4b0a9","user_display_name":"Ferdinand-Noel Bacani","user_id":220,"user_permalink":"\/xariusound\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/00\/01\/000193dea55ad47f0e932eccf1de8aff.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/00\/01\/000193dea55ad47f0e932eccf1de8aff.jpg"},"username":"xariusound"},{"added_at":"2013-06-25T01:20:08","affiliate":false,"annotations":["illustration","pop","culture","pop culture","man","snake","art","vector","retro"],"background":"#201c1d","collection_name":"Illustration","collection_permalink":"\/andreuzaragoza\/illustration\/","description":"charles burns | Tumblr #illustration #snake","has_saved":false,"id":"339958219273","images":{"1x":{"h":359,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/66\/51\/7b\/66517b6b7e554fbaed4f6ed7e839851b.jpg","w":236},"2x":{"h":718,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/66\/51\/7b\/66517b6b7e554fbaed4f6ed7e839851b.jpg","w":472},"3x":{"h":750,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/66\/51\/7b\/66517b6b7e554fbaed4f6ed7e839851b.jpg","w":493},"4x":{"h":750,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/66\/51\/7b\/66517b6b7e554fbaed4f6ed7e839851b.jpg","w":493}},"media_type":"image","palette":["#201c1d","#844c68","#94a493","#af544b","#de4630"],"position":1,"promoted":false,"resaves":0,"seo":{"description":"","title":"charles burns | Tumblr #illustration #snake"},"source_domain":"tumblr.com","source_url":"http:\/\/www.tumblr.com\/tagged\/charles+burns","title":"","type":"save","user_background":"#f85a4e","user_display_name":"Andreu Zaragoza","user_id":1211,"user_permalink":"\/andreuzaragoza\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/29\/18\/2918d6e1466cc95e24cab59cae6436e5.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/29\/18\/2918d6e1466cc95e24cab59cae6436e5.jpg"},"username":"andreuzaragoza"},{"added_at":"2012-02-04T04:26:55","affiliate":false,"annotations":["magazine","woman","portrait","girl","one","people","young","fashion","pretty","adult","beautiful","sexy"],"background":"#eaede7","collection_name":null,"collection_permalink":null,"description":"Inspirim #magazine","has_saved":false,"id":"490007393639","images":{"1x":{"h":268,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/a2\/06\/49\/a2064980e8348ab52d8426aee5deab40.jpg","w":236},"2x":{"h":537,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/a2\/06\/49\/a2064980e8348ab52d8426aee5deab40.jpg","w":472},"3x":{"h":450,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/a2\/06\/49\/a2064980e8348ab52d8426aee5deab40.jpg","w":395},"4x":{"h":450,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/a2\/06\/49\/a2064980e8348ab52d8426aee5deab40.jpg","w":395}},"media_type":"image","palette":["#2e211c","#9a362a","#b6afa8","#d04239","#eaede7"],"position":10,"promoted":false,"resaves":0,"seo":{"description":"","title":"Inspirim #magazine"},"source_domain":"inspirimgrafik.tumblr.com","source_url":"http:\/\/inspirimgrafik.tumblr.com\/#","title":"","type":"save","user_background":"#465f75","user_display_name":"roberto montani","user_id":1798,"user_permalink":"\/robertomontani\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/53\/53\/5353f7112269523b164d1f5259ff358a.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/53\/53\/5353f7112269523b164d1f5259ff358a.jpg"},"username":"robertomontani"},{"added_at":"2014-03-17T13:37:50","affiliate":false,"annotations":["hand","bongo","one","text","people","chalk","education","chalkboard"],"background":"#1d1918","collection_name":"Badges","collection_permalink":"\/jackal\/badges\/","description":"Lower483 #mark #hand #done","has_saved":false,"id":"118526962952","images":{"1x":{"h":177,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/a1\/dc\/c5\/a1dcc522fd028d2dd0bf08ac856934ed.jpg","w":236},"2x":{"h":354,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/a1\/dc\/c5\/a1dcc522fd028d2dd0bf08ac856934ed.jpg","w":472},"3x":{"h":300,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/a1\/dc\/c5\/a1dcc522fd028d2dd0bf08ac856934ed.jpg","w":400},"4x":{"h":300,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/a1\/dc\/c5\/a1dcc522fd028d2dd0bf08ac856934ed.jpg","w":400}},"media_type":"image","palette":["#1d1918","#2c2724","#665d53","#a59b8d","#d9ccb9"],"position":2,"promoted":false,"resaves":0,"seo":{"description":"","title":"Lower483 #mark #hand #done"},"source_domain":"dribbble.com","source_url":"http:\/\/dribbble.com\/shots\/1049701-Lower-48?list=following","title":"","type":"save","user_background":"#5e2702","user_display_name":"TimMcGrath","user_id":462,"user_permalink":"\/jackal\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/12\/b5\/12b5514daa6112a8471a103a0ef218bb.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/12\/b5\/12b5514daa6112a8471a103a0ef218bb.jpg"},"username":"jackal"},{"added_at":"2012-09-02T09:31:41","affiliate":false,"annotations":["logo","slash","slash logo","logo design","word","company","word company","type","people"],"background":"#fffffe","collection_name":"Graphic Design \/\/ Type","collection_permalink":"\/almr1226\/graphic-design-type\/","description":"KIXBOX logo #logotype #font #lettering #shop #kixbox #logo #store #wear #type","has_saved":false,"id":"394189852459","images":{"1x":{"h":188,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/89\/9e\/15\/899e15e1f60529b642dfc9991e0bf182.jpg","w":236},"2x":{"h":377,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/89\/9e\/15\/899e15e1f60529b642dfc9991e0bf182.jpg","w":472},"3x":{"h":480,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/89\/9e\/15\/899e15e1f60529b642dfc9991e0bf182.jpg","w":600},"4x":{"h":480,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/89\/9e\/15\/899e15e1f60529b642dfc9991e0bf182.jpg","w":600}},"media_type":"image","palette":["#1d1813","#6a5945","#aea9a1","#cac8c3","#fffffe"],"position":16,"promoted":false,"resaves":0,"seo":{"description":"","title":"KIXBOX logo #logotype #font #lettering #shop #kixbox #logo #store #wear #type"},"source_domain":"behance.net","source_url":"http:\/\/www.behance.net\/gallery\/KIXBOX-logo-visual-identity\/4962561","title":"","type":"save","user_background":"#000000","user_display_name":"Anton Rhoden","user_id":1421,"user_permalink":"\/almr1226\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/9a\/07\/9a078fa73c12ee2d2042d7232043a1a6.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/9a\/07\/9a078fa73c12ee2d2042d7232043a1a6.jpg"},"username":"almr1226"},{"added_at":"2012-10-10T16:44:18","affiliate":false,"annotations":["business card","print design","corporate identity","product design","business","brand","brand management","heydays as","project","corporation","typography","identity","passport","citizenship","visa","trip","journey","security","paper","shopping","citizen","facts","travel","isolated","identification"],"background":"#272727","collection_name":"Sexy Print","collection_permalink":"\/onestepcreative\/sexy-print\/","description":"Heydays \u2014 Heydays #cards #business","has_saved":false,"id":3628268897,"images":{"1x":{"h":298,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/17\/4e\/9e\/174e9e22457822a015ae9e128988f854.jpg","w":236},"2x":{"h":597,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/17\/4e\/9e\/174e9e22457822a015ae9e128988f854.jpg","w":472},"3x":{"h":530,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/17\/4e\/9e\/174e9e22457822a015ae9e128988f854.jpg","w":419},"4x":{"h":530,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/17\/4e\/9e\/174e9e22457822a015ae9e128988f854.jpg","w":419}},"media_type":"image","palette":["#0d0d0c","#272727","#3a3939","#b47b6a","#c8c8c7"],"position":9,"promoted":false,"resaves":0,"seo":{"description":"","title":"Heydays \u2014 Heydays #cards #business"},"source_domain":"heydays.no","source_url":"http:\/\/heydays.no\/2011\/heydays\/","title":"","type":"save","user_background":"#ccb698","user_display_name":"Josh McDonald","user_id":15,"user_permalink":"\/onestepcreative\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/e4\/4a\/e44a1e891f7766a362bdcb59e38cf84f.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/e4\/4a\/e44a1e891f7766a362bdcb59e38cf84f.jpg"},"username":"onestepcreative"},{"added_at":"2011-09-11T19:45:42","affiliate":false,"annotations":["typography","text","signalise","symbol","business","desktop","illustration","alphabet","technology","achievement","designing","communication","creativity"],"background":"#090909","collection_name":null,"collection_permalink":null,"description":"Fonts In Use \u2013 Comedy Central #typography","has_saved":false,"id":"4912996217","images":{"1x":{"h":132,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/4d\/16\/9b\/4d169b5b133ed9907feb56d998c3eb74.jpg","w":236},"2x":{"h":264,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/4d\/16\/9b\/4d169b5b133ed9907feb56d998c3eb74.jpg","w":472},"3x":{"h":297,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/4d\/16\/9b\/4d169b5b133ed9907feb56d998c3eb74.jpg","w":530},"4x":{"h":297,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/4d\/16\/9b\/4d169b5b133ed9907feb56d998c3eb74.jpg","w":530}},"media_type":"image","palette":["#090909","#3f3a38","#909090","#ad3217","#ececec"],"position":19,"promoted":false,"resaves":0,"seo":{"description":"","title":"Fonts In Use \u2013 Comedy Central #typography"},"source_domain":"fontsinuse.com","source_url":"http:\/\/fontsinuse.com\/comedy-central\/","title":"","type":"save","user_background":"#b48f87","user_display_name":"Doug Lyon","user_id":20,"user_permalink":"\/douglyon\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/e1\/6f\/e16f8f30386c6befeb288587f2de98e5.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/e1\/6f\/e16f8f30386c6befeb288587f2de98e5.jpg"},"username":"douglyon"},{"added_at":"2011-11-03T12:13:10","affiliate":false,"annotations":["album","art","album art","beatport","paper","acrylic","canvas","creativity","artistic","graphic design","ink","painting","bright","rusty","retro"],"background":"#c6322b","collection_name":null,"collection_permalink":null,"description":"THE VINES - FUTURE PRIMITIVE - Leif Podhajsky #music #cover #album","has_saved":false,"id":"56144853696","images":{"1x":{"h":234,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/6c\/48\/ab\/6c48abf430688e15534d0d06c1b34da6.jpg","w":236},"2x":{"h":468,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/6c\/48\/ab\/6c48abf430688e15534d0d06c1b34da6.jpg","w":472},"3x":{"h":526,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/6c\/48\/ab\/6c48abf430688e15534d0d06c1b34da6.jpg","w":530},"4x":{"h":526,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/6c\/48\/ab\/6c48abf430688e15534d0d06c1b34da6.jpg","w":530}},"media_type":"image","palette":["#201c1f","#4a8198","#693172","#c6322b","#d78a22"],"position":2,"promoted":false,"resaves":0,"seo":{"description":"","title":"THE VINES - FUTURE PRIMITIVE - Leif Podhajsky #music #cover #album"},"source_domain":"leifpodhajsky.com","source_url":"http:\/\/www.leifpodhajsky.com\/1389957\/THE-VINES-FUTURE-PRIMITIVE","title":"","type":"save","user_background":"#eeeeee","user_display_name":"Daniel Petit","user_id":218,"user_permalink":"\/danielpetit\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/90\/67\/9067ef7aceafc67690465bd85a49fa35.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/90\/67\/9067ef7aceafc67690465bd85a49fa35.jpg"},"username":"danielpetit"},{"added_at":"2016-05-09T10:28:31","affiliate":false,"annotations":["illustration","blog","character","pixar","child","christmas","winter","sketch","fun","cute","son","lid","little","happiness","cap","celebration"],"background":"#fdfdfc","collection_name":null,"collection_permalink":null,"description":"Living Lines Library: Up (2009) Character Design #design #illustration #russell #up #character #pixar","has_saved":false,"id":"12852307189","images":{"1x":{"h":291,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/d5\/2e\/84\/d52e847cbafa37d1592376fca60d2354.jpg","w":236},"2x":{"h":582,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/d5\/2e\/84\/d52e847cbafa37d1592376fca60d2354.jpg","w":472},"3x":{"h":741,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/d5\/2e\/84\/d52e847cbafa37d1592376fca60d2354.jpg","w":600},"4x":{"h":741,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/d5\/2e\/84\/d52e847cbafa37d1592376fca60d2354.jpg","w":600}},"media_type":"image","palette":["#3e2619","#8b7237","#cb341b","#e5b19e","#fdfdfc"],"position":17,"promoted":false,"resaves":0,"seo":{"description":"","title":"Living Lines Library: Up (2009) Character Design #design #illustration #russell #up #character #pixar"},"source_domain":"blogspot.co.uk","source_url":"http:\/\/livlily.blogspot.co.uk\/2012\/02\/up-2009-character-design.html","title":"","type":"save","user_background":"#554d4e","user_display_name":"Drew Pickard","user_id":54,"user_permalink":"\/dpickard\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/c6\/7c\/c67c58626a2d3d364982de794dbef7f9.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/c6\/7c\/c67c58626a2d3d364982de794dbef7f9.jpg"},"username":"dpickard"},{"added_at":"2014-06-23T12:27:58","affiliate":false,"annotations":["shape","patchwork","symbol","illustration","element","disjunct","banner","desktop","flag","business","graphic","identity","sign"],"background":"#f26470","collection_name":"Good Foods Co-op","collection_permalink":"\/bullhorn\/good-foods-co-op\/","description":"Good Foods Co-Op Get to Know #visual #logos #foods #branding #pattern #interview #food #brand #identity #chicken #makers #logo #good #patchwork","has_saved":false,"id":"1100076669652","images":{"1x":{"h":133,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/8e\/72\/bc\/8e72bc20d2caa177385da5a256f10bc6.jpg","w":236},"2x":{"h":266,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/8e\/72\/bc\/8e72bc20d2caa177385da5a256f10bc6.jpg","w":472},"3x":{"h":390,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/8e\/72\/bc\/8e72bc20d2caa177385da5a256f10bc6.jpg","w":692},"4x":{"h":390,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/8e\/72\/bc\/8e72bc20d2caa177385da5a256f10bc6.jpg","w":692}},"media_type":"image","palette":["#e68994","#f0bbc2","#f26470","#fa5c70","#faf7f4"],"position":5,"promoted":false,"resaves":0,"seo":{"description":"","title":"Good Foods Co-Op Get to Know #visual #logos #foods #branding #pattern #interview #food #brand #identity #chicken #makers #logo #good #patchwork"},"source_domain":"bullhorncreative.com","source_url":"http:\/\/bullhorncreative.com\/work\/work_detail_GoodFoods.html","title":"","type":"save","user_background":"#000000","user_display_name":"Bullhorn","user_id":3945,"user_permalink":"\/bullhorn\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/8f\/7e\/8f7e69412eab03c4fdd9c45b0ba4b4ff.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/8f\/7e\/8f7e69412eab03c4fdd9c45b0ba4b4ff.jpg"},"username":"bullhorn"},{"added_at":"2017-07-06T08:30:44","affiliate":false,"annotations":["architecture","italy","snow","mountain","winter","water","travel","landscape","nature","lake","sky","outdoors","reflection","high","ice"],"background":"#eaf0f5","collection_name":"Photography","collection_permalink":"\/dmccall26\/photography\/","description":"Grand Hotel Misurina, Italy","has_saved":false,"id":"1177466408624","images":{"1x":{"h":354,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/d9\/4b\/7c\/d94b7cbae667ad8dd985a9a27bba6d1d.jpg","w":236},"2x":{"h":708,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/d9\/4b\/7c\/d94b7cbae667ad8dd985a9a27bba6d1d.jpg","w":472},"3x":{"h":960,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/d9\/4b\/7c\/d94b7cbae667ad8dd985a9a27bba6d1d.jpg","w":640},"4x":{"h":960,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/d9\/4b\/7c\/d94b7cbae667ad8dd985a9a27bba6d1d.jpg","w":640}},"media_type":"image","palette":["#243a40","#436b85","#74a1b9","#b2d0df","#eaf0f5"],"position":14,"promoted":false,"resaves":0,"seo":{"description":"","title":"Grand Hotel Misurina, Italy"},"source_domain":"inspirationde.com","source_url":"http:\/\/www.inspirationde.com\/image\/56913\/","title":"","type":"save","user_background":"#a7b3b4","user_display_name":"Dave McCall","user_id":4143,"user_permalink":"\/dmccall26\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/38\/c0\/38c0d67f3f05f6c208e09c6b1158ad2d.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/38\/c0\/38c0d67f3f05f6c208e09c6b1158ad2d.jpg"},"username":"dmccall26"},{"added_at":"2011-06-30T05:34:30","affiliate":false,"annotations":["bbb","travel","city","road","aerial","business","guidance","trip","journey","architecture","designing","tourism","urban","finance","map","outdoors","town"],"background":"#747963","collection_name":"\u00b7\u00b7\u00b7 BBB \u00b7\u00b7\u00b7","collection_permalink":"\/bensky\/bbb\/","description":"http:\/\/www.reykjavikcentermap.com #watercolors #illustrat #map #illustration #iceland #drawing","has_saved":false,"id":"163967180523","images":{"1x":{"h":176,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/b1\/9e\/93\/b19e93c13d9a427053164527c7719545.jpg","w":236},"2x":{"h":352,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/b1\/9e\/93\/b19e93c13d9a427053164527c7719545.jpg","w":472},"3x":{"h":396,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/b1\/9e\/93\/b19e93c13d9a427053164527c7719545.jpg","w":530},"4x":{"h":396,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/b1\/9e\/93\/b19e93c13d9a427053164527c7719545.jpg","w":530}},"media_type":"image","palette":["#4d4e3e","#747963","#799a9c","#a3a394","#dcdccf"],"position":13,"promoted":false,"resaves":0,"seo":{"description":"","title":"http:\/\/www.reykjavikcentermap.com #watercolors #illustrat #map #illustration #iceland #drawing"},"source_domain":"flickr.com","source_url":"http:\/\/www.flickr.com\/photos\/snorri\/5868700923\/sizes\/z\/in\/photostream\/","title":"","type":"save","user_background":"#a2a39f","user_display_name":"BenediktGansczyk","user_id":635,"user_permalink":"\/bensky\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/eb\/a8\/eba8f49016797d789c488bfa55f63b88.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/eb\/a8\/eba8f49016797d789c488bfa55f63b88.jpg"},"username":"bensky"},{"added_at":"2014-09-01T04:25:19","affiliate":false,"annotations":["shirt","designs","shirt designs","metallic","illustration","vector","symbol","business"],"background":"#202020","collection_name":"Grafik Aircraft Set 2","collection_permalink":"\/nickharrison\/grafik-aircraft-set-2\/","description":"\u2630\u272a\u2630 F-22 Raptor (on KIckstarter til Wed, Sep 24 2014) Morse code typography: F-22 Raptor (left) Stealth tactical combat aircraft (rig #silver #design #graphic #aircraft #plike #paper #metallic","has_saved":false,"id":"429776841833","images":{"1x":{"h":312,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/63\/05\/6d\/63056d966803559b0e48dc84fac2cc7d.jpg","w":236},"2x":{"h":624,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/63\/05\/6d\/63056d966803559b0e48dc84fac2cc7d.jpg","w":472},"3x":{"h":916,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/63\/05\/6d\/63056d966803559b0e48dc84fac2cc7d.jpg","w":692},"4x":{"h":916,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/63\/05\/6d\/63056d966803559b0e48dc84fac2cc7d.jpg","w":692}},"media_type":"image","palette":["#0b0d0e","#202020","#7b8182","#bebebe","#dfdfdf"],"position":8,"promoted":false,"resaves":0,"seo":{"description":"","title":"\u2630\u272a\u2630 F-22 Raptor (on KIckstarter til Wed, Sep 24 2014) Morse code typography: F-22 Raptor (left) Stealth tactical combat aircraft (rig #silver #design #graphic #aircraft #plike #paper #metallic"},"source_domain":"kickstarter.com","source_url":"https:\/\/www.kickstarter.com\/projects\/871534856\/usaf-grafik-aircraft-prints","title":"","type":"save","user_background":"#ffffff","user_display_name":"Nick Harrison","user_id":1562,"user_permalink":"\/nickharrison\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/97\/f8\/97f8762466410201a99ed2fc745ae933.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/97\/f8\/97f8762466410201a99ed2fc745ae933.jpg"},"username":"nickharrison"},{"added_at":"2012-08-15T18:59:41","affiliate":false,"annotations":["album","print","screenprinting","maximilian","schwarzkopf","maximilian schwarzkopf","percent","desktop","vector","pattern","illustration","abstract","dot"],"background":"#3c3c3c","collection_name":"Infographic","collection_permalink":"\/jethro\/infographic\/","description":"lunar calendar on the Behance Network #dots #percent","has_saved":false,"id":"150678115778","images":{"1x":{"h":157,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/bb\/26\/b9\/bb26b9278e32be224b7bf07a02f285e0.jpg","w":236},"2x":{"h":314,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/bb\/26\/b9\/bb26b9278e32be224b7bf07a02f285e0.jpg","w":472},"3x":{"h":400,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/bb\/26\/b9\/bb26b9278e32be224b7bf07a02f285e0.jpg","w":600},"4x":{"h":400,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/bb\/26\/b9\/bb26b9278e32be224b7bf07a02f285e0.jpg","w":600}},"media_type":"image","palette":["#2c2c2c","#3c3c3c","#686868","#ababab","#c7c7c7"],"position":1,"promoted":false,"resaves":0,"seo":{"description":"","title":"lunar calendar on the Behance Network #dots #percent"},"source_domain":"behance.net","source_url":"http:\/\/www.behance.net\/gallery\/lunar-calendar\/399559","title":"","type":"save","user_background":"#f16235","user_display_name":"Jethro Lawrence","user_id":589,"user_permalink":"\/jethro\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/27\/7b\/277bec6b6bd6afd663d492cb57059b19.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/27\/7b\/277bec6b6bd6afd663d492cb57059b19.jpg"},"username":"jethro"},{"added_at":"2016-01-12T07:39:02","affiliate":false,"annotations":["art","direction","art direction","daft","denim","pants","casual","fashion","people"],"background":"#cd9162","collection_name":null,"collection_permalink":null,"description":"Daft Punk #buckle #punk #belt #daft #up #1980s","has_saved":false,"id":"637493575958","images":{"1x":{"h":333,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/ca\/b9\/cc\/cab9cc1b79f72a553b7c21639d16d0a4.jpg","w":236},"2x":{"h":667,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/ca\/b9\/cc\/cab9cc1b79f72a553b7c21639d16d0a4.jpg","w":472},"3x":{"h":842,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/ca\/b9\/cc\/cab9cc1b79f72a553b7c21639d16d0a4.jpg","w":595},"4x":{"h":842,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/ca\/b9\/cc\/cab9cc1b79f72a553b7c21639d16d0a4.jpg","w":595}},"media_type":"image","palette":["#313938","#5c6460","#99512e","#cd9162","#eee8d9"],"position":6,"promoted":false,"resaves":0,"seo":{"description":"","title":"Daft Punk #buckle #punk #belt #daft #up #1980s"},"source_domain":"itsnicethat.com","source_url":"http:\/\/www.itsnicethat.com\/articles\/graphic-design-daft-punk","title":"","type":"save","user_background":"#97a093","user_display_name":"William Godwin","user_id":2263,"user_permalink":"\/william\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/41\/c5\/41c5f4d12d4b5fd75d356b39f9df94af.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/41\/c5\/41c5f4d12d4b5fd75d356b39f9df94af.jpg"},"username":"william"},{"added_at":"2012-01-05T09:13:27","affiliate":false,"annotations":["vector","bike","outer","rim","outer rim","icons","vector icons","bikeshare","school","wheel","illustration","retro","graphic","set","collection","element"],"background":"#fefefe","collection_name":null,"collection_permalink":null,"description":"Bicycle Illustrations by James Viola #bikes #circle #old #white #bicycle #school #design #illustrations #black #bicycles #and #logo","has_saved":false,"id":"376825824476","images":{"1x":{"h":506,"url":"https:\/\/dspncdn.com\/a1\/media\/236x\/c1\/c0\/8c\/c1c08c31752aab72e462f7d27cc30834.jpg","w":236},"2x":{"h":1012,"url":"https:\/\/dspncdn.com\/a1\/media\/472x\/c1\/c0\/8c\/c1c08c31752aab72e462f7d27cc30834.jpg","w":472},"3x":{"h":530,"url":"https:\/\/dspncdn.com\/a1\/media\/692x\/c1\/c0\/8c\/c1c08c31752aab72e462f7d27cc30834.jpg","w":247},"4x":{"h":530,"url":"https:\/\/dspncdn.com\/a1\/media\/originals\/c1\/c0\/8c\/c1c08c31752aab72e462f7d27cc30834.jpg","w":247}},"media_type":"image","palette":["#1a1919","#565656","#a4a3a3","#d9d8d8","#fefefe"],"position":10,"promoted":false,"resaves":0,"seo":{"description":"","title":"Bicycle Illustrations by James Viola #bikes #circle #old #white #bicycle #school #design #illustrations #black #bicycles #and #logo"},"source_domain":"dribbble.com","source_url":"http:\/\/dribbble.com\/shots\/373896-Bicycle-Vector-Pack\/attachments\/19420","title":"","type":"save","user_background":"#41202f","user_display_name":"Leigh Hibell","user_id":1358,"user_permalink":"\/madedigital\/","user_picture":{"1x":"https:\/\/dspncdn.com\/a1\/avatars\/100x\/3a\/33\/3a333a5d03e745d8d60310298713a980.jpg","2x":"https:\/\/dspncdn.com\/a1\/avatars\/400x\/3a\/33\/3a333a5d03e745d8d60310298713a980.jpg"},"username":"madedigital"}]}</script>
	<footer class="py-5 bg-dark" style="background-color: #343a40!important;padding: 3vw;">
		<div class="container"><p class="m-0 text-center text-white" style="color: #fff!important;text-align: center!important;">Copyright &copy; 2021 &mdash; Operations and Maintenance CATV</p></div>
	</footer>
    </body>
</html>