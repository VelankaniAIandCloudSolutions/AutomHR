<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?=lang('edit_branch')?></h4>
		</div>
		<?php $attributes = array('class' => 'bs-example form-horizontal','id'=>'branchlisttable'); echo form_open(base_url().'all_branches/edit_branch/',$attributes); ?>
			<div class="modal-body">
				<div class="form-group">
					<label class="col-lg-4 control-label"><?=lang('branch_name')?> <span class="text-danger">*</span></label>
					<div class="col-lg-8">
						<input type="hidden" class="form-control" name="branch_id" value="<?php echo $branch_details["branch_id"]; ?>" >
						<input type="text" class="form-control" placeholder="<?=lang('branch_name')?>" name="branch_name" value="<?php echo $branch_details['branch_name']; ?>" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label"><?=lang('prefix')?> <span class="text-danger">*</span></label>
					<div class="col-lg-8">
						<input type="text" class="form-control" placeholder="<?=lang('prefix')?>" name="branch_prefix" value="<?php echo $branch_details['branch_prefix']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label"><?=lang('entity_admin')?></label>
					<div class="col-lg-8">
					<select class="select2-option form-control" style="width:100%;" name="employee[]" id="employee_id"  multiple>
						<option value=""  disabled>Select<?=lang('entity_admin')?></option>
						<?php
						if(!empty($users))	{
							foreach ($users as $user1){ ?>
								<option value="<?=$user1['id']?>"><?=$user1['fullname']?></option>
							<?php } ?>
						<?php } ?> 
					</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-4 control-label"><?=lang('branch_status')?> <span class="text-danger">*</span></label>
					<div class="col-lg-8">
						<select name="branch_status" class="form-control m-b">
							<option value="" selected disabled>Choose status</option>
							<option value="0" <?php if($branch_details['branch_status'] == 0 ){ echo "selected"; } ?>>Active</option>
							<option value="1" <?php if($branch_details['branch_status'] == 1 ){ echo "selected"; } ?>>InActive</option>
                        </select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-lg-4 control-label">Weekend (Working Days) <span class="text-danger"></span></label>
					<div class="col-lg-8">
					
					<?php
					$weekend_workdays=json_decode($branch_details['weekend_workdays']);
					
					$wa=0;
					$wb=0;
					$wc=0;
					$wd=0;
					$we=0;
					foreach($weekend_workdays as $ww)
					{
					
						if($ww=='1')
						{
							$wa=1;
						}
						if($ww=='2')
						{
							$wb=1;
						}
						if($ww=='3')
						{
							$wc=1;
						}
						if($ww=='4')
						{
							$wd=1;
						}
						if($ww=='5')
						{
							$we=1;
						}
					}
					
						// echo '<pre>';print_r($wb);exit;
					?>
					<input type="checkbox" <?php if($wa==1){echo 'checked';} ?> value="1" id="1_s" name="weekend[]" >
					<label for="1_s" class="">1st Satuday</label>
					   
					<input type="checkbox" <?php if($wb==1){echo 'checked';} ?>  value="2" id="2_s" name="weekend[]" >
					<label for="2_s" class="">2nd Satuday</label>
					
					<input type="checkbox" <?php if($wc==1){echo 'checked';} ?>   value="3" id="3_s" name="weekend[]" >
					<label for="3_s"  class="">3rd Satuday</label>
					
					<input type="checkbox" <?php if($wd==1){echo 'checked';} ?>  value="4" id="4_s" name="weekend[]" >
					<label for="4_s"  class="">4th Satuday</label>
					
					<input type="checkbox" <?php if($we==1){echo 'checked';} ?>  value="5" id="5_s" name="weekend[]" >
					<label for="5_s"  class="">5th Satuday</label>
					</div>
					<div class="col-lg-4"></div>
					<div class="col-lg-8">
						<input type="checkbox" value="6" id="6_s" name="weekend[]"  <?php if (in_array("6", $weekend_workdays)){ echo 'checked';}?>>
						<label for="6_s" class="">1st Sunday</label>
						<input type="checkbox" value="7" id="7_s" name="weekend[]" <?php if (in_array("7", $weekend_workdays)){ echo 'checked';}?>>
						<label for="2_sun"  class="">2nd Sunday</label>
						
						<input type="checkbox"  value="8" id="8_s" name="weekend[]" <?php if (in_array("8", $weekend_workdays)){echo 'checked';}?>>
						<label for="8_s"  class="">3rd Sunday</label><br>
						
						<input type="checkbox" value="9" id="9_s" name="weekend[]" <?php if (in_array("9", $weekend_workdays)){ echo 'checked';}?>>
						<label for="9_s"  class="">4th Sunday</label>
						
						<input type="checkbox" value="10" id="10_s" name="weekend[]" <?php if (in_array("10", $weekend_workdays)){ echo 'checked';}?>>
						<label for="10_s"  class="">5th Sunday</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-close" data-dismiss="modal"><?=lang('close')?></a>
				<button type="submit" class="btn btn-success" id="add_branches"><?=lang('edit_branch')?></button>
			</div>
		</form>
	</div>
</div>
<script>

	$(".select2-option").select2({
    minimumInputLength: 3,
    tags: [],
    ajax: {
        url: "<?php echo base_url('all_branches/getEmployees');?>",
        dataType: 'json',
        type: "GET",
        quietMillis: 2,
        data: function (term) {
            return {
                term: term
            };
        },
        processResults: function (data) {
			
            return {
                results: $.map(data, function (item) {
                   return {
                        text: item.fullname+' ('+item.email+')',
                        slug: item.email,
                        id: item.id
                    }
                })
            };
        }
    }
});
<?php if(!empty($users[0])){
?>
	$("#employee_id").empty();
	<?php foreach($users as $user1){?>
		$("#employee_id").append("<option value='<?php echo $user1['id'];?>' selected><?php echo $user1['fullname'].'('.$user1['email'].')';?></option>");

<?php 
	}
}?>
</script>