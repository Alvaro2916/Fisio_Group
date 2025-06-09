<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dolores Comunes</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- AOS Animation Library -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

</head>
<body>

  <section id="dolores" class="container my-5">
    <h2 class="text-center fw-bold text-danger mb-4">Dolores Comunes</h2>
    <p class="text-center mb-5" style="max-width: 800px; margin: 0 auto;">
      El dolor es una señal de que algo no está funcionando correctamente en nuestro cuerpo. Conocer su origen y tratarlo a tiempo puede prevenir complicaciones. Aquí te explicamos los dolores más comunes, sus causas, remedios y consejos para la recuperación.
    </p>

    <div class="row g-5">
      <!-- Dolor de espalda -->
      <div class="col-md-4" id="espalda" data-aos="fade-up">
        <div class="dolor-card text-center">
          <img src="assets/img/Fondos/espalda.jpg" alt="Dolor de espalda" class="img-fluid">
          <br><h5>Dolor de espalda</h5>
          <p>
            El dolor de espalda es una de las afecciones más comunes. Puede deberse a malas posturas, sedentarismo, sobrecargas, hernias o escoliosis.
            <br><br><strong>¿Qué hacer?</strong> Reposa, aplica hielo las primeras 48 horas y luego calor local. No te automediques sin consultar.
            <br><br><strong>Remedios:</strong> Fisioterapia, masajes terapéuticos, estiramientos guiados, antiinflamatorios bajo prescripción.
            <br><br><strong>Recuperación:</strong> Mantener actividad física moderada, ejercicios posturales, corrección ergonómica en el trabajo y vida diaria.
          </p>
        </div>
      </div>

      <!-- Dolor de cuello -->
      <div class="col-md-4" id="cuello" data-aos="fade-up" data-aos-delay="150">
        <div class="dolor-card text-center">
          <img src="assets/img/Fondos/cuello.jpg" alt="Dolor de cuello" class="img-fluid">
          <br><h5>Dolor de cuello</h5>
          <p>
            Común en personas que trabajan muchas horas frente a una pantalla o que sufren estrés. Puede ser cervicalgia o contractura muscular.
            <br><br><strong>¿Qué hacer?</strong> Corrige tu postura, realiza pausas activas y aplica calor si hay rigidez.
            <br><br><strong>Remedios:</strong> Ejercicios suaves de movilidad cervical, relajación muscular, fisioterapia y terapias manuales.
            <br><br><strong>Recuperación:</strong> Mantén buena postura, mejora la ergonomía del trabajo y realiza estiramientos diarios.
          </p>
        </div>
      </div>

      <!-- Dolores articulares -->
      <div class="col-md-4" id="articulaciones" data-aos="fade-up" data-aos-delay="300">
        <div class="dolor-card text-center">
          <img src="assets/img/Fondos/articu.jpeg" alt="Dolores articulares" class="img-fluid">
          <br><h5>Dolores articulares</h5>
          <p>
            Se presenta en rodillas, hombros, muñecas y dedos. Las causas más comunes son la artritis, artrosis, lesiones o sobreuso.
            <br><br><strong>¿Qué hacer?</strong> Descansa la articulación, evita movimientos repetitivos y aplica frío si hay inflamación.
            <br><br><strong>Remedios:</strong> Terapia física, medicamentos antiinflamatorios, ejercicios de fortalecimiento y uso de ortesis si es necesario.
            <br><br><strong>Recuperación:</strong> Actividad física controlada, dieta antiinflamatoria, control del peso y tratamiento médico si hay enfermedad crónica.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap & AOS JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>
