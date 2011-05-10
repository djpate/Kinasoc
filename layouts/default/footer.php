</div>

				<!-- end #content -->
				<div id="sidebar">
					<ul>
						<li>
							<div id="search" >
								<form method="get" action="<?=\kinaf\routes::url_to("question","search");?>">
									<div>
										<input type="text" name="q" id="search-text" value="<?=strip_tags(htmlentities($_REQUEST['q']));?>" />
										<input type="submit" id="search-submit" value="GO" />

									</div>
								</form>
							</div>
							<div style="clear: both;">&nbsp;</div>
						</li>
						<li>
							<h2><?=_("Qui sommes nous ?");?></h2>
							<p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.</p>

						</li>
						<li>
							<h2><?=_("Les tags populaire");?></h2>
							<ul>
								<?
								foreach($popularTags as $tag):
									?>
										<li><a href="<?=\kinaf\routes::url_to("tags","filter",$tag);?>"><span class="tag"><?=$tag;?></span></a> x <?=$tag->used();?></li>
									<?
								endforeach;
								?>
							</ul>
						</li>
					</ul>
				</div>
				<!-- end #sidebar -->
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
	<!-- end #page -->

</div>
<div id="footer">
	<p><?=$params['footer'];?></p>
</div>
<!-- end #footer -->
<? if(isset($error)):?>
	<script>
		displayError("<?=$error;?>");
	</script>
<? endif;?>
</body>
</html>
