<form id="currentPageInfo">
	<input type="hidden" id="current_page" name="page" value="<?=$current_page;?>" />
	<input type="hidden" id="current_order" name="order" value="<?=$current_order;?>" />
	<input type="hidden" id="current_order_sens" name="order_sens" value="<?=$current_order_sens;?>" />
</form>
<div class="section">
	<div class="title_wrapper">
		<span class="title_wrapper_top"></span>
		<div class="title_wrapper_inner">
			<span class="title_wrapper_middle"></span>
			<div class="title_wrapper_content">
				<h2><?=$config['categories'][$current_category]['modules'][$current_module]['title'];?></h2>
			</div>
		</div>
		<span class="title_wrapper_bottom"></span>
	</div>
	<div class="section_content">
		<span class="section_content_top"></span>
		
		<div class="section_content_inner">
			
			<div style="width:700px;float:left">
				<div class="table_tabs_menu">
					<a href="/admin/<?=$current_category;?>/<?=$current_module;?>/add" class="update">
						<span>
							<span>
								<em>Ajouter</em>
							</span>
						</span>
					</a>
				</div>
			
				<div class="table_wrapper">
					<div class="table_wrapper_inner">
						<table cellpadding="0" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<? if(count($mass)>0){?><th style="padding:0px;width:20px"></th><? }?>
									<?foreach($fields as $field){
										if($field_id == $current_order){
											$class = "currentSort sort".ucfirst($current_order_sens);
										} else {
											$class = '';
										}?>
										<th class="sortable <?=$class;?>" rel="<?=$field;?>"><?=$orm->getDisplay($field);?></th>
									<?}?>
								</tr>
								<?
								if(count($page_objects) > 0){
									foreach($page_objects as $i => $object){?>
										<tr class="<? echo ($i%2==0) ? "first" : "second"; ?>">
											<? if(count($mass)>0){?><td style="padding:0px;width:20px"><input type="checkbox" name="mass[]" value="<?=$object->id;?>" class="mass_checkbox"></td><? } ?>
											<?foreach($fields as $field){
												echo "<td class='link_fiche' rel='".$object->id."'>";
												if($orm->getType($field) == "tinyint"){
													?>
													<img src="/css/admin/layout/<? echo ($object->$field) ? "approved.gif" : "action4.gif";?>" />
													<?
												} else { ?>
													<?=$object->$field;?>
												<? } 
												echo "</td>";
											}?>
										</tr>
									<?
									}
									if(count($mass)>0){?>
									<tr>
										<td style="padding:0px;width:20px"><input type="checkbox" class="mass_selector"></td>
										<td colspan="<?=count($fields);?>" >
											<?
											foreach($mass as $id => $val){?>
												<span class="mass_operation" rel="<?=$id;?>"><?=$val['title'];?></span>
											<?}?>
										</td>
									</tr>
									<? }
								} else {
									?>
									<tr>
										<td style="text-align:center" colspan="<?=count($fields);?>">
											Aucun résultat
										</td>
									</tr>
									<?
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div style="float:left">
				<div class="filter_box">
					<form id="formFilter">
						<input type="hidden" name="filter" value="1" />
						<h3>Filtre</h3>
						<?foreach($fields as $field){?>
							<h4><?=$orm->getDisplay($field);?></h4>
							<?
							$type = $orm->getType($field);
							switch($type){
								case 'object':
									$classname = "\\application\\".$field;
									$objects = $classname::all();
									?>
									<select name="filter__<?=$field;?>">
										<option value="">Indifférent</option>
										<?foreach($objects as $object){
											if($filters[$field] == $object->id){
												echo '<option value="'.$object->id.'" selected>'.$object.'</option>';
											} else {
												echo '<option value="'.$object->id.'">'.$object.'</option>';
											}
										}?>
									</select>
									<?
								break;
								case 'date':
									?>
										<div style="float:left">
											Du&nbsp;
										</div>
										<span class="input_wrapper" style="width:50px">
											<input type="text" class="text datepicker" value="<? echo (isset($filters[$field][0])) ? $filters[$field][0] : '';?>" name="filter__<?=$field;?>[]">
										</span>
										<div style="float:left">
											Au&nbsp;
										</div>
										<span class="input_wrapper" style="width:50px">
											<input type="text" class="text datepicker" value="<? echo (isset($filters[$field][1])) ? $filters[$field][1] : '';?>" name="filter__<?=$field;?>[]">
										</span>
										<div style="clear:both"></div>
									<?
								break;
								case 'datetime':
									?>
										<div style="float:left">
											Du&nbsp;
										</div>
										<span class="input_wrapper" style="width:50px">
											<input type="text" class="text datepicker" value="<? echo (isset($filters[$field][0])) ? $filters[$field][0] : '';?>" name="filter__<?=$field;?>[]">
										</span>
										<div style="float:left">
											Au&nbsp;
										</div>
										<span class="input_wrapper" style="width:50px">
											<input type="text" class="text datepicker" value="<? echo (isset($filters[$field][1])) ? $filters[$field][1] : '';?>" name="filter__<?=$field;?>[]">
										</span>
										<div style="clear:both"></div>
									<?
								break;
								case 'tinyint':
									?>
										<select name="filter__<?=$field;?>">
											<option value="" >Indifférent</option>
											<option value="1" <?=($filters[$field]==="1") ? 'selected' : '';?>>oui</option>
											<option value="0" <?=($filters[$field]==="0") ? 'selected' : '';?>>non</option>
										</select>
									<?
								break;
								default:
									?>
										<span class="input_wrapper">
											<input type="text" class="text" value="<? echo (isset($filters[$field])) ? $filters[$field] : '' ;?>" name="filter__<?=$field;?>">
										</span>
										<div style="clear:both"></div>
									<?
								break;
							}
							?>
						<?}?>
						<div class="inputs" style="margin-top:15px">
							<span class="filter_btn button blue_button search_button">
								<span>
									<span>
										<em>Filtrer</em>
									</span>

								</span>
							</span>
						</div>
						<div style="clear:both"></div>
					</form>
				</div>
			</div>
			
			
		</div>
		
		<? if($total_pages > 1) { ?>
		
		<!--[if !IE]>start pagination<![endif]-->
			<div class="pagination_wrapper">
			<span class="pagination_top"></span>
			<div class="pagination_middle">
			<div class="pagination">
				<span class="page_no">Page <?=$current_page;?> sur <?=$total_pages;?> - <?=$total_result;?> résultat(s)</span>
				
				<ul class="pag_list">
					<? if($current_page > 1){ ?>
					<li>
						<a href="javascript:void(0)" rel="<?=$current_page-1;?>" class="pag_nav list_pg">
							<span>
								<span>Précédent</span>
							</span>
						</a>
					</li>
					<? } ?>
					
					<?
					
					if($min_pagination>1){
						?>
						<li><a href="javascript:void(0)" rel="1" class="list_pg">1</a></li>
						<?
					}
					
					if($min_pagination>2){
						?>
						<li>[...]</li>
						<?
					}
					
					for($i=$min_pagination;$i<=$max_pagination;$i++){
						if($current_page == $i){
							?>
							<li><a href="javascript:void(0)" rel="<?=$i;?>" class="current_page list_pg"><span><span><?=$i;?></span></span></a></li>
							<?
						} else {
							?>
							<li><a href="javascript:void(0)" rel="<?=$i;?>" class="list_pg"><?=$i;?></a></li>
							<?
						}
					}
					
					if($max_pagination < $total_pages - 1){
						?>
						<li>[...]</li>
						<?
					}
					
					if($max_pagination < $total_pages){
						?>
						<li><a rel="<?=$total_pages;?>" class="list_pg" href="javascript:void(0)"><?=$total_pages;?></a></li>
						<?
					}
					
					if($current_page < $total_pages){ 
						?>
						<li>
							<a href="javascript:void(0)" rel="<?=$current_page+1;?>" class="list_pg pag_nav">
								<span>
									<span>Suivant</span>
								</span>
							</a>
						</li>
					<? } ?>
				</ul>
			</div>
			</div>
			<span class="pagination_bottom"></span>
			</div>
		
		<? } ?>
		
		
		<span class="section_content_bottom"></span>
	</div>
</div>
