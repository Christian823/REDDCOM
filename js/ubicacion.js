function obtenerUbicacion() {
  if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function (position) {
      let latitude = position.coords.latitude;
      let longitude = position.coords.longitude;

      document.getElementById("latitud").value = latitude;
      document.getElementById("longitud").value = longitude;
    });
  } else {
    console.log("La geolocalización no está disponible en este navegador.");
  }
}

window.onload = obtenerUbicacion;
