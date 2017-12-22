	<footer class="text-center" id="footer">
	&copy; Copyright 2017 TwitterClone
	</footer>



<script>
jQuery(window).scroll(function(){
	var vscroll=jQuery(this).scrollTop();
		jQuery('#logotext').css({
		"transform":"translate(0px, "+vscroll/2+"px)"
	});
		jQuery('#back-flower').css({
		"transform":"translate("+vscroll/5+"px, -"+vscroll/12+"px)"
	});
		jQuery('#fore-flower').css({
		"transform":"translate(0px, -"+vscroll/2+"px)"
	});

	});
	function detailsmodal(id){
	var data={"id" : id};
	jQuery.ajax({
	url:"/online/includes/detailsmodal.php",
	method: "post",
	data:data,
	success:function(data){
	jQuery('body').append(data);
	jQuery('#details-modal').modal('toggle');
	},
	error:function(){alert("Error");}
	});
	}
	function update_cart(mode, edit_id, edit_size){
	var data={"mode":mode, "edit_id":edit_id, "edit_size":edit_size};
		jQuery.ajax({
			url : '/online/admin/parsers/update_cart.php',
			method : 'post',
			data : data,
			success :function(){location.reload();},
			error : function(){alert("Sth went wrong");}

		});
	}
	function add_to_cart(){
		jQuery('#modal_errors').html("");
	var size=jQuery('#size').val();
	var quantity=jQuery('#quantity').val();
	var available=jQuery('#available').val();
	var error='';
	var data=jQuery('#add_product_form').serialize();
	if(size==''||quantity=='' || quantity==0){
		error+='<p class="text-center text-danger">You must choose a size and quantity.</p>';
		jQuery('#modal_errors').html(error);
		return;
	}else if(quantity>available){
		error+='<p class="text-center text-danger">There are only <b>'+available+'</b> available. Please don\'t select more.</p>';
		jQuery('#modal_errors').html(error);
		return;
	} else{
		jQuery.ajax({
			url : '/online/admin/parsers/add_cart.php',
			method : 'post',
			data : data,
			success :function(){
				location.reload();
			},
			error : function(){alert("Sth went wrong");}

		});
	}

}

</script>
</body>
</html>
