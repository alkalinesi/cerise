<?php
require_once('../inc/inc.php');

if (isset($_GET['task']) && $_GET['task'] == 'export') {
	
	$query = $mysqli->query('SELECT * FROM rsvps');
	
	$rsvps = array();
	$rsvps[] = ['ID', 'RSVP Code', 'First Name', 'Last Name', 'Email', 'Guest First Name', 'Guest Last Name', 'Questions', 'Submitted'];
	
	while ($rsvp = $query->fetch_array(MYSQLI_ASSOC)) {
		
		$rsvps[] = $rsvp;
		
	}
	
	$query->close();
	$mysqli->close();
	
	outputCSV('rsvp-export.csv', $rsvps, false);

}

$where = '';
$guest = false;

$current_page = 1;	

if (isset($_GET['page'])) {
	$current_page = $_GET['page'];
}

$per_page = 20;

$count = $mysqli->query('SELECT COUNT(*) FROM rsvps' . $where);
$count_array = $count->fetch_array();
$count->close();

$total_rows = $count_array[0];
$total_pages = ceil($total_rows / $per_page);

if ($current_page < 1) {
	$current_page = 1;
}

if ($current_page > $total_pages) {
	$current_page = $total_pages;
}

$start = ($current_page - 1) * $per_page;

$query = $mysqli->query('SELECT * FROM rsvps'. $where .' LIMIT ' . $start .', '. $per_page);
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Cerise RSVPs</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/rsvp-admin.virginhotels.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Cerise RSVPs</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="index.php?task=export">Export</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3 col-md-2 sidebar">
					<ul class="nav nav-sidebar">
						<li class="active"><a href="index.php">All RSVPs</a></li>
					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header">Guests</h1>

					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Id</th>
									<?php /*<th>Code</th>*/ ?>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Email Address</th>
									<?php
									if ($guest !== 0) {
									?>
									<th>Guest First Name</th>
									<th>Guest Last Name</th>
									<?php
									}
									?>
									<th>Submitted</th>
								</tr>
							</thead>
							<tbody>
								<?php
								while ($rsvp = $query->fetch_array()) {
								?>
									<tr>
										<td><?php echo $rsvp['id']; ?></td>
										<?php /*<td><?php echo $rsvp['rsvp_code']; ?></td>*/ ?>
										<td><?php echo $rsvp['first_name']; ?></td>
										<td><?php echo $rsvp['last_name']; ?></td>
										<td><?php echo $rsvp['email_address']; ?></td>
										<?php
										if ($guest !== 0)	{
										?>
										<td><?php echo $rsvp['guest_first_name']; ?></td>
										<td><?php echo $rsvp['guest_last_name']; ?></td>
										<?php
										}
										?>
										<td><?php echo date('m/d/Y g:ia', strtotime($rsvp['created'])); ?></td>
									</tr>
								<?php
								}
								$query->close();	
								?>
							</tbody>
						</table>
					</div>
					
					<nav>
						<ul class="pagination">
							<li<?php echo $current_page == 1 ? ' class="disabled"' : ''; ?>>
								<?php
								if ($current_page > 1) {
								?>
								<a href="index.php?page=<?php echo $current_page - 1; echo $guest !== false ? '&guest=' . $guest : ''; ?>" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
								</a>
								<?php
								} else {
								?>
								<a aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
								</a>
								<?php
								}
								?>
							</li>
							<?php
							for ($i = 1; $i < $total_pages + 1; $i++) {
							?>	
								<li<?php echo $i == $current_page ? ' class="active"' : ''; ?>><a href="index.php?page=<?php echo $i; echo $guest !== false ? '&guest=' . $guest : ''; ?>"><?php echo $i; ?></a></li>
							<?php
							}
							?>
							<li<?php echo $current_page == $total_pages ? ' class="disabled"' : ''; ?>>
								<?php
								if ($current_page < $total_pages) {
								?>
								<a href="index.php?page=<?php echo $current_page + 1; echo $guest !== false ? '&guest=' . $guest : ''; ?>" aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
								<?php
								} else {
								?>
								<a aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
								<?php	
								}
								?>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>


        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    </body>
</html>
<?php
$mysqli->close();
?>