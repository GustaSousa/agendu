document.addEventListener("DOMContentLoaded", function () {
  const links = document.querySelectorAll(".sql_ambientes a");
  const rows = document.querySelectorAll("tbody tr");

  links.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      // Remove a seleção anterior e adiciona ao clicado
      links.forEach((l) => l.classList.remove("active"));
      this.classList.add("active");

      // Obtém o tipo do ambiente
      const filter = this.getAttribute("data-filter");

      rows.forEach((row) => {
        const ambiente = row.children[0].textContent.trim(); // Pega o tipo da coluna "Ambiente"

        // Mostra ou esconde as linhas conforme o filtro
        if (filter === "all" || ambiente === filter) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  });
});
