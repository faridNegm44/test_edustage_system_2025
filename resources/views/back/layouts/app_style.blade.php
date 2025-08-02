<style>
	
	li::marker {
		display: none;
	}

	form .text-danger {
		font-weight: bold;
		font-size: 12px;
		margin-top: 7px;
		display: block;
	}

	.input-group-text {
		width: 38px;
		text-align: center;
	}

	.ajs-button {
		border: 0px;
		font-weight: bold;
	}

	.ajs-cancel {
		background: rgb(209, 56, 56);
		color: #fff;
	}
	.edit{
		margin: 0px 5px;
	}
	.delete{
		margin: 0px 5px;
	}
	.view{
		margin: 0px 5px;
	}
	#form {
		background-color: #eff2f7;
		padding: 30px 20px;
		border-radius: 7px;
	}
	.delete_selected_item_style{
		background: red;
		font-weight:bold;
		padding: 10px 10px;
		color: #FFF;
		position:relative;
		top: 2px;
		margin: 0px auto;
		display:block;
		text-align: center;
	}
	.delete_selected_item_style_title_head{
		color: red;
		text-decoration: underline;
	}

	.breadcrumb .active{
		color: #727bb7;
		font-weight: bold;
	}
	.form_bordred_sections{
		border: 5px solid #fff;
		/* opacity: 0.5; */
		padding: 20px 15px;
		border-radius: 15px;
		margin: 5px 0px 25px;
	}

	.app-search input{
		width: 270px;
		text-align: center;
	}

	.dt_btn{
		margin: 1px 2px;
	}

	.dropdown-divider{
		opacity: .2;
		width: 75%;
		margin: 8px auto;
	}

	.metismenu li{
		margin: 4px 0px;
	}

	/* body[data-sidebar="dark"] .mm-active .active, body[data-sidebar="colored"] .mm-active .active{
		color: #2a3042 !important;
		background: #e9e9e9;
		font-weight: bold;
	}

	body[data-sidebar="dark"].vertical-collpsed .vertical-menu #sidebar-menu ul li.mm-active .active, body[data-sidebar="colored"].vertical-collpsed .vertical-menu #sidebar-menu ul li.mm-active .active{
		color: #2a3042 !important;
		background: #e9e9e9;
		font-weight: bold;
	}

	body[data-sidebar="colored"] .mm-active>a{
		background: #fff;
		color: #34394b !important;
		font-weight: bold;
	}

	body[data-sidebar="colored"] .mm-active>a i{
		color: rgb(255, 119, 0) !important;
	}

	body[data-sidebar="colored"] .mm-active>a:hover i{
		font-size: 28px !important;
	} */
</style>










@if (app()->getLocale() == 'en')
	<style>
		.card-title span{
			float: right;
		}
		form .require_input {
			color: red;
			font-size: 8px;
			float: right;
			top: 6px;
			position: relative;
			right: 3px;
		}

	</style>
@elseif (app()->getLocale() == 'ar')
	<style>
		.card-title span{
			float: left;
		}

		form .require_input {
			color: red;
			font-size: 8px;
			float: left;
			top: 6px;
			position: relative;
			left: 3px;
		}
	</style>
@endif
