
<div class="d-flex justify-content-center align-items-start flex-column w-100">

  <div class="day-quote d-flex justify-content-end w-100 flex-wrap">         
    <div>
      <p id="random-quote">Cargando..</p>
    </div>
  </div>

  <div class="d-flex gap-3 flex-wrap">
    <div class="stat-card">
      <i class="fa-solid fa-file-invoice-dollar"></i>
      <div>
        <h5><?php echo $stats['sales_today'].' - '.money($stats['money_today'] ?? 0); ?><span></span></h5>
        <span>Ventas hoy</span>
      </div>
    </div>
    <div class="stat-card">
      <i class="fa-solid fa-file-invoice-dollar"></i>
      <div>
        <h5><?php echo $stats['sales_month'].' - '.money($stats['money_month'] ?? 0); ?><span></span></h5>
        <span>Ventas mes</span>
      </div>
    </div>
    <div class="stat-card">
      <i class="fa-solid fa-clipboard-check"></i>
      <div>
        <h5><?php echo $stats['orders_month'].' - '.money($stats['money_orders_month'] ?? 0); ?><span></span></h5>
        <span>Pedidos mes</span>
      </div>
    </div>
    <div class="stat-card">
      <i class="fa-solid fa-box"></i>
      <div>
        <h5><?php echo $stats['products'].' <span>(-'.($stats['products_out_stock'] ?? 0); ?>)</span></h5>
        <span>Productos</span>
      </div>
    </div>
  </div>
  <!-- <h3>Escritorio</h3> -->
  
</div>
<hr>

<div class="d-flex gap-5 flex-wrap">
  <div class="calendar">
    <div id='calendarHome' class="w-100"></div>
  </div>

  <div class="flex-grow-1">
    <form class="w-100" id="homeNotes">
      <div class="d-flex gap-2 justify-content-between align-items-center pb-2">
        <h5>Notas <div class="spinner-border spinner-border-sm" id="loadNotes"></div></h5>
        <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i></button>
      </div>
      <textarea class="form-control" rows="5" name="notes" id="notes"></textarea>  
    </form>
  </div>
</div>

