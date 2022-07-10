  <!-- Footer -->
  <footer class="footer pt-4 pb-4">
      <div class="container">
          <p class="m-0 text-white text-center">© Copyright <?php echo date("Y"); ?> | KBRTEC | Todos os direitos reservados</p>
      </div>
  </footer>

  <script src="/assets/vendor/jquery/jquery.min.js"></script>
  <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-maskmoney@3.0.2/dist/jquery.maskMoney.min.js"></script>

  <script>
      $("[data-mask='money']").maskMoney({
          allowNegative: false,
          thousands: '.',
          decimal: ','
      });

      $(document).ready(function() {
          $("[name='pretended_deadline']").change(function() {
              $(".limite-valor").removeClass('d-none');
              $(".prazo-meses .prazos").addClass('active');
              $('.prazos .box-select .content .icon').show();
              $('.prazos .box-select .content .total').hide();
              $(this).siblings('.content').find('.icon').hide();
              $(this).siblings('.content').find('.total').show();
          });
      })
  </script>
  </body>

  </html>
