<?php // includes/footer.php ?>
  <footer class="footer">
    <div class="container footer-inner">
      <div class="footer-brand">
        <span class="logo-icon" style="font-size:20px;">🍽️</span>
        <span><strong>FOODSPOT</strong> — Encontrá los mejores restaurantes de Costa Rica</span>
      </div>
      <div class="footer-links">
        <a href="ayuda.php">Ayuda</a>
        <a href="index.php">Inicio</a>
        <a href="catalogo.php">Catálogo</a>
        <a href="busqueda.php">Buscar</a>
      </div>
      <p style="color:var(--muted);font-size:12px;margin:8px 0 0;">
        © 2026 FOODSPOT 
      </p>
    </div>
  </footer>
  <script src="js/app.js"></script>
  <?php if(isset($scripts_extra)) echo $scripts_extra; ?>
</body>
</html>
