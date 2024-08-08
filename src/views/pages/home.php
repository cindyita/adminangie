
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
    <div id="loadEvents">
      Cargando calendario..<div class="spinner-border spinner-border-sm"></div>
    </div>
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

<?php
$addEvent = '<div>
                <form method="post" id="addEventForm">
                  <div class="mt-3">
                      <label for="title" class="form-label">Titulo:</label>
                      <input type="text" name="title" id="title" class="form-control" required>
                  </div>
                  <div class="mt-3">
                      <label for="start" class="form-label">Fecha de inicio:</label>
                      <input type="date" name="start" id="start" class="form-control">
                  </div>
                  <div class="mt-3">
                      <label for="end" class="form-label">Fecha de finalización:</label>
                      <input type="date" name="end" id="end" class="form-control">
                  </div>
                  <!----<div class="mt-3">
                      <label for="startTime" class="form-label">Hora de inicio: (Opcional)</label>
                      <input type="time" name="startTime" id="startTime" class="form-control">
                  </div>
                  <div class="mt-3">
                      <label for="endTime" class="form-label">Hora de finalización: (Opcional)</label>
                      <input type="time" name="endTime" id="endTime" class="form-control">
                  </div>
                  <div class="mt-3">
                      <label for="startRecur" class="form-label">Fecha de inicio recurrente: (Opcional)</label>
                      <input type="date" name="startRecur" id="startRecur" class="form-control">
                  </div>
                  <div class="mt-3">
                      <label for="	endRecur" class="form-label">Fecha de finalización recurrente: (Opcional)</label>
                      <input type="date" name="	endRecur" id="	endRecur" class="form-control">
                  </div>
                  <div class="mt-3">
                      <label for="daysOfWeek" class="form-label">Días de recurrencia: (Opcional)</label>
                      <input type="text" name="daysOfWeek" id="daysOfWeek" class="form-control" placeholder="Ejemplo: 1,2 (Lunes y martes)">
                  </div>-------->
                  <div class="mt-3">
                      <label for="backgroundColor" class="form-label">Color de fondo:</label>
                      <input type="color" name="backgroundColor" id="backgroundColor" class="form-control" value="#B65CFF">
                  </div>
                  <div class="mt-3">
                      <label for="borderColor" class="form-label">Color de borde:</label>
                      <input type="color" name="borderColor" id="borderColor" class="form-control" value="#B65CFF">
                  </div>
                  <div class="mt-3">
                      <label for="textColor" class="form-label">Color de texto:</label>
                      <input type="color" name="textColor" id="textColor" class="form-control" value="#ffffff">
                  </div>
                  <div class="mt-3">
                      <label for="description" class="form-label">Descripción:</label>
                      <textarea class="form-control" rows="3" name="description" id="description"></textarea>
                  </div>
                  <div class="mt-3">
                      <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Crear</button>
                  </div>
                </form>  
            </div>';
echo modal('addEvent', 'Agregar evento', $addEvent,'lg');