<!-- BEGIN: MAIN -->
		<h2>{PHP.L.Structure}</h2>
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		<div class="block">
			<ul class="follow">
				<li>
					<a href="{ADMIN_STRUCTURE_URL_EXTRAFIELDS}">{PHP.L.adm_extrafields_desc}</a>
				</li>
				<li>
					<a href="{ADMIN_PAGE_STRUCTURE_RESYNCALL}" class="ajax" title="{PHP.L.adm_tpl_resyncalltitle}">{PHP.L.Resync}</a>
				</li>
			</ul>
		</div>

		<!-- BEGIN: OPTIONS -->
		<div class="block">
			<form name="savestructure" id="savestructure" action="{ADMIN_STRUCTURE_UPDATE_FORM_URL}" method="post" enctype="multipart/form-data">
			<table class="cells">
				<tr>
					<td class="width20">{PHP.L.Path}:</td>
					<td class="width80">{ADMIN_STRUCTURE_PATH}</td>
				</tr>
				<tr>
					<td>{PHP.L.Code}:</td>
					<td>{ADMIN_STRUCTURE_CODE}</td>
				</tr>
				<tr>
					<td>{PHP.L.Title}:</td>
					<td>{ADMIN_STRUCTURE_TITLE}</td>
				</tr>
				<tr>
					<td>{PHP.L.Description}:</td>
					<td>{ADMIN_STRUCTURE_DESC}</td>
				</tr>
				<tr>
					<td>{PHP.L.Icon}:</td>
					<td>{ADMIN_STRUCTURE_ICON}</td>
				</tr>
				<tr>
					<td>{PHP.L.Locked}:</td>
					<td>{ADMIN_STRUCTURE_LOCKED}</td>
				</tr>
				<tr>
					<td>{PHP.L.adm_tpl_mode}:</td>
					<td>{ADMIN_STRUCTURE_TPLMODE} {ADMIN_STRUCTURE_SELECT}</td>
				</tr>
				<!-- BEGIN: EXTRAFLD -->
				<tr>
					<td>{ADMIN_STRUCTURE_EXTRAFLD_TITLE}:</td>
					<td class="{ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_EXTRAFLD}</td>
				</tr>
				<!-- END: EXTRAFLD -->
				<tr>
					<td class="valid" colspan="2"><input type="submit" class="submit" value="{PHP.L.Update}" /></td>
				</tr>
			</table>
			<p class="paging"><span class="a1"><a href="{ADMIN_STRUCTURE_CONFIG_URL}">{PHP.L.Configuration}</a></span></p>
			</form>
		</div>
		<!-- END: OPTIONS -->

		<!-- BEGIN: DEFAULT -->
		<div class="block">
			<h3>{PHP.L.editdeleteentries}:</h3>
			<form name="savestructure" id="savestructure" action="{ADMIN_STRUCTURE_UPDATE_FORM_URL}" method="post" class="ajax" enctype="multipart/form-data" >
			<table class="cells">
				<tr>
					<td class="coltop width15">{PHP.L.Path}</td>
					<td class="coltop width10">{PHP.L.Code}</td>
					<td class="coltop width20">{PHP.L.Title}</td>
					<td class="coltop width5">{PHP.L.TPL}</td>
					<td class="coltop width10">{PHP.L.Locked}</td>
					<td class="coltop width5">{PHP.L.Pages}</td>
					<td class="coltop width20">{PHP.L.Action}</td>
				</tr>
				<!-- BEGIN: ROW -->
				<tr>
					<td class="{ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_SPACEIMG}{ADMIN_STRUCTURE_PATH}</td>
					<td class="centerall {ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_CODE}</td>
					<td class="centerall {ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_TITLE}</td>
					<td class="centerall {ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_TPL_SYM}</td>
					<td class="centerall {ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_LOCKED}</td>
					<td class="centerall {ADMIN_STRUCTURE_ODDEVEN}">{ADMIN_STRUCTURE_COUNT}</td>
					<td class="centerall action {ADMIN_STRUCTURE_ODDEVEN}">
						<a title="{PHP.L.Rights}" href="{ADMIN_STRUCTURE_RIGHTS_URL}">{PHP.R.admin_icon_rights2}</a><a title="{PHP.L.Options}" href="{ADMIN_STRUCTURE_OPTIONS_URL}" class="ajax">{PHP.R.admin_icon_config}</a><!-- IF {PHP.dozvil} --><a title="{PHP.L.Delete}" href="{ADMIN_STRUCTURE_UPDATE_DEL_URL}" class="ajax">{PHP.R.admin_icon_delete}</a><!-- ENDIF --><a href="{ADMIN_STRUCTURE_JUMPTO_URL}" title="{PHP.L.Pages}" >{PHP.R.admin_icon_jumpto}</a> <a href="{ADMIN_STRUCTURE_CONFIG_URL}" title="{PHP.L.Config}" >{PHP.R.admin_icon_config}</a></td>
				</tr>
				<!-- END: ROW -->
				<tr>
					<td class="valid" colspan="8"><input type="submit" class="submit" value="{PHP.L.Update}" /></td>
				</tr>
			</table>
			</form>
			<p class="paging">{ADMIN_STRUCTURE_PAGINATION_PREV}{ADMIN_STRUCTURE_PAGNAV}{ADMIN_STRUCTURE_PAGINATION_NEXT} <span>{PHP.L.Total}: {ADMIN_STRUCTURE_TOTALITEMS}, {PHP.L.Onpage}: {ADMIN_STRUCTURE_COUNTER_ROW}</span></p>
		</div>
		<!-- END: DEFAULT -->

		<!-- BEGIN: NEWCAT -->
		<div class="block">
			<h3>{PHP.L.Add}:</h3>
			<form name="addstructure" id="addstructure" action="{ADMIN_STRUCTURE_URL_FORM_ADD}" method="post" class="ajax" enctype="multipart/form-data">
			<table class="cells">
				<tr>
					<td class="width20">{PHP.L.Path}:</td>
					<td class="width80">{ADMIN_STRUCTURE_PATH} {PHP.L.adm_required}</td>
				</tr>
				<tr>
					<td>{PHP.L.Code}:</td>
					<td>{ADMIN_STRUCTURE_CODE} {PHP.L.adm_required}</td>
				</tr>
				<tr>
					<td>{PHP.L.Title}:</td>
					<td>{ADMIN_STRUCTURE_TITLE} {PHP.L.adm_required}</td>
				</tr>
				<tr>
					<td>{PHP.L.Description}:</td>
					<td>{ADMIN_STRUCTURE_DESC}</td>
				</tr>
				<tr>
					<td>{PHP.L.Icon}:</td>
					<td>{ADMIN_STRUCTURE_ICON}</td>
				</tr>
				<tr>
					<td>{PHP.L.Locked}:</td>
					<td>{ADMIN_STRUCTURE_LOCKED}</td>
				</tr>
				<!-- BEGIN: EXTRAFLD -->
				<tr>
					<td>{ADMIN_STRUCTURE_EXTRAFLD_TITLE}:</td>
					<td>{ADMIN_STRUCTURE_EXTRAFLD}</td>
				</tr>
				<!-- END: EXTRAFLD -->
				<tr>
					<td class="valid" colspan="2">
						<input type="submit" class="submit" value="{PHP.L.Add}" />
					</td>
				</tr>
			</table>
			</form>
		</div>
		<!-- END: NEWCAT -->

<!-- END: MAIN -->