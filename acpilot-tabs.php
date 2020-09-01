<?php

session_start();
$access_level = 1; // 1=admin, 3=observer
$access_level_add = 1;
$need_defaults = 1; // Flag to read defaults files (for demo)
require($_SESSION['address'] . "/include/init.php");

$blob = sql_blob($user, $c_teli);

if (!is_string($blob)) {
	$_SESSION['data'] = $blob;
}

if ($c_task!='0' && $c_dim!='0' && !empty($_POST)){
	foreach ($_POST as $q => $a){
		$_SESSION['data'][$c_teli][$c_task][$c_dim][$q] = $a;
	}
	sql_blob($user, $c_teli, $_SESSION['data']);
}

$data = @$_SESSION['data'][$c_teli][$c_task][$c_dim];


if ($_SESSION['debug']) {
	// pp($_SESSION['data'],"DATA");
	// pp($_POST, "POST");
}

?>

<!doctype html>
<html lang="de">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Candidate review template">
    <meta name="author" content="">
    <meta name="keywords" content="teilnemher, tasks, Dimensions">

	<title>ac navigator</title>

    <script src="<?=add_js('jquery-3.4.1.min.js');?>"></script>
    <script src="<?=add_js('bootstrap.min.js');?>"></script>

	 
	<link rel="stylesheet" href="<?=add_css('bootstrap.min.css');?>" />
	  
  <link href="<?=add_css('all.min.css','vendor');?>" rel="stylesheet" type="text/css">


	<link rel="stylesheet" href="<?=add_css('bootstrap.min.css');?>" />
	<link href="<?=add_css('all.min.css','vendor');?>" rel="stylesheet" type="text/css">
		<style>
		
		
#question-list {
				max-height: 200px;
				margin-bottom: 10px;
				overflow-y: scroll;
				-webkit-overflow-scrolling: auto;
			}

			.btn-margin {
				margin: 5px;

			}
			.myclass{
			background-color:#00B0F0;
			}
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
</head>
<body>
<main>

			<header>
					<div class="navbar navbar-dark bg-blue shadow-sm">
					<div class="container d-flex justify-content-between">
					<img href="/acnavigator/images/logo.jpg" class="navbar-brand d-flex align-items-center">
					<a href="../main.php" class="navbar-brand d-flex align-items-center">Startseite</a>
				<a href="index.php" class="navbar-brand d-flex align-items-center">Cockpit</a>
				<nav class="navbar navbar-dark bg-blue navbar-expand-sm">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-2" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbar-list-2">
						<ul class="navbar-nav">
							<li class="nav-item dropdown">
								<a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Support
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									 <a class="dropdown-item" href="../faq.php">FAQ</a>
									 <a class="dropdown-item" href="../contact.php">Kontakt</a>
								</div>
							</li>
						</ul>
					</div>
				</nav>
					<nav class="navbar navbar-dark bg-blue navbar-expand-sm">
				 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-4" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	 <span class="navbar-toggler-icon"></span>
 </button>
 <div class="collapse navbar-collapse" id="navbar-list-4">
	 <ul class="navbar-nav">
			 <li class="nav-item dropdown">
			 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				 <img src="/acnavigator/images/admin_female.jpg" onerror="this.src='/acnavigator/images/user.png';" width="40" height="40" class="rounded-circle">
			 </a>
			 <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				 <a class="dropdown-item" href="profile.php">
				 <img src="/acnavigator/vendor/fontawesome-free/svgs/regular/user-circle.svg" width="18" height="18" class="rounded-circle">
				 Mein Profil</a>
				 <a class="dropdown-item" href="../main.php?logout">
				 <img src="/acnavigator/vendor/fontawesome-free/svgs/solid/sign-out-alt.svg" width="18" height="18" class="">
				 Abmelden</a>
			 </div>
		 </li>
	 </ul>
 </div>
</nav>
					</div>
			</header>
			&nbsp
   &nbsp
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-sm-2">
										<img src="/acnavigator/images/candidate_<?=(isset($defaults['candidate'][$c_teli]['gender']))?(($defaults['candidate'][$c_teli]['gender'])?'female':'male'):'robot'?>.jpg" class="img-responsive rounded-circle" style="height: 75px; width: 75px; object-fit: cover;">
                                        </div>
										<div class="col-sm-1">
										<h5 class="row card-title">Kandidat:</h5>
										</div>
										<div class="col-sm-4">
										<form name="teilnehmer_list" id="teilnehmer_list" action="beobachter.php" method="POST">
                                                <select class="form-control form-control-sm" id="teilnehmer" name="teilnehmer" onchange="this.form.submit()">
													<option value="" <?=($_SESSION['c_teilnehmer']==0)?'selected':''?> disabled hidden>Bitte w&auml;hlen</option>
													<?php foreach($defaults['candidate'] as $candid):?>
													<option value="<?=$candid['id']?>" <?=($_SESSION['c_teilnehmer']===$candid['id'])?'selected':''?> > <?=$candid['first_name']." ".$candid['last_name']?></option>
													<?php endforeach;?>
												</select>
												</form>
										</div>
                                    &nbsp
									<div class="col-sm-1">
									<h5 class="row card-title">Ubung:</h5>
									</div>
									<div class="col-sm-3">
									<p> <?=($_SESSION['c_task']==0)?'selected':''?></p>
									</div>
                                </div>
								</div>
								</div>
                        </div>
                    </div>
                </div>
            </div>
						<br>
						<a href="schedule-1.php">	<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick=""><img src="/acnavigator/vendor/fontawesome-free/svgs/solid/arrow-left.svg" width="18" height="18" class=""> Zurück</button></a>
						&nbsp
						<br>

            &nbsp

<?php if (@$c_teli!='0' && @$c_dim!='0' && @$c_task!='0'):?>
<div class="tab" id="dlist">
  <button class="tablinks" id="btn_<?=$counter?>_<?=$m?>" onclick="opendimension(event, 'dimension1')"><?=$defaults['dimension'][$c_dim]['title']?></button>
</div>
<?php endif;?>
<?php if (@$c_dim!='0'):?>
<div id="dimension1" class="tabcontent d">
  <div class="row">
                <div class="col-md-12">

                        <div class="card-body">
						<div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-sm-2">
											  <h6 class="card-title"><?=$defaults['dimension'][$c_dim]['title']?> </h6>
                                        </div>
										<div class="col-sm-1">
										<a href="#" class="card-link" data-toggle="modal" style="color:black;" data-target="#<?=$dim?>"><img src="/acnavigator/images/information.png" alt="info"></a>
										</div>
									<div class="col-sm-3">
									<input type="checkbox" id="" onclick="identicalselection()"> Alle Anker der Dimension identisch
									</div>
                                </div>
								</div>
								</div>

							<div class="row">
                                <div class="col-md-12 small">
								<form method="POST" action="beobachter.php">
                                    <ul class="list-group list-group-flush" id="qlist" >
										<?php
											// $questionsArray = $defaults['dimension'][$c_dim]['items'];
											$questionsArray = $defaults['task'][$c_task]['dim'][$c_dim];

											foreach($questionsArray as $counter):
												$question = $defaults['dimension'][$c_dim]['items'][$counter][1][""];
												$numberOfButtons = count($defaults['dimension'][$c_dim]['items'][$counter][2]);
										?>
										<li class="list-group-item list-group-item-action">
											<div class="row">
												<p class="col-md-7"> <?=$question?> </p>
												<div class="col-md-5 q" id="btn_list_<?=$counter?>">
												<?php
													@$qa=[$counter, $data[$counter]];
												?>
												<?php
												for($i=1; $i<=$numberOfButtons; $i++):?>
											<button type="button" id="btn_<?=$counter?>_<?=$i?>" data-toggle="button" aria-pressed="false" class="btn btn-warning btn-margin rounded-circle font-weight-bold <?php if ( $qa[0] == $counter && $qa[1] == $i): ?> active <?php endif; ?>" <?php if ( $qa[0] == $counter && $qa[1] == $i): ?> checked="true" <?php endif; ?> onclick="buttonselection(btn_<?=$counter?>_<?=$i?>, [<?=$counter?>,<?=$i?>] )"><?=$i?></button>
												<?php endfor;?>
												</div>
											</div>
										</li>
										<?php endforeach;?>
                                    </ul>
								<div class="row">
								<div class="col-sm-12">
							<form method="post" action="">
							<textarea name="comments" cols="200" rows="3" class="textarea" placeholder="Enter comments here....."></textarea><br>
							<input type="submit" value="Submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
							</form>
                            </div>
							 </div>
		</form>
                        </div>
                    </div>
                </div>
			</div>
</div>
</div>
<?php endif;?>

<?php foreach($defaults['dimension'] as $dim): ?>
		<div id="<?=$dim['id']?>" class="modal" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title"><?=$dim['title']?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
						</div>
						<div class="modal-body">
<textarea id="form10" class="md-textarea form-control" rows="5" placeholder="Enter Text Here"></textarea>
						</div>
			<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Schlie&szlig;en</button>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>


<script>
// dimension tabs
function opendimension(evt, dimension) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(dimension).style.display = "block";
  evt.currentTarget.className += " active";
  send_post(event,dimension)
}

function send_post(event, val)
{
	result = []
	$.each($("#dimension1"), function( index, value ) {

		$.each($(value).find("div.d").children(), function ( m, x){
			if ( $(v).attr("checked") === "checked" ){
				result.push($(x).attr("id"))
			}
		});

	});
	result = parse_result(result)

	$("#submit_form").empty();

	$.each(result, function (m,x){
		$('<input>').attr({
    		type: 'hidden',
			name: x[0],
			id: x[0],
			value: x[1]
	}	).appendTo('#submit_form');
	})
    document.submit_form.submit();
}

function parse_result(r){
	ret = [];
	$.each(r, function (m,x){
		btn = x.split("_");
		ret.push([btn[1], btn[2]]);
	})
	return ret;	
}

// rating buttons
function buttonselection(event, p)
{
	btn_list = $(event).parent();

	// console.log(p);

	$.each(btn_list.children(), function( index, value ) {

		if ( $(value).attr("id") === $(event).attr("id") ){
			btn_list.children(index).addClass("active");
			$(value).attr('checked', true)
		} else {
			btn_list.children(index).removeClass("active");
			$(value).attr('checked', false)
		}

	});
	send_post(event, p);

}

function send_post(event, val)
{
	result = []
	$.each($("#qlist").children(), function( index, value ) {

		$.each($(value).find("div.q").children(), function ( i, v){
			if ( $(v).attr("checked") === "checked" ){
				result.push($(v).attr("id"))
			}
		});

	});
	result = parse_result(result)

	$("#submit_form").empty();
	
$.each(result, function (i,v){
		$('<input>').attr({
    		type: 'hidden',
			name: v[0],
			id: v[0],
			value: v[1]
	}	).appendTo('#submit_form');
	})

    document.submit_form.submit();
}

function parse_result(r){
	ret = [];
	$.each(r, function (i,v){
		btn = v.split("_");
		ret.push([btn[1], btn[2]]);
	})
	return ret;
}
	
</script>
   
</body>
</html> 