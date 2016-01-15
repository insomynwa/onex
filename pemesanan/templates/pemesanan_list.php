<?php 
$nmr = $attributes['nomor'];//var_dump($attributes['invoice']);
if( sizeof($attributes['invoice']) > 0 ): ?>
<table class="table table-hover table-responsive">
	<tr><th>No</th>
		<th>Invoice</th>
		<th>Total</th>
		<th>Pembayaran</th>
		<th>Jam Pengiriman</th>
		<th>Status</th>
		<th></th>
		<th>Manage</th>
	</tr>
<?php for( $i=0; $i<sizeof( $attributes['invoice']) ; $i++ ): ?>
	<?php 
		$invoice = $attributes['invoice'][$i];
		$total = $attributes['total_pemesanan'][$i];
		$distributor = $attributes['distributor'][$i];
	?>
	<tr>
		<td><?php echo $nmr; ?></td>
		<td><?php echo $distributor->GetKode().''.$invoice->GetUser().''.$invoice->GetNomor(); ?></td>
		<td>Rp.<?php echo $total; ?></td>
		<td><?php if( $invoice->GetTipeBayar() == 1) echo "Transfer "; else echo "COD"; ?>
		<?php if( $invoice->GetTipeBayar() == 1): ?>
		<?php echo $attributes['bank'][$i]->GetNama(); ?>
		<?php endif; ?>
		</td>
		<td><?php if( ($invoice->GetJamKirim()==$invoice->GetTanggalUserConfirm()) && ($invoice->GetStatusAdminConfirm()==0) ) echo "Sekarang"; else echo date( "j M Y, H:i", strtotime( $invoice->GetJamKirim())); ?></td>
		<td><?php echo $attributes['status'][$i]->GetStatus(); ?></td>
		<td><a class="detail-link" id="invoice_<?php echo $invoice->GetId(); ?>" data-toggle="modal" href="#modal-invoice" >Detail</a></td>
		<td>
            <?php if($attributes['status'][$i]->GetId()!=3): ?>
			<a class="konfirmasi-link" id="invoice_<?php echo $invoice->GetId(); ?>" data-toggle="modal" href='#modal-invoice'>KONFIRMASI</a>
            <?php endif; ?>
		</td>
	</tr>
	<?php $nmr += 1; ?>
<?php endfor; ?>
</table>
<?php else: ?>
<p>Belum ada data.</p>
<?php endif; ?>
<div class="modal fade" id="modal-invoice" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" id="modal-invoice-body">

                <?php //if( sizeof( $attributes['bank'])): ?>
                <!-- <form id="form-modal-pembayaran">
                    <?php //for( $i=0; $i < sizeof($attributes['bank']); $i++): ?>
                    <input type="radio" class="bank-radio" name="bank-radio" value="<?php //echo $attributes['bank'][$i]->GetId(); ?>" <?php //if($i==0) echo 'checked'; ?> /> <span><?php //echo $attributes['bank'][$i]->GetNama(); ?></span>, <span><?php //echo $attributes['bank'][$i]->GetNoRekening(); ?></span> a.n. <span><?php //echo $attributes['bank'][$i]->GetPemilik(); ?></span><br />
                    <?php //endfor; ?>
                    <input type="hidden" id="invoice-id" name="invoice-id" />
                    <input type="submit" name="pembayaran-submit" value="Konfirmasi Transfer Pembayaran" />
                </form> -->
                <?php //endif; ?>
                
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready( function($) {
	$("a.detail-link").click( function() {
        var inv = (this.id).split('_').pop();
        var data = {
            'action' : 'AjaxRetrieveInvoiceDetail',
            'invoice': inv
        };

        $.get( ajax_one_express.ajaxurl, data, function ( response) {
            $("div#modal-invoice-body").html(response);
            $("h4.modal-title").html("Pemesanan Baru - Detail");
        });
    });
    $("a.konfirmasi-link").click( function() {
    	var inv = (this.id).split('_').pop();
        var data = {
            'action' : 'AjaxRetrieveStatusPemesanan',
            'invoice': inv
        };

        $.get( ajax_one_express.ajaxurl, data, function (response) {
        	$("div#modal-invoice-body").html(response);
            $("h4.modal-title").html("Pemesanan Baru - Status");
        });
    });

});
</script>