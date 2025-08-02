{{-- 
											Description:
								this is file contains all general scripts	
--}}


<script>
	// $.ajaxSetup({
	// 	headers: {
	// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 	}
	// });

	// check all input checkbox
	$('#checkAll').click(function () {    
		$('input:checkbox').prop('checked', this.checked);    
	});



	// Focus Search input when click ctrl+/
	$(document).bind('keydown', function(event) {
		if( event.which === 191 && event.ctrlKey ) {
			$(".app-search input").focus();
		}
	});



	// Style To Search input When Focus In And Out
	$(document).ready(function(){
		$(".app-search input").focusin(function(){
			$(this).css({
				background: "#fddc92",
				color: "black",
				fontWeight: "bold",
				transition: "all 0.5s ease-in-out",
			});
		});
		$(".app-search input").focusout(function(){
			$(this).css({
				background: "#f3f3f9",
			});
		});
	});


	// start change modal-header
	let adDButton = document.querySelector('.breadcrumb-header .right-content .add');
	// add
	adDButton.addEventListener('click', function(){
		document.querySelector('.modal .modal-header .modal-title').innerText = 'إضافة';
		document.querySelector('.modal .modal-footer #save').setAttribute('style', 'display: inline;');
		document.querySelector('.modal .modal-footer #update').setAttribute('style', 'display: none;');
		document.querySelector('.dataInput').value = "";
	});
	// edit
	$("#example1").on("click", ".edit", function(event) {
		document.querySelector('.modal .modal-header .modal-title').innerText = 'تعديل';
		document.querySelector('.modal .modal-footer #save').setAttribute('style', 'display: none;');
		document.querySelector('.modal .modal-footer #update').setAttribute('style', 'display: inline;');
	});
	// end change modal-header

	
	
	
	// change tr background when mouse hover
	// document.querySelectorAll('table tbody tr').addEventListener("mouseover", function() {
	//     this.style.background = "red";
	// });



	$('.dataTables_filter').next().remove();



		
	// file uplodad 
	var firstUpload = new FileUploadWithPreview('file_upload');



	// nice scroll bar
	// $(function() {  
	// 	$("body").niceScroll({
	// 		zindex: 20000,
	// 		scrollspeed: 100,
	// 	});
	// });
</script>

<script>
	$(document).ready(function () {
		$(".dark_theme").click(function(){
			$("body").toggleClass("dark-theme");
			$(this).css('display', 'none');
			$('.light_theme').css('display', 'block');
				
			

		});		
		
		$(".light_theme").click(function(){
			$("body").removeClass("dark-theme");
			$(this).css('display', 'none');
			$('.dark_theme').css('display', 'block');
		});		
	});

</script>

{{--  start navbar search  --}}
<script>
	$("#navbar_input_search").focus(function(){
		$(this).select();
	});

	$("#navbar_button_search").on("click", function(e){
		e.preventDefault();

		$(this).hide();
		$("#navbar_search_time_table table tbody tr").remove();
		$('#navbar_search_time_table table').hide();

		const navbar_input_search = $("#navbar_input_search").val();

		$.ajax({
			type: "GET",
			url: "{{ asset('time_table/navbar_search_in_time_table') }}",
			data: {
				search: navbar_input_search
			},
			beforeSend:function () {
				$("#navbar_spinner").css('display', 'block');
				$("#navbar_search_time_table table tbody tr").remove();
			},
			success: function(res){
				console.log(res.groups);

				if(res.groups.length > 0){
					$('#navbar_search_time_table table').slideDown();
					$("#navbar_spinner").css('display', 'none');
					$("#navbar_button_search").show();

					$.each(res.groups, function(index, value){
						$("#navbar_search_time_table table tbody").append(`
							<tr class="
								${value.class_type == 'تعوضية' ? 'substitute' : value.class_type == 'محجوزة' ? 'reserved' : '' }
							">
								<td>${value.groupName}</td>
								<td>${value.teacherName}</td>
								<td>${value.day}</td>
								<td>
									${value.from_to}
								</td>
								<td>
									<span>${value.class_type}</span>
									<p>${value.date ?? ''}</p>
								</td>
								<td>
									<span>غرفة: ${value.roomName}</span>
									<p>مستخدم: ${value.user}</p>
								</td>
								<td>${value.notes ?? ''}</td>
							</tr>
						`);
					});
				}else{
					$("#navbar_spinner").css('display', 'none');
					$("#navbar_search_time_table table tbody tr").remove();
					$('#navbar_search_time_table table').hide();
					$("#navbar_button_search").show();

					alertify.set('notifier','position', 'top-center');
					alertify.set('notifier','delay', 3);
					alertify.error("لايوجد نتائج لبحثك");
				}
			}
		});
	})

	{{--  when focusout  --}}
	$("#navbar_search_section").on('mouseleave', function() {
		$("#navbar_spinner").hide();
		$("#navbar_search_time_table table tbody tr").remove();
		$('#navbar_search_time_table table').hide();
	});
</script>
{{--  end navbar search  --}}