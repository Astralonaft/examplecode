<?php

echo '
    <footer class="footer bg-light mt-auto py-3">
        <div class="container m-width-680">
            <div class="container-fluid clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block small">© 1998
                    <a href="https://aanda.ru/" target="_blank">«A&amp;A» Business Travel Services Holding</a>
                </span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center small">Hand-crafted &amp; made with
                    <i class="menu-icon mdi mdi-heart text-danger"></i>
                </span>
            </div>
        </div><!-- / container -->
    </footer>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/popper.min.js"></script>
	<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/bootstrap.min.js"></script>
	<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/bootstrap-datepicker.min.js"></script>
	<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/bootstrap-datepicker.ru.min.js"></script>
	<script src="' . $HTTP . $HTTP_HOST . 'assets/js/main.js?v=' . time() . '"></script>
	<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/bootstrap-select.min.js"></script>
	' . $JS . '
	
	<!-- Модальное окно подтверждения удаления -->
	<div id="ConfirmModal" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<p class="text-center mb-4 mt-4 text-muted font-weight-bold">Вы действительно хотите удалить?</p>
				<p class="text-center mb-4 mt-4">
					<button type="button" class="btn mr-2 btn-light" data-dismiss="modal">Отмена</button>
					<button type="button" class="btn btn-primary">Удалить</button>
				</p>
			</div>
		</div>
	</div>
	<!-- / Модальное окно подтверждения удаления -->
</body>
</html>';