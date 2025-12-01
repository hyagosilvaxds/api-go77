function themeConfig() {
    // Light & Dark
    if (localStorage.getItem('theme')) {
        if (localStorage.getItem('theme') === 'dark') {
            $("body").addClass("dark").removeClass("light");
            $(".btn[data-theme='dark']").parent().hide(); // Esconde o botão do tema dark
        } else if (localStorage.getItem('theme') === 'light') {
            $("body").addClass("light").removeClass("dark");
            $(".btn[data-theme='light']").parent().hide(); // Esconde o botão do tema light
        }
    } else {
        if (!$("body").hasClass("dark")) {
            $("body").addClass("light");
            $(".btn[data-theme='dark']").parent().hide(); // Esconde o botão do tema dark
        } else if ($("body").hasClass("dark")) {
            $("body").addClass("dark");
            $(".btn[data-theme='light']").parent().hide(); // Esconde o botão do tema light
        }
    }
}

themeConfig();


// Click Item
$(".hp-theme-customizer-container-body-item-svg").click(function () {
    // Verifica se o tema associado ao botão não está ativo
    if (!$(this).hasClass("active")) {
        // Ativa o tema associado ao botão clicado
        $(this).addClass("active");
        $(this).parent().siblings().children(".hp-theme-customizer-container-body-item-svg").removeClass("active");

        // Light & Dark
        if ($(this).data("theme") === "light") {
            localStorage.setItem('theme', 'light');
            $("body").addClass("light").removeClass("dark");
            $(".btn[data-theme='dark']").parent().show(); // Mostra o botão do tema dark
            $(".btn[data-theme='light']").parent().hide(); // Esconde o botão do tema light
        } else if ($(this).data("theme") === "dark") {
            localStorage.setItem('theme', 'dark');
            $("body").addClass("dark").removeClass("light");
            $(".btn[data-theme='light']").parent().show(); // Mostra o botão do tema light
            $(".btn[data-theme='dark']").parent().hide(); // Esconde o botão do tema dark
        }
    }
});



