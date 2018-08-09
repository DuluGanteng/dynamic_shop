<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	open_form('<?php echo $id; ?>');
	first_load('<?php echo $box_loader_id; ?>', '<?php echo $box_content_id; ?>');

	$(document).off('click', '#<?php echo $btn_close_id; ?>').on('click', '#<?php echo $btn_close_id; ?>', function() {
		$('#idLoaderBoxTable').show();
		$('#idContentBoxTable').html();
		open_table();
		remove_box('#<?php echo $box_id;?>');
		first_load('idLoaderBoxTable', 'idContentBoxTable');
	});

	$(document).off('submit', '#idFormDataBarang').on('submit', '#idFormDataBarang', function(e) {
		e.preventDefault();
		submit_form(this);
	});

	function open_form(id) {
		$('#<?php echo $box_content_id; ?>').slideUp(function(){
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url().$class_link.'/open_form'; ?>',
				data: 'id='+id,
				success: function(html) {
					$('#<?php echo $box_content_id; ?>').html(html);
					$('#<?php echo $box_content_id; ?>').slideDown();
					moveTo('.main_container');
					$('#idSelType').focus();
				}
			});
		});
	}

	function submit_form(form_id) {
		$('#<?php echo $box_alert_id; ?>').html('');
		<?php
		foreach ($form_errs as $form_err) {
			echo '$(\'#'.$form_err.'\').html(\'\');';
		}
		?>
		$.ajax({
			url: "<?php echo base_url().$class_link.'/send_data'; ?>",
			type: "POST",
			data:  new FormData(form_id),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				if (data.confirm == 'success') {
					remove_box('#<?php echo $box_id;?>');
					$('#idAlertBoxTable').html(data.alert).fadeIn();
					open_table();
				}
				if (data.confirm == 'error') {
					$('#<?php echo $box_alert_id; ?>').html(data.alert);
					<?php
					foreach ($form_errs as $form_err) {
						echo '$(\'#'.$form_err.'\').html(data.'.$form_err.');';
					}
					?>
				}
				$('#idSelType').focus();
				$('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(data.csrf);
			}
		});
	}
</script>