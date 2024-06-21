<script src="{{ url('public/admin/vendors/jquery/dist/jquery.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/bootstrap/dist/js/bootstrap.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/fastclick/lib/fastclick.js') }} "></script>
<script src="{{ url('public/admin/vendors/nprogress/nprogress.js') }} "></script>
<script src="{{ url('public/admin/vendors/gauge.js/dist/gauge.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/iCheck/icheck.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/skycons/skycons.js') }} "></script>
<script src="{{ url('public/admin/vendors/DateJS/build/date.js') }} "></script>
<script src="{{ url('public/admin/vendors/moment/min/moment.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net/js/jquery.dataTables.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-buttons/js/buttons.flash.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-buttons/js/buttons.html5.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-buttons/js/buttons.print.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }} "></script>
<script src="{{ url('public/admin/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }} "></script>
<script src="{{ url('public/admin/vendors/select2/dist/js/select2.full.min.js') }} "></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="{{ url('public/js/sweetalert2.js') }}"></script>
<script src="{{ url('public/js/fullcalendar/index.global.min.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale-all.js"></script>

<script src="{{ url('public/admin/build/js/custom.js') }} "></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var parentLink = document.querySelector('.parent_link');
        if(parentLink && typeof parentLink != 'undefined') {
	        var childMenu = parentLink.nextElementSibling;

	        parentLink.addEventListener('click', function(e) {
	            e.preventDefault(); 
	            childMenu.classList.toggle('show');
	        });
	    }
    });

    jQuery('.select2').select2();
</script>

@stack('scripts')