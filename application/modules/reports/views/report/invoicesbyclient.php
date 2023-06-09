<?php 
$cur = App::currencies(config_item('default_currency'));
$customer = ($client > 0) ? Client::view_by_id($client) : array();
?>
<div class="content">
	<div class="panel panel-white">
		<div class="panel-heading">
			<?=$this->load->view('report_header');?>
			<?php if($this->uri->segment(3) && isset($customer->co_id)){ ?>
			<a href="<?=base_url()?>reports/invoicespdf/<?=$customer->co_id;?>" class="btn btn-primary pull-right">
				<i class="fa fa-file-pdf-o"></i><?=lang('pdf')?>
			</a>
			<?php } ?>
			<button class="btn  btn-primary pull-right" onclick="export_report('invoice_client','invoicebyclient');" > <span ><i class="fa fa-file-excel-o m-r-5" aria-hidden="true"></i></span><span><?=lang('excel')?></span> </button>
		</div>
		<div class="panel-body">
			<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<i class="fa fa-info-sign"></i><?=lang('amount_displayed_in_your_cur')?>&nbsp;<span class="label label-success"><?=config_item('default_currency')?></span>
			</div>
			<div class="fill body reports-top rep-new-band">
				<div class="criteria-container fill-container hidden-print">
					<div class="criteria-band">
						<address class="row">
							<?php echo form_open(base_url().'reports/view/invoicesbyclient'); ?>
								<div class="col-md-4">
									<label><?=lang('branches')?> </label>
									<?php
									if($this->session->userdata('role_id') == 1)
									{
										$dis='';
									}
									else
									{
										$dis='disabled';
									}
									?>
									<select <?=$dis?> class="select2-option form-control" style="width:100%" name="branch_id" id="branchreportclient" >
										<option value="" disabled selected >Choose Entity</option>
										<optgroup label="<?=lang('all_branches')?>">
											<?php 
											 $all_branches = $this->db->get_where('branches',array('branch_status'=>'0'))->result_array();
											 if(!empty($all_branches)){
											foreach ($all_branches as $c){ ?>
											<?php } }  ?>
											<option value="<?=$c['branch_id']?>" <?php if($this->session->userdata('branch_id') == $c['branch_id']){ echo "selected"; } ?> ><?=ucfirst($c['branch_name'])?></option>
										</optgroup>
									</select>
								</div>
								<div class="col-md-4">
									<label><?=lang('client_name')?> </label>
									<i class="fa fa-search"></i>&nbsp;
									<span></span> <b class="caret"></b>
									<select class="select2-option form-control" style="width:100%" name="client" id="reportclient" >
										<?php if(!empty($customer)){ ?>
										<option value="<?php echo $customer->co_id; ?>" selected><?php echo $customer->company_name; ?></option>

										 <?php }else{ ?>
											<option value="" disabled selected>Choose first Entity</option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-2">  
									<button class="btn btn-success" type="submit"><?=lang('run_report')?></button>
								</div>
							</form>
						</address>
					</div>
				</div>

				<div class="rep-container">
					<div class="page-header text-center">
						<h3 class="reports-headerspacing"><?=lang('invoices_report')?></h3>
						<?php if($client != NULL){ ?>
						<h5><span><?=lang('client_name')?>:</span>&nbsp;<?=$customer->company_name?>&nbsp;</h5>
						<?php } ?>
					</div>
					<table class="table zi-table table-hover norow-action table-bordered table-striped" id="invoice_client">
						<thead>
							<tr>
								<th class="text-left">
									<div class="pull-left over-flow"><?=lang('status')?></div>
								</th>
								<th class="text-left">
									<div class="pull-left over-flow"> <?=lang('invoice_date')?></div>
								</th>
								<th class="sortable text-left">
									<div class="pull-left over-flow"> <?=lang('due_date')?></div>
								</th>
								<th class="sortable text-left">
									<div class="pull-left over-flow"> <?=lang('invoice')?>#</div>
								</th>
								<th class="sortable text-right">
									<div class=" over-flow"> <?=lang('invoice_amount')?></div>
								</th>
								<th class="sortable text-right">
									<div class=" over-flow"> <?=lang('balance_due')?></div>
								</th>
							</tr>
						</thead>

						<tbody>

						<?php 
						$due_total = 0;
						$invoice_total = 0;
						foreach ($invoices as $key => $invoice) { 
						$status = Invoice::payment_status($invoice->inv_id);
						$text_color = 'info';
						switch ($status) {
						case 'fully_paid':
						$text_color = 'success';
						break;
						case 'not_paid':
						$text_color = 'danger';
						break;
						}
						?>
							<tr>
								<td><div class="text-<?=$text_color?>"><?=lang($status)?></div></td>
								<td><?=format_date($invoice->date_saved);?></td>
								<td><?=format_date($invoice->due_date);?></td>
								<td><a href="<?=base_url()?>invoices/view/<?=$invoice->inv_id?>"><?=$invoice->reference_no?></a></td>

								<td class="text-right">
								<?php if ($invoice->currency != config_item('default_currency')) {
								$payable = Applib::convert_currency($invoice->currency, Invoice::payable($invoice->inv_id));
								echo Applib::format_currency($cur->code,$payable);
								$invoice_total += $payable;
								}else{
								$invoice_total += Invoice::payable($invoice->inv_id);
								echo Applib::format_currency($cur->code,Invoice::payable($invoice->inv_id));
								}
								?>
								</td>
								<td class="text-right">
								<?php if ($invoice->currency != config_item('default_currency')) {
								$due = Applib::convert_currency($invoice->currency, Invoice::get_invoice_due_amount($invoice->inv_id));
								$due_total += $due;
								echo Applib::format_currency($cur->code,$due);
								}else{
								$due_total += Invoice::get_invoice_due_amount($invoice->inv_id);
								echo Applib::format_currency($cur->code,Invoice::get_invoice_due_amount($invoice->inv_id));
								}
								?>
								</td>
							</tr>
							<?php } ?>

							<tr class="hover-muted">
								<td colspan="4"><?=lang('total')?></td>
								<td class="text-right"><?=Applib::format_currency($cur->code,$invoice_total)?></td>
								<td class="text-right"><?=Applib::format_currency($cur->code,$due_total)?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>