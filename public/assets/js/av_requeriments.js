document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("av_requirements");
  const selectedItems = document.getElementById("selectedItems");
  const hiddenInput = document.getElementById("hidden_av_requirements");

  let selectedValues = [];

  function addItem(value) {
    value = value.trim();
    if (value !== "" && !selectedValues.includes(value)) {
      selectedValues.push(value);
      updateSelectedItems();
    }
    input.value = ""; // Limpa o campo
  }

  input.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      addItem(input.value);
    }
  });

  input.addEventListener("blur", function () {
    addItem(input.value);
  });

  function updateSelectedItems() {
    selectedItems.innerHTML = "";
    selectedValues.forEach((value) => {
      const span = document.createElement("span");
      span.textContent = value;
      span.classList.add("tag");
      span.onclick = function () {
        selectedValues = selectedValues.filter((item) => item !== value);
        updateSelectedItems();
      };
      selectedItems.appendChild(span);
    });

    hiddenInput.value = selectedValues.join(", ");
  }
});
