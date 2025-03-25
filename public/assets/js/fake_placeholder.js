document.addEventListener("DOMContentLoaded", function () {
    // Detecta se o usuário está em um dispositivo iOS
    const isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);

    if (isIOS) {
        const dateInputs = document.querySelectorAll('input[type="date"], input[type="time"]');

        dateInputs.forEach(input => {
            // Adiciona a classe de estilo para os placeholders fake apenas no iOS
            input.classList.add("fake-placeholder-ios");

            // Define o placeholder fake no iOS
            input.addEventListener("focus", function () {
                this.classList.remove("fake-placeholder-ios");
            });

            input.addEventListener("blur", function () {
                if (!this.value) {
                    this.classList.add("fake-placeholder-ios");
                }
            });
        });
    }
});