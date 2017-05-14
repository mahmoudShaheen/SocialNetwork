<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Sparkle
 * @since Sparkle 1.0
 */

include("../includes/header.php");

global $cse;


?>
<div class="container">
	<div class="row">
	
		<div id="primary" class="content-area col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<div id="content" class="site-content" role="main">

				<div class="page-wrapper">
					<div class="page-content">
						<?php echo "error404"; ?>
					</div><!-- .page-content -->
				</div><!-- .page-wrapper -->

			</div><!-- #content -->
		</div><!-- #primary -->
	
	</div><!-- .row -->
</div><!-- .container -->
<?php include("../includes/footer.php"); ?>