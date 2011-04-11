<div class="section">
	<div class="title_wrapper">
		<span class="title_wrapper_top"></span>
		<div class="title_wrapper_inner">
			<span class="title_wrapper_middle"></span>
			<div class="title_wrapper_content">
				<h2><?=$object;?></h2>
				<ul class="section_menu right">
					<li><a href="/admin/<?=$current_category;?>/<?=$current_module;?>" class="section_back"><span class="l"><span></span></span><span class="m"><em>Retour au listing</em><span></span></span><span class="r"><span></span></span></a></li>
					<?
					/* if we are creating the object we can delete it */
					if($object->id != 0){ ?>
						<li><a href="#" class="section_delete"><span class="l"><span></span></span><span class="m"><em>Supprimer</em><span></span></span><span class="r"><span></span></span></a></li>
					<? } ?>
					
					<? if($i18n || isset($has_many)){?>
						<li><a href="#" rel="main" class="current clickable_section section_fiche selected_lk"><span class="l"><span></span></span><span class="m"><em>Fiche</em><span></span></span><span class="r"><span></span></span></a></li>
					<? } ?>
					
					<?/* now we check for i18n on the object */ ?>
					<? if($i18n){ ?>
						<li><a href="#" rel="i18n" class="clickable_section section_i18n"><span class="l"><span></span></span><span class="m"><em>I18n</em><span></span></span><span class="r"><span></span></span></a></li>
					<?}?>
					
					<? 	
						if(isset($has_many)){
							foreach($has_many as $idmany => $valmany){
							?>
								<li><a href="#" rel="<?=$idmany;?>" class="clickable_section section_many"><span class="l"><span></span></span><span class="m"><em><?=$valmany['title'];?></em><span></span></span><span class="r"><span></span></span></a></li>
							<?
							}
						}
					?>
				</ul>
			</div>
		</div>
		<span class="title_wrapper_bottom"></span>
	</div>
	<div class="section_content">
		<span class="section_content_top"></span>
		<div class="section_content_inner">
		<div id="product_page">
			<form class="general_form fiche_form">
				<input type="hidden" name="id" id="obj_id" value="<?=(int)$object->id;?>" />
				<input type="hidden" name="class" value="<?=get_class($object);?>" />
			<div id="product_content">
				<div class="modules">
					<div id="main" class="sub_fiche">
						<div class="module">
							<div class="module_top">
								<h5>Fiche</h5>
							</div>
							<div class="module_bottom">
									<?
									$i = 1;
									$fields = $orm->getFields();
									foreach($fields as $field){
										$type = $orm->getType($field);
										?>
											<div class="form_half">
												<strong><?=$orm->getDisplay($field);?></strong><br />
												<?
												switch($type){
													case 'varchar':
														?>
														<span class="input_wrapper">
															<input type="text" class="text <?=$object->generateConstraint($field);?>" name="<?=$field;?>" value="<?=$object->$field;?>" />
														</span>
														<?
													break;
													case 'int':
														?>
														<span class="input_wrapper">
															<input type="text" class="text <?=$object->generateConstraint($field);?>" name="<?=$field;?>" value="<?=$object->$field;?>" />
														</span>
														<?
													break;
													case 'date':
														?>
														<span class="input_wrapper">
															<input type="text" class="text datepicker<?=$object->generateConstraint($field);?>" name="<?=$field;?>" value="<?=$object->$field;?>" />
														</span>
														<?
													break;
													case 'datetime':
														?>
														<span class="input_wrapper">
															<input type="text" class="text" name="<?=$field;?>" value="<?=$object->$field;?>" />
														</span>
														<?
													break;
													case 'password':
														?>
														<span class="input_wrapper">
															<input type="password" class="text" name="<?=$field;?>" value="" />
														</span>
														<?
													break;
													case 'tinyint':
														?>
														<input type="radio" name="<?=$field;?>" value="1" <?if($object->$field==1){echo "checked";}?> /> oui
														<input type="radio" name="<?=$field;?>" value="0" <?if($object->$field==0){echo "checked";}?> /> non
														<?
													break;
													case 'text':
														?>
														<textarea name="<?=$field;?>" class="<?=$object->generateConstraint($field);?>"><?=$object->$field;?></textarea>
														<?
													break;
													case 'object':
														$classname = "\\application\\".$field;
														if($classname::count()<=20){
															$objects = $classname::all();
															echo "<select name='".$field."'>";
															foreach($objects as $curr_object){
																echo "<option value='".$curr_object->id."'>".$curr_object."</option>";
															}
															echo "</select>";
														} else {
															
															?>
															<span class="input_wrapper">
																<input type="hidden" class="<?=$object->generateConstraint($field);?>" name="<?=$field?>" id="<?=$field?>" value="<?=$object->$field->id;?>" />
																<input type="text" class="text autocomplete" rel="<?=$field;?>" value="<?=$object->$field;?>" />
															</span>
															<?
														}
													break;
												}
												?>
											</div>
											<?if($i%2==0){ ?>
												<div style="clear:both"></div>
											<?}?>
										<?
										$i++;
									}
									?>
									<div style="clear:both"></div>
							</div>
						</div>
					</div>
					<? if($i18n){ ?>
					<div id="i18n" class="sub_fiche">
						<? 
						foreach($languages as $lang){
							?>
							<div class="module">
								<div class="module_top">
									<h5><?=$lang;?></h5>
								</div>
								<div class="module_bottom">
									<?
									foreach($i18nFields as $field){
										?>
											<div class="form_half">
												<strong><?=$field;?></strong><br />
												<textarea name="i18n_<?=$field;?>_<?=$lang->id;?>"><?=$object->get($field,$lang->id);?></textarea>
											</div>
										<?
									}
									?>
									<div style="clear:both"></div>
								</div>
							</div>
							<?
						}
						?>
					</div>
					<? } ?>
					<? 	
					if(isset($has_many)){
						foreach($has_many as $idmany => $valmany){
						?>
							<div id="<?=$idmany;?>" rel="<?=$idmany;?>" class="sub_fiche hasmany">
								<?=$idmany;?>
							</div>
						<?
						}
					}
					?>
				</div>
				<div class="inputs right" style="margin-top:20px">
					<span class="button blue_button search_button">
						<span>
							<span>
								<em>Enregistrer</em>
							</span>
						</span>
						<input type="submit" name="">
					</span>
				</div>
			</div>
			</form>
		</div>
		<span class="section_content_bottom"></span>
	</div>
</div>
<script>
	$(document).ready(function(){
		
		$(".fiche_form").validate({
			submitHandler: function(){
				$.post("admin/save",$(".fiche_form").serialize(),function(data){
					if(data!=$("#obj_id").val()){
						// creation d'un nouvel obj donc redir vers fiche
						location.href = "/admin/<?=$current_category;?>/<?=$current_module;?>/"+data;
					} else {
						// affiche un save ok
						msg("valid","Enregistré avec succès");
					}
				});
			}
		});
		
		<?if($object->id != 0){ ?>
		$(".section_delete").click(function(){
			if(confirm("Etes vous sur de vouloir supprimer cette fiche ?")){
				$.post("/admin/delete",{'object':'<?=$current_module;?>','id':<?=$object->id;?>},function(){
					location.href = "/admin/<?=$current_category;?>/<?=$current_module;?>";
				});
			}
		});
		<? } ?>
		
		$(".datepicker").live('mouseover',function(){
			$(this).datepicker();
		});
		
		$(".clickable_section").click(function(){
			if(!$(this).hasClass("current")){
				$("#"+$(".current").attr('rel')).hide();
				$(".current").removeClass("selected_lk");
				$(".current").removeClass("current");
				$("#"+$(this).attr('rel')).slideDown();
				$(this).addClass("current");
				$(this).addClass("selected_lk");
			}
		});
		
		$(".autocomplete").live('mouseover',function(){
			var obj = $(this);
			$(this).autocomplete({
				source: function(req,resp){
					$.getJSON("/admin/autocomplete",{'object':obj.attr('rel'),'term':req.term},function(data){
						resp(data);
					});
				},
				select: function(e,ui){
					$("#"+obj.attr('rel')).val(ui.item.id);
				}
			});
		});
		
		/* below here is only for hasmany feature 
		
		$(".hasmany").each(function(){
			$(this).load("/admin/has_many/"+$(this).attr('rel'),{'category':'<?=$current_category;?>','module':'<?=$current_module;?>','id':<?=$object->id;?>});
		});
		
		$(".mass_operation").live('click',function(){
			var object = $(this).attr('object');
			if($(".mass_checkbox:checked").length>0){
				$.post("/admin/mass_operation",{'object':$(this).attr('object'),'method':$(this).attr('rel'),'collection':$(".mass_checkbox:checked").serialize()},function(){
					$("#"+object).load("/admin/has_many/"+object,$("#currentPageInfo_"+object).serialize()+"&"+$("#formFilter_"+object).serialize());
				});
			} else {
				alert("Vous n'avez rien selectionné");
			}
		});
		
		$(".mass_selector").live('change',function(){
			if($(this).is(":checked")){
				$(".mass_checkbox").attr('checked',true);
			} else {
				$(".mass_checkbox").attr('checked',false);
			}
		});
		
		function updateListing(object){
			$("#"+object).load("/admin/has_many/"+object,$("#currentPageInfo_"+object).serialize()+"&"+$("#formFilter_"+object).serialize());
		}
		
		$(".list_pg").live('click',function(){
			$("#current_page_"+$(this).attr('object')).val($(this).attr('rel'));
			updateListing($(this).attr('object'));
		});
		
		*/
		
	});
</script>
