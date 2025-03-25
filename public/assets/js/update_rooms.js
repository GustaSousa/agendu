function atualizarSalas() {
  var roomType = document.getElementById("room_type").value;
  var roomNameSelect = document.getElementById("room_name");

  // Limpar as opções atuais do room_name
  roomNameSelect.innerHTML =
    "<option value='' disabled selected>Selecione o nome do local</option>";

  // Adicionar as opções válidas com base no roomType selecionado
  if (roomType == "Auditórios") {
    var salas = ["Ana Cardoso", "Praia", "Palmeira", "Bromélia"];
    salas.sort(); // Ordenar as salas alfabeticamente
    salas.forEach(function (sala) {
      var option = document.createElement("option");
      option.value = sala;
      option.textContent = sala;
      roomNameSelect.appendChild(option);
    });
  } else if (roomType == "Salas") {
    var salas = ["MAI I", "MAI II"];
    salas.forEach(function (sala) {
      var option = document.createElement("option");
      option.value = sala;
      option.textContent = sala;
      roomNameSelect.appendChild(option);
    });

    for (var i = 101; i <= 109; i++) {
      // Exemplo de salas 101 a 105
      var option = document.createElement("option");
      option.value = i;
      option.textContent = "Sala " + i;
      roomNameSelect.appendChild(option);
    }
    for (var i = 201; i <= 215; i++) {
      // Exemplo de salas 101 a 105
      var option = document.createElement("option");
      option.value = i;
      option.textContent = "Sala " + i;
      roomNameSelect.appendChild(option);
    }
    for (var i = 301; i <= 303; i++) {
      // Exemplo de salas 101 a 105
      var option = document.createElement("option");
      option.value = i;
      option.textContent = "Sala " + i;
      roomNameSelect.appendChild(option);
    }
  } else if (roomType == "TICs") {
    var salas = ["Sala Betha", "Lab. Info. I", "Lab. Info. II"];
    salas.forEach(function (sala) {
      var option = document.createElement("option");
      option.value = sala;
      option.textContent = sala;
      roomNameSelect.appendChild(option);
    });
  } else if (roomType == "Outros") {
    var salas = ["Biblioteca"];
    salas.sort();
    salas.forEach(function (sala) {
      var option = document.createElement("option");
      option.value = sala;
      option.textContent = sala;
      roomNameSelect.appendChild(option);
    });

    for (var i = 1; i <= 21; i++) {
      var option = document.createElement("option");
      option.value = i;
      option.textContent = "Tutoria " + i;
      roomNameSelect.appendChild(option);
    }
  }
}
